<div class="dashboard-nav">

    <a href="admin.php" <?= !isset($_GET['page']) ? 'class="active"' : ''; ?>><?= lang('main_dashboard'); ?></a>

    <?php if (permissions::has("transactions")) { ?>
        <a href="admin.php?page=transactions" <?= isset($_GET['page']) && $_GET['page'] == 'transactions' ? 'class="active"' : ''; ?>><?= lang('transactions'); ?></a>
    <?php } ?>

    <?php if (permissions::has("users")) { ?>
        <a href="admin.php?page=users" <?= isset($_GET['page']) && $_GET['page'] == 'users' ? 'class="active"' : ''; ?>><?= lang('users'); ?></a>
    <?php } ?>

    <a href="admin.php?page=packages" <?= isset($_GET['page']) && $_GET['page'] == 'packages' ? 'class="active"' : ''; ?>><?= lang('packages'); ?></a>

    <?php if (permissions::has("logs")) { ?>
        <a href="admin.php?page=logs" <?= isset($_GET['page']) && $_GET['page'] == 'logs' ? 'class="active"' : ''; ?>><?= lang('logs'); ?></a>
    <?php } ?>

    <?php if (permissions::has("sales")) { ?>
        <a href="admin.php?page=sale" <?= isset($_GET['page']) && $_GET['page'] == 'sale' ? 'class="active"' : ''; ?>><?= lang('sale'); ?></a>
    <?php } ?>

    <?php if (permissions::has("updates")) { ?>
        <a href="admin.php?page=update" <?= isset($_GET['page']) && $_GET['page'] == 'update' ? 'class="active"' : ''; ?>><?= lang('updates', 'Updates'); ?></a>
    <?php } ?>

    <?php if (permissions::has("other")) { ?>
        <a href="admin.php?page=other" <?= isset($_GET['page']) && $_GET['page'] == 'other' ? 'class="active"' : ''; ?>><?= lang('other_features'); ?></a>
    <?php } ?>

</div>