<?php if (!permissions::has("logs")) {
    die(lang('no_perm'));
} ?>

<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-12">
            <h2>Admin logs</h2>
            <?php $message->display(); ?>
            <p class="bs-callout bs-callout-info">
                This panels purpose is to catch your admins doing naughty things ;)
            </p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><?= lang('action'); ?></th>
                    <th><?= lang('admin'); ?></th>
                    <th><?= lang('timestamp'); ?></th>
                </tr>
                </thead>

                <tbody class="tbody-center">
                <?php echo dashboard::getLogs(); ?>
                </tbody>
            </table>
            <?php echo dashboard::paging('logs'); ?>
        </div>
    </div>
</form>