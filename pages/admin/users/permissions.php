<?php

if (!permissions::has("permissions")) {
    die(lang('no_perm'));
}

if (isset($_POST['permissions_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $user = $_GET['id'];
    $perm = $_POST['permission_group'];

    if ($perm == 0) {
        $admin = 0;
    } else {
        $admin = 1;
    }

    $db->execute("UPDATE players SET perm_group = ?, admin = ? WHERE id = ?", [
        $perm, $admin, $user
    ]);

    cache::clear();
}

?>

<h2>Choose permission group</h2>
<form method="POST" style="width: 40%;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <?php $message->Display(); ?>
    <select class="form-control" name="permission_group">
        <option value="0">none</option>
        <?php echo permissions::getOptions($_GET['id']); ?>
    </select>
    <input type="submit" name="permissions_submit" class="btn btn-prom" value="<?= lang('submit'); ?>"
           style="margin-top: 5px;">
</form>