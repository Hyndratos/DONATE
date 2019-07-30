<?php
$depends = [
    'paymentwall'
];

include('inc/functions.php');

Paymentwall_Base::setApiType(Paymentwall_Base::API_GOODS);
Paymentwall_Base::setAppKey(getSetting('paymentwall_projectKey', 'value'));
Paymentwall_Base::setSecretKey(getSetting('paymentwall_secretKey', 'value'));

$pingback = new Paymentwall_Pingback($_GET, $_SERVER['REMOTE_ADDR']);

if ($pingback->validate(true)) {
    $itemID = $pingback->getProduct()->getId();
    $uid = $pingback->getUserId();
    $txn_id = $pingback->getReferenceId();

    $stmt = $db->getOne("SELECT * FROM paymentwall_refids WHERE ref = ?", $txn_id);
    if($stmt){
        $errHead = 'HTTP/1.0 401 Unauthorized';
        header($errHead);

        exit('Duplicate reference ID');
    }

    $db->execute("INSERT IGNORE INTO paymentwall_refids(ref) VALUES(?)", $txn_id);

    $coupon = false;
    if(isset($_GET['coupon'])){
        $coupon = $_GET['coupon'];

        coupon::useCoupon($coupon);
    }

    $verify = new verification('paymentwall', $uid, $itemID, $coupon);

    if ($uid == 0)
        die('Attempted Steam64ID fraud');

    $item_price = null;
    if (isset($_GET['price']))
        $item_price = $_GET['price'];

    $item_currency = null;
    if (isset($_GET['cur']))
        $item_currency = $_GET['cur'];

    $type = 'pkg';
    if (isset($_GET['goodstype']))
        $type = $_GET['goodstype'];

    $fail = '';

    if ($pingback->isDeliverable()) {
        // deliver the product

        $curID = getSetting('dashboard_main_cc', 'value2');
        $currency = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $curID);

        if ($type == 'pkg') {
            $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);

            $price = $verify->getPrice('package');

            $txn_exists = $db->getAll("SELECT * FROM transactions WHERE txn_id = ?", $txn_id);
            if ($txn_exists)
                die('Can not reuse the transaction ID!');

            if ($item_currency == $currency && $item_price == $price or
                $item_currency == $currency && getEditPackage($itemID, 'custom_price') == 1 && $item_price >= getEditPackage($itemID, 'custom_price_min')) {

                $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, package = ?, currency = ?, price = ?, txn_id = ?, gateway = 'paymentwall'",
                    array($name, $name, '', $uid, $itemID, $currency, $item_price, $txn_id));
                $trans = $db->getOne("SELECT id FROM transactions WHERE txn_id = ?", $txn_id);

                $p_array = array(
                    "id" => $itemID,
                    "trans_id" => $trans,
                    "uid" => $uid,
                    "type" => 1
                );
                addAction($p_array);
            } else {
                $fail .= ' FAIL: SECURITY CHECK';
            }
        }

        if ($type == 'credits') {
            $price = $db->getOne("SELECT price FROM credit_packages WHERE id = ?", $itemID);
            $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);
            $credits = $db->getOne("SELECT amount FROM credit_packages WHERE id = ?", $itemID);

            if ($item_currency == $currency && $item_price == $price) {
                $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, credit_package = ?, currency = ?, price = ?, credits = ?, txn_id = ?, gateway = 'paymentwall'", array(
                    $name, $name, '', $uid, $itemID, $currency, $item_price, $credits, $txn_id
                ));

                $credits_old = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);
                $credits_new = $credits_old + $credits;
                credits::set($uid, $credits_new);

                $p_array = array(
                    "id" => 0,
                    "trans_id" => 0,
                    "uid" => $uid,
                    "amount" => $credits,
                    "type" => 2
                );
                addAction($p_array);
            }
        }

        if ($type == 'raffle') {
            $price = $db->getOne("SELECT price FROM raffles WHERE id = ?", $itemID);
            $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);
            $credits = $db->getOne("SELECT credits FROM raffles WHERE id = ?", $itemID);

            $count = $db->getOne("SELECT count(*) AS value FROM raffle_tickets WHERE raffle_id = ?, uid = ?", array($itemID, $uid))['value'];
            $max_per_person = $db->getOne("SELECT max_per_person FROM raffles WHERE id = ?", [$itemID])['max_per_person'];

            if ($count != $max_per_person) {
                $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, raffle_package = ?, currency = ?, price = ?, credits = ?, txn_id = ?, gateway = 'paymentwall'", array(
                    $name, $name, '', $uid, $itemID, $currency, $item_price, $credits, $txn_id
                ));

                $db->execute("INSERT INTO raffle_tickets SET raffle_id = ?, uid = ?", array($itemID, $uid));
            }
        }

        $f = fopen('paymentwall.txt', 'a');
        fwrite($f, 'ItemID: ' . $itemID . ' Type: ' . $type . ' UID: ' . $uid . ' GET CUR: ' . $_GET['cur'] . ' GET PRICE: ' . $_GET['price'] . $fail . chr(13) . chr(10));
        fclose($f);
    } elseif ($pingback->isCancelable()) {

        if ($type == 'pkg') {
            $db->execute("UPDATE actions SET active = 0, delivered = 0 WHERE uid = ? AND package = ?", [$uid, $itemID]);

            $db->execute("DELETE * FROM transactions WHERE txn_id = ?", $txn_id);
            prometheus::log('Package disabled due to a chargeback!', $uid);
        }

        if ($type == 'credits') {
            $credits_amt = $db->getOne("SELECT amount FROM credit_packages WHERE id = ?", $itemID);
            $credits_has = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);

            $amt = $credits_has - $credits_amt;

            credits::set($uid, $amt);

            $db->execute("UPDATE actions SET active = 0, delivered = 0 WHERE uid = ?", $uid);
            $db->execute("DELETE * FROM transactions WHERE txn_id = ?", $txn_id);

            prometheus::log($credits_amt . ' credits revoked due to a chargeback!', $uid);
            prometheus::log('All packages revoked due to a chargeback!', $uid);
        }

    }

    cache::clear();

    echo 'OK'; // Paymentwall expects response to be OK, otherwise the pingback will be resent
} else {
    echo $pingback->getErrorSummary();
    $f = fopen('paymentwall.txt', 'a');
    fwrite($f, $pingback->getErrorSummary() . chr(13) . chr(10));
    fclose($f);
}
