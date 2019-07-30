<?php
if (!permissions::has("support")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    if (isset($_POST['reply_submit'])) {
        tickets::addReply($_GET['view'], $_POST['reply'], 1);

        prometheus::log('Replied to support ticket ' . $_GET['view'], $_SESSION['uid']);
    }

    if (isset($_POST['ticket_close'])) {
        tickets::close($_GET['view']);

        prometheus::log('Closed support ticket ' . $_GET['view'], $_SESSION['uid']);
    }

    if (isset($_POST['ticket_open'])) {
        tickets::open($_GET['view']);

        prometheus::log('Opened the support ticket ' . $_GET['view'], $_SESSION['uid']);
    }
}
?>

<div class="content-page-top">
    <span><i class="fa fa-ticket"></i> <?= lang('support_tickets'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">

                <?php if (!isset($_GET['view'])) { ?>
                    <table class="table table-striped">
                        <thead>
                        <th><?= lang('id'); ?></th>
                        <th><?= lang('user'); ?></th>
                        <th><?= lang('description'); ?></th>
                        <th><?= lang('timestamp'); ?></th>
                        <th><?= lang('replies'); ?></th>
                        <th><?= lang('action'); ?></th>
                        </thead>
                        <tbody class="tbody-center">
                        <?= table_getTickets(); ?>
                        </tbody>
                    </table>
                <?php } ?>

                <?php if (isset($_GET['view'])) {
                    tickets::setRead($_GET['view'], 1);
                    ?>
                    <?= tickets::getTicket($_GET['view']) . tickets::getReplies($_GET['view'], 1); ?>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

