<?php

if (!prometheus::loggedin()) {
    die('You must be signed in to purchase a package');
}

$error = false;
$msg = '';
$customjob = false;

if (!isset($_GET['uid'])) {
    $for = null;
} else {
    $for = $_GET['uid'];
}

if (isset($_GET['price'])) {
    $price = $_GET['price'];
} else {
    $price = null;
}

if ($_GET['type'] == 'pkg') {
    $verify = new verification('none', $for, $_GET['pid']);
    $verifyArray = $verify->verifyPackage($price);

    $error = $verifyArray['error'];
    $msg = $verifyArray['msg'];
}

$userEmail = null;
if(isset($_GET['gateway']) && $_GET['gateway'] == 'paymentwall') {
    $userEmail = $db->getOne("SELECT email FROM players WHERE uid = ?", $UID);
}

if(isset($_POST['email_submit'])){
    $error = false;

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $error = true;
        $message->add('danger', 'This email address is invalid!');
    }

    if(!$error) {
        $db->execute("UPDATE players SET email = ? WHERE uid = ?", [$_POST['email'], $UID]);
        $userEmail = $_POST['email'];
    }
}

?>


<?php if (prometheus::loggedin() && isset($_GET['pid']) && !isset($_GET['gateway']) && tos::getLast() > getSetting('tos_lastedited', 'value3')) { ?>
    <div class="header">
        <?= lang('select_gateway', 'Select payment method'); ?>
    </div>

    <?php $message->display(); ?>

    <div class="row">
        <?php if(getSetting('enable_coupons', 'value2') == 1 && $_GET['type'] == 'pkg' && getEditPackage($_GET['pid'], 'custom_price') == 0){ ?>
            <div class="col-md-<?php echo getSetting('buy_others', 'value2') == 1 ? '6' : '12'; ?>">
                <div class="info-box">
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <h2><?= lang('coupon_text'); ?></h2>
                        <input type="text" placeholder="..." class="form-control" name="coupon"
                               value="<?= isset($_GET['coupon']) ? $_GET['coupon'] : ''; ?>">
                        <input type="submit" class="btn btn-prom" value="<?= lang('submit'); ?>" style="margin-top: 5px;" name="coupon_submit">
                    </form>
                </div>
            </div>
        <?php } ?>

        <?php if (!$customjob && getSetting('buy_others', 'value2') == 1) { ?>
            <div class="col-md-<?php echo getSetting('enable_coupons', 'value2') == 1 ? '6' : '12'; ?>">
                <div class="info-box">
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <h2><?= lang('buying_someone_else'); ?></h2>
                        <input type="text" placeholder="Steam Community ID(7656119xxxxxxxxxx)" class="form-control" name="cuid"
                               value="<?= isset($_GET['uid']) ? $_GET['uid'] : ''; ?>">
                        <input type="submit" class="btn btn-prom" value="<?= lang('submit'); ?>" name="cuid_submit"
                               style="margin-top: 5px;">
                        <?php echo isset($_GET['uid']) ? '<br><br>' . lang('buying_for') . ' &nbsp;&nbsp;<img src="' . getUserSetting('steam_avatar', $_GET['uid']) . '" width="30px" height="30px"></img>&nbsp;&nbsp;' . getUserSetting('name', $_GET['uid']) . '' : '<br><br>' . lang('buying_yourself'); ?>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row">
        <?php

        if (!$error) {
            if (isset($_GET['uid']) && isBlacklisted($_GET['uid'])) {
                echo '<div class="col-xs-12">' . lang("blacklisted_them", "This person is blacklisted from this community, you can not purchase for them") . '</div>';
            } elseif (isset($_GET['uid']) && getSetting('buy_others', 'value2') == 0) {
                echo '<div class="col-xs-12">' . lang("buy_others_disabled", "Buying for others is disabled on this system") . '</div>';
            } else {
                $gateways = new gateways($_GET['type']);
                $gateways->setId($_GET['pid']);

                $gateways->setPrice($price);
                $gateways->setPlayer($for);

                echo $gateways->display();
            }
        } else {
            echo '<div class="col-xs-12">';
            echo '<h2>' . $msg . '</h2>';
            if (!$customjob) {
                echo '<br>' . lang('someone_else', 'However, you can still buy it for someone else');
            }
            echo '</div>';
        }

        ?>
    </div>
<?php } elseif (isset($_GET['pid']) && isset($_GET['gateway'])) { ?>

    <?php if (prometheus::loggedin()) { ?>

        <?php if ($_GET['gateway'] == 'stripe') { ?>
            <div class="col-sm-offset-2 header">
                Stripe
            </div>

            <?php

            $success = false;

            if (isset($_GET['uid'])) {
                $uid = $_GET['uid'];
            } else {
                $uid = $_SESSION['uid'];
            }

            if (isset($_GET['price'])) {
                $price = $_GET['price'];
            } else {
                $price = null;
            }

            if (isset($_POST['stripeToken'])) {
                $token = $_POST['stripeToken'];

                stripe::pay($token, $_GET['type'], $_GET['pid'], $uid, $price);

                util::redirect('profile.php?cm');
                $success = true;
            }

            $message->display();
            ?>

            <?php if (!$success) { ?>
                <form action="" method="POST" id="payment-form" class="form-horizontal" role="form">
                    <!-- Add a section to display errors if you want -->
                    <div class="col-sm-offset-2">
                        <span class='payment-errors'></span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Full name</label>

                        <div class="col-sm-9">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Firstname Lastname"
                                   data-stripe="name"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="The name your card is associated with">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Card number</label>

                        <div class="col-sm-9">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Card number"
                                   data-stripe="number"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="Your credit card/debit card number. xxxx-xxxx-xxxx-xxxx">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">CVC</label>

                        <div class="col-sm-9">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Card CVC"
                                   data-stripe="cvc"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="The CVC code on your card">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Expire month</label>

                        <div class="col-sm-9">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Expire month (Number)"
                                   data-stripe="exp-month"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="The expire month of your card (01 format)">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Expire year</label>

                        <div class="col-sm-9">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Expire year (Number)"
                                   data-stripe="exp-year"/>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="The expire year of your credit card (last two digits)">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Billing Address</label>

                        <div class="col-sm-7">
                            <input class="form-control" style="margin-top: 5px;" placeholder="Billing Address"
                                   data-stripe="data-billing-address"/>
                        </div>

                        <div class="col-sm-2">
                            <input class="form-control" style="margin-top: 5px;" placeholder="ZIP Code"
                                   data-stripe="data-zip-code"/>
                        </div>

                        <div class="col-sm-1">
                            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                                    title="The place of residence and zip code">?
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>

                        <div class="col-sm-10">
                            <button class="btn btn-prom" style="margin-top: 5px;" type="submit">Submit Payment</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Disclaimer</h2>
                            Stripe information is not stored or collected on this website. It is directly passed to
                            Stripe's website to avoid security issues. This form is completely safe and no details are
                            ever stored in our system.
                        </div>
                    </div>
                </form>

                <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

                <script type="text/javascript">
                    Stripe.setPublishableKey("<?php echo getSetting('stripe_publishableKey', 'value'); ?>");

                    var stripeResponseHandler = function (status, response) {
                        var $form = $('#payment-form');

                        if (response.error) {
                            // Show the errors on the form
                            $form.find('.payment-errors').html('<p class="bs-callout bs-callout-danger alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' + response.error.message + '</p>');
                            $form.find('button').prop('disabled', false);
                        } else {
                            // token contains id, last4, and card type
                            var token = response.id;
                            // Insert the token into the form so it gets submitted to the server
                            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                            // and re-submit
                            $form.get(0).submit();
                        }
                    };

                    jQuery(function ($) {
                        $('#payment-form').submit(function (e) {
                            var $form = $(this);

                            // Disable the submit button to prevent repeated clicks
                            $form.find('button').prop('disabled', true);

                            Stripe.card.createToken($form, stripeResponseHandler);

                            // Prevent the form from submitting with the default action
                            return false;
                        });
                    });
                </script>
            <?php } ?>
        <?php } ?>

        <?php if ($_GET['gateway'] == 'paymentwall' && $userEmail !== null) { ?>
            <div class="header">
                Paymentwall
            </div>

            <?php

            if (isset($_GET['uid'])) {
                $uid = $_GET['uid'];
            } else {
                $uid = $_SESSION['uid'];
            }

            echo paymentwall::displayWidget($_GET['pid'], $_GET['uid'], $_GET['type']);

            ?>
        <?php } ?>

        <?php if ($_GET['gateway'] == 'paymentwall' && $userEmail == null) { ?>
            <div class="header">
                Paymentwall
            </div>

            <?php $message->display(); ?>

            <form method="POST">
                <div class="form-group">
                    We need your email address before we continue
                </div>

                <div class="form-group">
                    <input type="email" placeholder="Email" class="form-control" name="email">
                </div>

                <input type="submit" name="email_submit" class="btn btn-default" value="<?= lang('submit'); ?>">
            </form>
        <?php } ?>

        <?php if ($_GET['gateway'] == 'paysafecard') { ?>
            <div class="header">
                Paysafecard
            </div>

            Not implemented yet
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <div class="header">
        Invalid
    </div>
    Either you have no package id set, or you are not signed in!
<?php } ?>