<?php if (!permissions::has("packages")) {
    die(lang('no_perm'));
} ?>

<?php

if (isset($_POST['package_disable'])) {
    $id = $_POST['hidden'];

    $db->execute("UPDATE packages SET enabled = 0 WHERE id = ?", $id);
    prometheus::log('Disabled package ' . $id, $_SESSION['uid']);
}

if (isset($_POST['package_enable'])) {
    $id = $_POST['hidden'];

    $db->execute("UPDATE packages SET enabled = 1 WHERE id = ?", $id);
    prometheus::log('Enabled package ' . $id, $_SESSION['uid']);
}

if (isset($_POST['package_delete'])) {
    $id = $_POST['hidden'];

    $db->execute("DELETE FROM packages WHERE id = ?", $id);
    prometheus::log('Deleted package ' . $id, $_SESSION['uid']);
}

if (isset($_POST['package_set_inactive'])) {
    $id = $_POST['hidden'];

    setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
    $db->execute("UPDATE actions SET active = 0, delivered = 0 WHERE package = ?", $id);

    prometheus::log('Inactivated package ' . $id . ' for all users', $_SESSION['uid']);
}

if (isset($_POST['package_set_active'])) {
    $id = $_POST['hidden'];

    setSetting(date('Y-m-d H:i:s'), 'actions_lastupdated', 'value3');
    $db->execute("UPDATE actions SET active = 1, delivered = 0 WHERE package = ?", $id);

    prometheus::log('Activated package ' . $id . ' for all users', $_SESSION['uid']);
}

?>

<a href="admin.php?page=packages&action=customjobs" class="btn btn-prom" style="margin-bottom: 20px;">View active custom
    jobs</a>
<a href="admin.php?page=packages&action=move" class="btn btn-prom" style="margin-bottom: 20px;">Move packages around</a>

<table class="table table-striped">
    <thead>
    <th>ID</th>
    <th><?= lang('title'); ?></th>
    <th><?= lang('servers'); ?></th>
    <th><?= lang('actions'); ?></th>
    </thead>

    <tbody class="tbody-center">
    <?php echo dashboard::packageList(); ?>
    </tbody>
</table>