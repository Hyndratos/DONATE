<?php if (!permissions::has("users")) {
    die(lang('no_perm'));
} ?>

    <div class="row">
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search"
                       placeholder="<?= lang('users_search', 'Search for name, steam64 or steamid'); ?>"
                       style="margin-bottom: 5px;">
            </div>

            <div style="display: inline-block;" class="col-md-6 text-right">
                <a href="admin.php?page=users&action=blacklist"
                   class="btn btn-danger"><?= lang('view_blacklist', 'View blacklist'); ?></a>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th><?= lang('name'); ?></th>
        <th>UID</th>
        <th><?= lang('permissions'); ?></th>
        <th><?= lang('actions'); ?></th>
        </thead>

        <tbody class="tbody-center">
        <?php echo getUsers(); ?>
        </tbody>
    </table>
<?php echo dashboard::paging('users'); ?>