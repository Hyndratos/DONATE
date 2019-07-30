<?php

if (!permissions::has("sales")) {
    die(lang('no_perm'));
}


if (isset($_POST['sale_submit'])) {
    $packages = '';

    $packages = checkboxArrayStrip($_POST['packages']);

    $msg = strip_tags($_POST['sale_msg']);
    $perc = $_POST['sale_perc'];
    $endtime = $_POST['sale_endtime'];

    $error = false;
    if ($perc < 1) {
        $error = true;
        $message->add('danger', 'The sale percentage can not be less than 1!');
    }

    if (!$error) {
        setSetting($msg, 'sale_message', 'value');
        setSetting($packages, 'sale_packages', 'value');
        setSetting($endtime, 'sale_enddate', 'value');

        setSetting($perc, 'sale_percentage', 'value2');

        $message->Add('success', 'Successfully updated sale settings!');

        prometheus::log('Updated the sale settings', $_SESSION['uid']);
        cache::clear();
    }
}

?>

<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <h2><?= lang('sale_settings', 'Sale settings'); ?></h2>
            <?php $message->display(); ?>
            <?= lang('sale_text', 'Choose what packages you want the sale to apply to.'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('packages'); ?></label>

        <div class="col-sm-10">
            <?= checkbox_getPackages('sale'); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('percentage', 'Percentage'); ?></label>

        <div class="col-sm-10">
            <input type="text" name="sale_perc" placeholder="Percentage (Without %)" class="form-control"
                   value="<?= getSetting('sale_percentage', 'value2'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('message', 'Message'); ?></label>

        <div class="col-sm-10">
            <input type="text" name="sale_msg" placeholder="Sale message" class="form-control"
                   value="<?= getSetting('sale_message', 'value'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('end_date', 'End date'); ?></label>

        <div class="col-sm-10">
            <input type="text" id="datepicker" name="sale_endtime" placeholder="Sale end date" class="form-control"
                   value="<?= getSetting('sale_enddate', 'value'); ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" name="sale_submit" style="margin-top: 5px;" class="btn btn-prom"
                   value="<?= lang('submit'); ?>">
        </div>
    </div>
</form>