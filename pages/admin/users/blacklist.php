<?php

if (!permissions::has("blacklist")) {
    die(lang('no_perm'));
}

if (isset($_POST['blacklist_add'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $error = false;

    if ($_POST['blacklist'] == '' && strpos($_POST['blacklist'], 'STEAM_0:') === FALSE && strlen($_POST['blacklist']) != 17) {
        $error = true;

        $message->add("danger", lang('blacklist_notext', 'You need to enter a valid Steam64 or SteamID to blacklist!'));
    }

    if (!$error) {
        if (strpos($_POST['blacklist'], 'STEAM_0:') !== FALSE) {
            $uid = convertSteamIdToCommunityId($_POST['blacklist']);
        } else {
            $uid = $_POST['blacklist'];
        }

        $message->add("success", lang('blacklist_success', 'You have successfully blacklisted this person'));
        dashboard::addToBlacklist($uid);
    }
}

if (isset($_POST['blacklist_del'])) {
    $id = $_POST['hidden'];

    $db->execute("DELETE FROM blacklist WHERE id = ?", $id);
}

?>

<div class="row">
    <div class="col-xs-12">
        <?php $message->display(); ?>
    </div>
</div>
<div class="row">
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
        <div class="col-lg-6" style="margin-bottom: 5px;">
            <div class="input-group">
                <input type="text" class="form-control" name="blacklist" placeholder="Steam64 or SteamID">
		      <span class="input-group-btn">
		        <button type="submit" name="blacklist_add" class="btn btn-success">Add</button>
		      </span>
            </div>
        </div>
    </form>
</div>
<table class="table table-striped">
    <thead>
    <th>Name</th>
    <th>Steam64</th>
    <th>SteamID</th>
    <th>Timestamp</th>
    <th>Action</th>
    </thead>

    <tbody>
    <?= dashboard::getBlacklist(); ?>
    </tbody>
</table>