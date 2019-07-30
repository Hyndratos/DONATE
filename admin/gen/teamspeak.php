<?php

if (!permissions::has("integration")) {
    die(lang('no_perm'));
}

if (isset($_POST['teamspeak_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    if (isset($_POST['teamspeak_username'])) {
        setSetting(strip_tags($_POST['teamspeak_username']), 'teamspeak_username', 'value');
    }

    if (isset($_POST['teamspeak_password'])) {
        setSetting(strip_tags($_POST['teamspeak_password']), 'teamspeak_password', 'value');
    }

    if (isset($_POST['teamspeak_virtualserver'])) {
        setSetting(strip_tags($_POST['teamspeak_virtualserver']), 'teamspeak_virtualserver', 'value2');
    }

    if (isset($_POST['teamspeak_port'])) {
        setSetting(strip_tags($_POST['teamspeak_port']), 'teamspeak_port', 'value2');
    }

    if (isset($_POST['teamspeak_ip'])) {
        setSetting(strip_tags($_POST['teamspeak_ip']), 'teamspeak_ip', 'value');
    }

    if (isset($_POST['teamspeak_queryport'])) {
        setSetting(strip_tags($_POST['teamspeak_queryport']), 'teamspeak_queryport', 'value2');
    }
}

?>

<h2>Teamspeak3 settings</h2>
All of these fields must be filled out in order for the teamspeak action to work!
<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-12">
            <?php $message->Display(); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Server query username</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="teamspeak_username"
                   placeholder="Server query username (default: serveradmin)"
                   value="<?= getSetting('teamspeak_username', 'value'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Server query password</label>

        <div class="col-sm-9">
            <input type="password" class="form-control" name="teamspeak_password" placeholder="Server query password"
                   value="<?= getSetting('teamspeak_password', 'value'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Query port</label>

        <div class="col-sm-9">
            <input type="number" class="form-control" name="teamspeak_queryport"
                   placeholder="Query port (default: 10011)"
                   value="<?= getSetting('teamspeak_queryport', 'value2'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Virtualserver ID</label>

        <div class="col-sm-9">
            <input type="number" class="form-control" name="teamspeak_virtualserver"
                   placeholder="Virtualserver ID (default: 1)"
                   value="<?= getSetting('teamspeak_virtualserver', 'value2'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Server IP</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="teamspeak_ip" placeholder="Server IP"
                   value="<?= getSetting('teamspeak_ip', 'value'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Server port</label>

        <div class="col-sm-9">
            <input type="number" class="form-control" name="teamspeak_port" placeholder="Server port (default: 9987)"
                   value="<?= getSetting('teamspeak_port', 'value2'); ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <input type="submit" name="teamspeak_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
</form>