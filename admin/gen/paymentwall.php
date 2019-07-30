<?php

if (!permissions::has("gateways")) {
    die(lang('no_perm'));
}

if (isset($_POST['paymentwall_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    if (isset($_POST['enable_paymentwall'])) {
        $enable_paymentwall = true;
    } else {
        $enable_paymentwall = false;
    }

    if ($enable_paymentwall && gateways::enabled('paymentwall')) {
        // Do success stuff
        $paymentwall_project = strip_tags($_POST['paymentwall_project']);
        $paymentwall_secret = strip_tags($_POST['paymentwall_secret']);
        $paymentwall_widgetID = strip_tags($_POST['paymentwall_widgetID']);
        $paymentwall_reviewKey = strip_tags($_POST['paymentwall_reviewKey']);

        setSetting($paymentwall_project, 'paymentwall_projectKey', 'value');
        setSetting($paymentwall_secret, 'paymentwall_secretKey', 'value');
        setSetting($paymentwall_widgetID, 'paymentwall_widgetID', 'value');
        setSetting($paymentwall_reviewKey, 'paymentwall_reviewKey', 'value');

    } else {
        gateways::setState('paymentwall', false);
    }

    if ($enable_paymentwall && !gateways::enabled('paymentwall')) {
        gateways::setState('paymentwall', true);
    }

    $message->Add('success', 'Successfully updated paymentwall settings!');
    prometheus::log('Modified the paymentwall settings', $_SESSION['uid']);

    cache::clear('settings');
}

?>

<h2>Paymentwall</h2>
Paymentwall Payment Gateway settings. Paymentwall allows you to pay with a Credit Card, Mobile Payments and so much more. It does require an extra bit of configuration to get working however. Read about this on the
<a href="http://wiki.prometheusipn.com/">wiki</a><br><br>
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
                <input type="checkbox"
                       name="enable_paymentwall" <?php echo gateways::enabled('paymentwall') ? 'checked' : ''; ?>>
                <label>Enable Paymentwall</label>
            </div>
        </div>
    </div>
    <?php if (gateways::enabled('paymentwall')) { ?>
        <hr>
        <div class="form-group">
            <label class="col-sm-2 control-label">Project Key</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="paymentwall_project" placeholder="Paymentwall Project Key"
                       value="<?= getSetting('paymentwall_projectKey', 'value'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Secret Key</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="paymentwall_secret" placeholder="Paymentwall Secret Key"
                       value="<?= getSetting('paymentwall_secretKey', 'value'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Widget ID</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="paymentwall_widgetID" placeholder="Paymentwall WidgetID"
                       value="<?= getSetting('paymentwall_widgetID', 'value'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Review Key</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" name="paymentwall_reviewKey"
                       placeholder="Paymentwall Review Key"
                       value="<?= getSetting('paymentwall_reviewKey', 'value'); ?>">
            </div>
        </div>
        <hr>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-10">
            <input type="submit" name="paymentwall_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
    </div>
</form>