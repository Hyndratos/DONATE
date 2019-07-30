<?php

if (!permissions::has("gateways")) {
    die(lang('no_perm'));
}

if (isset($_POST['paypal_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    if (isset($_POST['enable_paypal'])) {
        $enable_paypal = true;
    } else {
        $enable_paypal = false;
    }

    if ($enable_paypal && gateways::enabled('paypal')) {
        $paypal_email = strip_tags($_POST['paypal_email']);
        $paypal_return = strip_tags($_POST['paypal_return']);
        $paypal_cancel = strip_tags($_POST['paypal_cancel']);
        $paypal_ipn = strip_tags($_POST['paypal_ipn']);

        $paypal_type = $_POST['paypal_type'];

        if (isset($_POST['paypal_sandbox'])) {
            $paypal_sandbox = 1;
        } else {
            $paypal_sandbox = 0;
        }

        setSetting($paypal_email, 'paypal_email', 'value');
        setSetting($paypal_return, 'paypal_return', 'value');
        setSetting($paypal_cancel, 'paypal_cancel', 'value');
        setSetting($paypal_ipn, 'paypal_ipn', 'value');
        setSetting($paypal_type, 'paypal_type', 'value2');
        setSetting($paypal_sandbox, 'paypal_sandbox', 'value2');
    } else {
        gateways::setState('paypal', false);
    }

    if ($enable_paypal && !gateways::enabled('paypal')) {
        gateways::setState('paypal', true);
    }

    $message->Add('success', 'Successfully updated paypal settings!');
    prometheus::log('Modified the PayPal settings', $_SESSION['uid']);

    cache::clear('settings');
}

?>

<h2>PayPal</h2>
PayPal Payment Gateway settings. PayPal is the main payment gateway of Prometheus. It is recommended that you use PayPal instead of Paymentwall as it's easier for you to set up.
<br><br>
<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-12">
            <?php $message->Display(); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" name="enable_paypal" <?php echo gateways::enabled('paypal') ? 'checked' : ''; ?>>
                <label>Enable PayPal</label>
            </div>
        </div>
    </div>
    <?php if (gateways::enabled('paypal')) { ?>
        <hr>
        <div class="form-group">
            <label class="col-sm-2 control-label">Paypal Email</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="paypal_email" placeholder="Paypal Email"
                       value="<?= getSetting('paypal_email', 'value'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Return URL</label>

            <div class="col-sm-9">
                <input type="text" class="form-control" name="paypal_return"
                       placeholder="Default: http://yoursite.com/donate/profile.php"
                       value="<?= getSetting('paypal_return', 'value'); ?>">
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="This is the URL you want to direct your users to after a successfull payment.">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Cancel URL</label>

            <div class="col-sm-9">
                <input type="text" class="form-control" name="paypal_cancel"
                       placeholder="Default: http://yoursite.com/donate/"
                       value="<?= getSetting('paypal_cancel', 'value'); ?>">
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="This is the URL you want to direct your users to if they cancel a payment.">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">IPN URL</label>

            <div class="col-sm-9">
                <input type="text" class="form-control" name="paypal_ipn"
                       placeholder="Default: http://yoursite.com/donate/ipn.php"
                       value="<?= getSetting('paypal_ipn', 'value'); ?>">
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="This is the URL to the ipn.php file on your webserver where this installation is.">?
                </button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Payment Type</label>

            <div class="col-sm-9">
                <select name="paypal_type" class="form-control">
                    <?php
                    if (getSetting('paypal_type', 'value2') == 2) {
                        echo '
								<option value="2">Donations (_donations) WARNING: WITH MISUSE PAYPAL CAN LOCK YOUR ACCOUNT!</option>
								<option value="1">Normal Payment(_xclick)</option>
							';
                    } else {
                        echo '
								<option value="1">Normal Payment(_xclick)</option>
								<option value="2">Donations (_donations) WARNING: WITH MISUSE PAYPAL CAN LOCK YOUR ACCOUNT!</option>
							';
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="Payments via PayPal can be sent either as a donation, or as a payment. Donations can not be chargebacked through PayPal.">
                    ?
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <div class="checkbox">
                    <input type="checkbox"
                           name="paypal_sandbox" <?php echo getSetting('paypal_sandbox', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Sandbox mode</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Sandbox is PayPal's testing grounds. Enable this to test if your settings work!">?
                </button>
            </div>
        </div>
        <hr>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-10">
            <input type="submit" name="paypal_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
    </div>
</form>