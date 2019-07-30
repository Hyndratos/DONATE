<?php

class paymentwall
{
    public static function displayWidget($item_id, $uid, $type)
    {
        global $db;

        Paymentwall_Config::getInstance()->set(array(
            'api_type' => Paymentwall_Config::API_GOODS,
            'public_key' => getSetting('paymentwall_projectKey', 'value'),
            'private_key' => getSetting('paymentwall_secretKey', 'value')
        ));

        $coupon = false;
        if(isset($_GET['coupon']))
            $coupon = $_GET['coupon'];

        $price = '';
        $item_name = '';

        $curID = getSetting('dashboard_main_cc', 'value2');
        $currency = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $curID);

        $verify = new verification('paymentwall', $uid, $item_id, $coupon);

        if ($type == 'credits') {
            $price = $db->getOne("SELECT price FROM credit_packages WHERE id = ?", $item_id);
            $item_name = $db->getOne("SELECT title FROM credit_packages WHERE id = ?", $item_id);
        }

        if ($type == 'raffle') {
            $price = $db->getOne("SELECT price FROM raffles WHERE id = ?", $item_id);
            $item_name = $db->getOne("SELECT title FROM raffles WHERE id = ?", $item_id);
        }

        if ($type == 'pkg') {
            $price = $verify->getPrice('package');

            $custom_price = $db->getOne("SELECT custom_price FROM packages WHERE id = ?", $item_id);
            if ($price == 0 && $custom_price == 1) {
                $price = $_GET['price'];
            }

            $item_name = $db->getOne("SELECT title FROM packages WHERE id = ?", $item_id);
        }

        $playerInfo = $db->getOne("SELECT * FROM players WHERE uid = ?", $uid);
        $num_delivered = $db->getOne("SELECT count(*) AS value FROM transactions WHERE uid = ? AND email != 'Assigned by Admin' AND gateway = 'paymentwall'", $uid);

        $widget = new Paymentwall_Widget(
            $uid,
            getSetting('paymentwall_widgetID', 'value'),
            array(
                new Paymentwall_Product(
                    $item_id,
                    $price,
                    $currency,
                    $item_name,
                    Paymentwall_Product::TYPE_FIXED
                )
            ),
            array(
                'cur' => $currency,
                'coupon' => $coupon,
                'goodstype' => $type,
                'price' => $price,
                'customer[username]' => $uid,
                'history[payments_amount]' => $price,
                'history[registration_ip]' => $_SERVER['REMOTE_ADDR'],
                'history[delivered_products]' => $num_delivered,
                'history[was_banned]' => 0,
                'history[registration_date]' => $playerInfo['created_at'],
                'email' => $playerInfo['email']
            )
        );

        return $widget->getHtmlCode();
    }
}