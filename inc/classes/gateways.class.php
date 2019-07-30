<?php

class gateways
{
    protected $id;
    protected $price;
    protected $type;
    protected $player;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPrice($price = null)
    {
        $this->price = $price;
    }

    public function setPlayer($for = null)
    {
        $this->player = $for;
    }

    public function display()
    {
        global $db;

        $pid = $this->id;
        $price = $this->price;

        if ($this->player == null)
            $uid = $_SESSION['uid'];
        else
            $uid = $this->player;

        $type = $this->type;

        $gateways = getSetting('payment_gateways', 'value');
        $gateways = json_decode($gateways, true);
        $ret = '';

        $alternative_pp = '';

        $free = false;

        $cur = getSetting('dashboard_main_cc', 'value2');
        $cc = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $cur);

        if ($type == 'pkg') {
            $res = $db->getAll("SELECT * FROM packages WHERE id = ? AND enabled = 1", $pid);

            $coupon = false;
            if(isset($_GET['coupon']))
                $coupon = $_GET['coupon'];

            $verify = new verification('none', $uid, $pid, $coupon);

            foreach ($res as $row) {
                $title = $row['title'];

                if ($price == null)
                    $price = $verify->getPrice('package');

                $credits = $row['credits'];
                $custom_price = $row['custom_price'];
                $alternative_pp = $row['alternative_paypal'];

                $permanent = $row['permanent'];
                $subscription = $row['subscription'];
                $days = $row['days'];
            }

            if(Gateways::enabled('credits') && getSetting('credits_only', 'value2') == 0 && ($price == 0 or $credits == 0 && $custom_price == 0)
                or Gateways::enabled('credits') && getSetting('credits_only', 'value2') == 1 && $credits == 0
                or !Gateways::enabled('credits') && $price == 0 && $custom_price == 0)
                $free = true;

            $pp_title_type = 'package';
            $pp_title = '<input type="hidden" name="item_name" value="Package - ' . $title . ' - ' . convertCommunityIdToSteamId($uid) . '">';
            $credits_link = '
					<input type="hidden" name="type" value="package">
					<input type="hidden" name="itemID" value="' . $pid . '">
				';

            $ret .= packages::getPreview($pid, $coupon);
        }

        if(!$free){
            if ($type == 'credits') {
                $res = $db->getAll("SELECT * FROM credit_packages WHERE id = ?", $pid);

                foreach ($res as $row) {
                    $title = $row['title'];
                    $price = $row['price'];
                }

                $custom_price = 0;

                $pp_title_type = 'credits';
                $pp_title = '<input type="hidden" name="item_name" value="Credit package - ' . $title . ' - ' . convertCommunityIdToSteamId($uid) . '">';

                $ret .= '
    					<div class="col-xs-12">
    						<h2>Credit package: ' . $title . '</h2>
    					</div>
    				';
            }

            if ($type == 'raffle') {
                $res = $db->getAll("SELECT * FROM raffles WHERE id = ?", $pid);

                foreach ($res as $row) {
                    $title = $row['title'];
                    $price = $row['price'];
                    $credits = $row['credits'];
                }


                $custom_price = 0;

                $pp_title_type = 'raffle';
                $pp_title = '<input type="hidden" name="item_name" value="Raffle ticket - ' . $title . '">';
                $credits_link = '
    					<input type="hidden" name="type" value="raffle">
    					<input type="hidden" name="itemID" value="' . $pid . '">
    				';

                $ret .= '
    					<div class="col-xs-12">
    						<h2>Raffle package: ' . $title . '</h2>
    					</div>
    				';
            }

            $modules = 0;
            $credits_only = getSetting('credits_only', 'value2');

            foreach ($gateways as $key => $value) {
                $key = ucfirst($key);

                if ($key == 'Paypal' && $credits_only == 0
                    or $key == 'Paypal' && $type == 'credits'
                ) {
                    if (getSetting('paypal_sandbox', 'value2') == 1) {
                        $paypal_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                    } else {
                        $paypal_link = 'https://www.paypal.com/cgi-bin/webscr';
                    }

                    if (getSetting('paypal_type', 'value2') == 1) {
                        $pp_type = '_xclick';
                    }

                    if (getSetting('paypal_type', 'value2') == 2) {
                        $pp_type = '_donations';
                    }

                    $extra_fields = '';
                    if ($type == 'pkg' && $permanent == 0 && $subscription == 1) {
                        $pp_type = '_xclick-subscriptions';

                        $p3 = $days;
                        $t3 = 'D';

                        /*
                         * max amount of x in each category. W is not the same as D. W is $days * $_t3['W']
                         */
                        $_ranges = [
                            'D' => 90,
                            'W' => 52,
                            'M' => 24,
                            'Y' => 5,
                        ];

                        /*
                         * amount of days in each t3 category
                         */
                        $_t3 = [
                            'D' => 1,
                            'W' => 7,
                            'M' => 30,
                            'Y' => 365,
                        ];

                        /**
                         * Figure out what $t3 and $p3 to use
                         */
                        foreach($_ranges as $k => $max){
                            // since D is highest, if $days is less than $max then just set $p3 and $t3 and break out of this loop
                            if($days < $max){
                                $p3 = $days;
                                $t3 = $k;

                                break;
                            }

                            // otherwise if that's not the case, we need to reduce the $days number somehow and choose a new $t3
                            $_t3_days = $_t3[$k];

                            // if we can divide $days by $_t3_days successfully then we can set $p3 and $t3 right now. do not break because we can keep lowering as far as we can go.
                            if($days % $_t3_days === 0){
                                $p3 = $days / $_t3_days;
                                $t3 = $k;
                            } else {
                                // if we do have a remainder however, we need to do some weird shit because some numbers are just invalid ok
                                $remainder = $days % $_t3_days;
                                $days_temp = ($days - $remainder) / $_t3_days;

                                // only set this value if it's less than $max, if not we retry in the next iteration
                                if($days_temp < $max && $days_temp !== 0){
                                    $p3 = $days_temp;
                                    $t3 = $k;
                                }
                            }
                        }

                        // p3 = amount of days/weeks/months/years
                        // t3 = D/W/M/Y

                        $extra_fields = '
    							<input type="hidden" name="a3" value="' . $price . '">
    							<input type="hidden" name="p3" value="' . $p3 . '">
    							<input type="hidden" name="t3" value="' . $t3 . '">
    							<input type="hidden" name="src" value="1">
    							<input type="hidden" name="sra" value="1">
    							<input type="hidden" name="srt" value="52">
    							<input type="hidden" name="no-note" value="1">
    						';
                    }

                    if ($alternative_pp == '')
                        $pp_email = getSetting('paypal_email', 'value');
                    else
                        $pp_email = $alternative_pp;

                    if ($value) {
                        $modules = 1;

                        $coupon = '';
                        if(isset($_GET['coupon'])){
                            $coupon = '|'.$_GET['coupon'];
                        }

                        $pp_title_type = '|' . $pp_title_type;

                        $item_number = 000 + $pid;

                        $ret .= '
    							<div class="col-xs-4">
    								<form method="post" name="' . $pp_type . '" action="' . $paypal_link . '" id="purchaseForm">
    									<div class="srv-box">
    										<i class="fa fa-paypal fa-4x" style="margin-bottom: 30px;"></i>
    										<input type="hidden" name="cmd" value="' . $pp_type . '">
    										' . $pp_title . '
    										<input type="hidden" name="business" value="' . $pp_email . '">

    										<input type="hidden" name="item_number" value="' . $item_number . '">
    										' . $extra_fields . '
    										<input type="hidden" name="no_shipping" value="1">
    										<input type="hidden" name="lc" value="US">
    										<input type="hidden" name="currency_code" value="' . $cc . '">
    										<input type="hidden" name="amount" value="' . $price . '">
    										<input type="hidden" name="handling" value="0">
    										<input type="hidden" name="custom" value="' . $uid . $pp_title_type . $coupon . '">
    										<input type="hidden" name="cancel_return" value="' . getSetting('paypal_cancel', 'value') . '">
    										<input type="hidden" name="return" value="' . getSetting('paypal_return', 'value') . '">
    										<input type="hidden" name="rm" value="2">
    										<input type="hidden" name="notify_url" value="' . getSetting('paypal_ipn', 'value') . '">
    										<button name="submit" class="btn buy-btn">' . lang('purchase_paypal') . '</button>
    									</div>
    								</form>
    							</div>
    						';
                    }
                } elseif ($key == 'Paymentwall' && $credits_only == 0
                    or $key == 'Paymentwall' && $type == 'credits'
                ) {
                    if ($custom_price == 0) {
                        $coupon = '';
                        if(isset($_GET['coupon'])){
                            $coupon = '&coupon=' . $_GET['coupon'];
                        }

                        $link = 'store.php?page=purchase&gateway=paymentwall&type=' . $type . '&pid=' . $pid . '&uid=' . $uid . $coupon;
                    } else {
                        $link = 'store.php?page=purchase&gateway=paymentwall&type=' . $type . '&pid=' . $pid . '&uid=' . $uid . '&price=' . $price;
                    }

                    if ($value) {
                        $modules = 1;

                        $ret .= '
    							<div class="col-xs-4">
    								<div class="srv-box">
    									<i class="fa fa-dollar fa-4x" style="margin-bottom: 30px;"></i>
    									<a href="' . $link . '" class="btn buy-btn">' . lang('paymentwall_purchase', 'Purchase with Paymentwall') . '</a>
    								</div>
    							</div>
    						';
                    }
                } elseif ($key == 'Paysafecard' && $credits_only == 0
                    or $key == 'Paysafecard' && $type == 'credits'
                ) {
                    if ($custom_price == 0) {
                        $link = 'store.php?page=purchase&gateway=paysafecard&type=' . $type . '&pid=' . $pid . '&uid=' . $uid;
                    } else {
                        $link = 'store.php?page=purchase&gateway=paysafecard&type=' . $type . '&pid=' . $pid . '&uid=' . $uid . '&price=' . $price;
                    }

                    if ($value) {
                        $modules = 1;

                        $ret .= '
    							<div class="col-xs-4">
    								<div class="srv-box">
    									<img src="img/gateways/paysafecard.png" width="60%" style="padding-bottom: 20px; padding-top: 10px;">
    									<a href="' . $link . '" class="btn buy-btn">' . lang('purchase_paysafecard', 'Purchase with Paysafecard') . '</a>
    								</div>
    							</div>
    						';
                    }
                } elseif ($key == 'Stripe' && $credits_only == 0
                    or $key == 'Stripe' && $type == 'credits'
                ) {
                    if ($custom_price == 0) {
                        $coupon = '';
                        if(isset($_GET['coupon'])){
                            $coupon = '&coupon=' . $_GET['coupon'];
                        }

                        $link = 'store.php?page=purchase&gateway=stripe&type=' . $type . '&pid=' . $pid . '&uid=' . $uid . $coupon;
                    } else {
                        $link = 'store.php?page=purchase&gateway=stripe&type=' . $type . '&pid=' . $pid . '&uid=' . $uid . '&price=' . $price;
                    }

                    if ($value) {
                        $modules = 1;

                        $ret .= '
    							<div class="col-xs-4">
    								<div class="srv-box">
    									<i class="fa fa-credit-card fa-4x" style="margin-bottom: 30px;"></i>
    									<a href="' . $link . '" class="btn buy-btn">' . lang('stripe_purchase', 'Purchase with Stripe') . '</a>
    								</div>
    							</div>
    						';
                    }
                } elseif ($key == 'Credits' && $custom_price == 0 && $type != 'credits') {
                    if ($value) {
                        $modules = 1;

                        $coupon = '';
                        if(isset($_GET['coupon'])){
                            $coupon = '<input type="hidden" name="coupon" value="' . $_GET['coupon'] . '">';
                        }

                        $ret .= '
    							<div class="col-xs-4">
    								<form method="POST" action="inc/credits.php" id="c_form">
                                        <input type="hidden" name="csrf_token" value="'. csrf_token() .'">
    									<div class="srv-box">
    										<i class="fa fa-money fa-4x" style="margin-bottom: 30px;"></i>
    										' . $credits_link . '
    										<input type="hidden" name="uid" value="' . $uid . '">
                                            '.$coupon.'
    										<button name="submit" class="btn buy-btn">' . lang('purchase_credits') . '</button>
    									</div>
    								</form>
    							</div>
    						';
                    }
                }
            }
        } else {
            $modules = 1;
            
            $ret .= '
                <div class="col-xs-12">
                    <form method="POST" action="inc/credits.php">
                        <input type="hidden" name="csrf_token" value="'. csrf_token() .'">
                        <div class="srv-box">
                            <i class="fa fa-money fa-4x" style="margin-bottom: 30px;"></i>
                            <input type="hidden" name="type" value="package">
                            <input type="hidden" name="itemID" value="' . $pid . '">
                            <input type="hidden" name="uid" value="' . $uid . '">
                            <button name="submit" class="btn buy-btn">' . lang('free') . '</button>
                        </div>
                    </form>
                </div>
            ';
        }

        if ($modules == 0) {
            $ret .= '
					<div class="col-xs-12">
						There are no payment gateways available for this item!
					</div>
				';
        }

        return $ret;
    }

    public static function enabled($check)
    {
        global $db;

        $gateways = getSetting('payment_gateways', 'value');
        $gateways = json_decode($gateways, true);

        if ($gateways[$check] == true) {
            return true;
        } else {
            return false;
        }
    }

    public static function setState($gateway, $state)
    {
        global $db;

        $gateways = getSetting('payment_gateways', 'value');
        $gateways = json_decode($gateways, true);

        $gateways[$gateway] = $state;

        $gateways = json_encode($gateways);

        setSetting($gateways, 'payment_gateways', 'value');
    }
}