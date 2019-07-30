<?php

class stripe
{
    public static function pay($token, $type, $pid, $uid, $q_price = null)
    {
        global $db;

        if ($uid == 0) {
            die('Attempted Steam64ID fraud');
        }

        $api_key = getSetting('stripe_apiKey', 'value');

        $bad = false;

        \Stripe\Stripe::setApiKey($api_key);

        $coupon = false;
        if(isset($_GET['coupon'])){
            $coupon = $_GET['coupon'];
            coupon::useCoupon($coupon);
        }

        $verify = new verification('stripe', $uid, $pid, $coupon);

        if ($type == 'pkg') {
            $res = $db->getAll("SELECT * FROM packages WHERE id = ?", $pid);

            foreach ($res as $row) {
                $title = $row['title'];
                $custom_price = $row['custom_price'];
                $custom_price_min = $row['custom_price_min'];
            }

            if ($custom_price == 1) {
                $price = $q_price;
            } else {
                $price = $verify->getPrice('package');
            }

            if ($custom_price == 1 && $custom_price_min > $q_price) {
                $bad = true;
            }
        }

        if ($type == 'credits') {
            $res = $db->getAll("SELECT * FROM credit_packages WHERE id = ?", $pid);

            foreach ($res as $row) {
                $title = $row['title'];
                $price = $row['price'];
            }
        }

        if ($type == 'raffle') {
            $res = $db->getAll("SELECT * FROM raffles WHERE id = ?", $pid);

            foreach ($res as $row) {
                $title = $row['title'];
                $price = $row['price'];
                $cur = $row['currency'];
                $credits = $row['credits'];
            }
        }

        $curID = getSetting('dashboard_main_cc', 'value2');
        $currency = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $curID);

        $charge_price = $price * 100;

        if (!$bad) {
            $charge = \Stripe\Charge::create(array(
                "amount" => $charge_price,
                "currency" => $currency,
                "source" => $token,
                "description" => $title,
                "metadata" => array("type" => $type, "price" => $price, "itemID" => $pid)
            ));

            $charge = $charge->__toJSON();

            //die(var_dump($charge));

            if (isset($charge)) {
                $arr = json_decode($charge, true);

                if ($arr['status'] == 'succeeded' && $arr['paid'] == true) {
                    $itemID = $pid;
                    $txn_id = $arr['id'];

                    if ($type == 'pkg') {
                        $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);

                        $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, package = ?, currency = ?, price = ?, txn_id = ?, gateway = 'stripe'",
                            array($name, $name, '', $uid, $itemID, $currency, $price, $txn_id));
                        $trans = $db->getOne("SELECT id FROM transactions WHERE txn_id = ?", $txn_id);

                        $p_array = array(
                            "id" => $itemID,
                            "trans_id" => $trans,
                            "uid" => $uid,
                            "type" => 1
                        );
                        addAction($p_array);
                    }

                    if ($type == 'credits') {
                        $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);
                        $credits = $db->getOne("SELECT amount FROM credit_packages WHERE id = ?", $itemID);

                        $verify->getPrice('credits');

                        $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, credit_package = ?, currency = ?, price = ?, credits = ?, txn_id = ?, gateway = 'stripe'", array(
                            $name, $name, '', $uid, $itemID, $currency, $price, $credits, $txn_id
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

                    if ($type == 'raffle') {
                        $name = $db->getOne("SELECT name FROM players WHERE uid = ?", $uid);
                        $credits = $db->getOne("SELECT credits FROM raffles WHERE id = ?", $itemID);

                        $verify->getPrice('raffle');

                        $count = $db->getOne("SELECT count(*) AS value FROM raffle_tickets WHERE raffle_id = ?, uid = ?", array($itemID, $uid))['value'];
                        $max_per_person = $db->getOne("SELECT max_per_person FROM raffles WHERE id = ?", [$itemID])['max_per_person'];

                        if ($count != $max_per_person) {
                            $db->execute("INSERT INTO transactions SET name = ?, buyer = ?, email = ?, uid = ?, raffle_package = ?, currency = ?, price = ?, credits = ?, txn_id = ?, gateway = 'stripe'", array(
                                $name, $name, '', $uid, $itemID, $currency, $price, $credits, $txn_id
                            ));

                            $db->execute("INSERT INTO raffle_tickets SET raffle_id = ?, uid = ?", array($itemID, $uid));
                        }
                    }
                }
            }

            cache::clear('purchase', $uid);
        }
    }
}
