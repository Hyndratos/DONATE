<?php if (!permissions::has("transactions")) {
    die(lang('no_perm'));
} ?>

<?php

if (isset($_POST['transaction_delete'])) {
    $id = $_POST['hidden'];

    $db->execute("DELETE FROM transactions WHERE id = ?", $id);
    prometheus::log('Deleted transaction ID ' . $id, $_SESSION['uid']);

    cache::clear();
}

?>

    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th><?= lang('name'); ?></th>
        <th><?= lang('package'); ?></th>
        <th><?= lang('price'); ?></th>
        <th><?= lang('type', 'Type'); ?></th>
        <th><?= lang('gateway', 'Gateway'); ?></th>
        <th><?= lang('timestamp'); ?></th>
        <th><?= lang('action'); ?></th>
        </thead>

        <tbody class="tbody-center">
        <?= getPurchaseLog(); ?>
        </tbody>
    </table>
<?php echo dashboard::paging('log'); ?>