<?php

if (!permissions::has("gateways")) {
    die(lang('no_perm'));
}

if (isset($_POST['credits_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    if (isset($_POST['enable_credits'])) {
        $enable_credits = true;
    } else {
        $enable_credits = false;
    }

    if ($enable_credits && gateways::enabled('credits')) {
        // Do success stuff

        if (isset($_POST['credits_only'])) {
            $credits_only = 1;
        } else {
            $credits_only = 0;
        }

        if (isset($_POST['credits_cantransfer'])) {
            $credits_cantransfer = 1;
        } else {
            $credits_cantransfer = 0;
        }

        setSetting($credits_only, 'credits_only', 'value2');
        setSetting($credits_cantransfer, 'credits_cantransfer', 'value2');
    } else {
        gateways::setState('credits', false);
        setSetting(0, 'credits_only', 'value2');
    }

    if ($enable_credits && !gateways::enabled('credits')) {
        gateways::setState('credits', true);
    }

    $message->Add('success', 'Successfully updated credits settings!');
    prometheus::log('Modified the credits settings', $_SESSION['uid']);

    cache::clear();
}

?>

<h2>Credits</h2>
Credits Payment Gateway settings. Credits integrate with both Paypal or Paymentwall. Enable this if you want to use credits as the way to pay for packages. Credits will be bought with either PayPal or Paymentwall depending on what you enable.
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
                <input type="checkbox"
                       name="enable_credits" <?php echo gateways::enabled('credits') ? 'checked' : ''; ?>>
                <label>Enable Credits</label>
            </div>
        </div>
    </div>
    <?php if (gateways::enabled('credits')) { ?>
        <hr>
        <div class="form-group">
            <div class="col-sm-11">
                <div class="checkbox">
                    <input type="checkbox"
                           name="credits_only" <?php echo getSetting('credits_only', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Only use credits as payment for packages / raffles</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Check this if you only want to allow credits as currency for packages / raffles">?
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-11">
                <div class="checkbox">
                    <input type="checkbox"
                           name="credits_cantransfer" <?php echo getSetting('credits_cantransfer', 'value2') == 1 ? 'checked' : ''; ?>>
                    <label>Can players transfer credits to each other?</label>
                </div>
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                        data-placement="bottom"
                        title="Check this if you want players to be able to transfer credits to each other">?
                </button>
            </div>
        </div>
        <hr>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-10">
            <input type="submit" name="credits_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
    </div>
</form>