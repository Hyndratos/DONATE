<?php

if (!permissions::has("users")) {
    die(lang('no_perm'));
}

if (isset($_POST['action_del'])) {
    $action = $_POST['hidden'];

    $timestamp = $db->getOne("SELECT timestamp FROM actions WHERE id = ?", $action);
    setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
    $db->execute("DELETE FROM actions WHERE timestamp = ? AND uid = ?", [
        $timestamp, $UID_a
    ]);

    prometheus::log('Deleted an action from ' . $db->getOne("SELECT name FROM players WHERE id = ?", $id), $_SESSION['uid']);

    cache::clear();
}

if (isset($_POST['delete_inactive'])) {
    $db->execute("DELETE FROM actions WHERE delivered = 1 AND active = 0 AND uid = ?", $UID_a);
    prometheus::log('Deleted all inactive actions from ' . $db->getOne("SELECT name FROM players WHERE uid = ?", $id), $_SESSION['uid']);

    cache::clear();
}

if (isset($_POST['toggle_active'])) {
    $action = $_POST['hidden'];

    $timestamp = $db->getOne("SELECT timestamp FROM actions WHERE id = ?", $action);
    setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
    $db->execute("UPDATE actions SET active = 0, delivered = 0 WHERE timestamp = ?", $timestamp);

    cache::clear();

    prometheus::log('Disabled package ' . $id . ' from ' . $db->getOne("SELECT p.name AS name FROM players p JOIN actions a ON p.uid = a.uid WHERE a.id = ?", $id), $_SESSION['uid']);
}

if (isset($_POST['toggle_inactive'])) {
    $action = $_POST['hidden'];

    $timestamp = $db->getOne("SELECT timestamp FROM actions WHERE id = ?", $action);
    setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
    $db->execute("UPDATE actions SET active = 1, delivered = 0 WHERE timestamp = ?", $timestamp);

    cache::clear();

    prometheus::log('Activated package ' . $id . ' from ' . $db->getOne("SELECT p.name AS name FROM players p JOIN actions a ON p.uid = a.uid WHERE a.id = ?", $id), $_SESSION['uid']);
}

?>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <a href="admin.php?page=users&action=package&id=<?= $_GET['id']; ?>" class="btn btn-success"
       style="margin-bottom: 5px;"><?= lang('assign_package', 'Assign package'); ?></a>
    <a href="admin.php?page=users&action=credits&id=<?= $_GET['id']; ?>" class="btn btn-success"
       style="margin-bottom: 5px;"><?= lang('set_credits', 'Set credits'); ?></a>
    <a href="admin.php?page=users&action=ticket&id=<?= $_GET['id']; ?>" class="btn btn-success"
       style="margin-bottom: 5px;"><?= lang('give_ticket', 'Give ticket'); ?></a>
    <input type="submit" class="btn btn-danger" name="delete_inactive"
           value="<?= lang('del_inactive_actions', 'Delete inactive actions'); ?>" style="margin-bottom: 5px;">
</form>
<table class="table table-striped">
    <thead>
    <th>ID</th>
    <th><?= lang('transaction', 'Transaction'); ?></th>
    <th><?= lang('packages'); ?></th>
    <th><?= lang('servers'); ?></th>
    <th><?= lang('delivered', 'Delivered'); ?></th>
    <th><?= lang('state', 'State'); ?></th>
    </thead>

    <tbody>
    <?php echo getPurchasedPackages($UID_a); ?>
    </tbody>
</table>