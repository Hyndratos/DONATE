<?php
SESSION_START();

$page = 'support';
$page_title = 'Questions';

include('inc/functions.php');

$message = new FlashMessages();

if (!prometheus::loggedin()) {
    include('inc/login.php');
}

if (isset($_POST['reply_submit'])) {
    if(isset($_SESSION['lastVisit'])){
        $lastVisit = $_SESSION['lastVisit'];

        if(time() <= $lastVisit + 10){
            util::redirect('support.php?view=' . $_GET['view']);
            exit;
        }
    }

    $_SESSION['lastPurchase'] = time();

    tickets::addReply($_GET['view'], $_POST['reply'], 0);
}

if (isset($_POST['ticket_close'])) {
    tickets::close($_GET['view']);
}

if (isset($_POST['ticket_open'])) {
    tickets::open($_GET['view']);
}

if (isset($_POST['submit'])) {
    if(isset($_SESSION['lastVisit'])){
        $lastVisit = $_SESSION['lastVisit'];

        if(time() <= $lastVisit + 10){
            util::redirect('support.php');
            exit;
        }
    }

    $_SESSION['lastPurchase'] = time();

    $error = false;

    $descr = $_POST['descr'];
    $text = $_POST['text'];

    if ($descr == '') {
        $error = true;
        $message->Add('danger', 'You need to enter a description!');
    }

    if ($text == '') {
        $error = true;
        $message->Add('danger', 'You need to enter some text!');
    }

    if (!$error) {
        tickets::create(strip_tags($descr), $text);
        util::redirect('support.php');
    }
}
?>

<?php include('inc/header.php'); ?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php if (prometheus::loggedin()) { ?>
                    <?php $message->display(); ?>
                    <?php if (!isset($_GET['view']) && !isset($_GET['create'])) { ?>
                        <b>Disclaimer!</b> This support ticket system goes to <b>the admins of this
                            site</b> not the developers of Prometheus<br><br>
                        <a href="support.php?create" class="btn btn-prom"
                           style="margin-bottom: 5px;"><?= lang('create_ticket'); ?></a>

                        <table class="table table-striped">
                            <thead>
                            <th><?= lang('id'); ?></th>
                            <th><?= lang('description'); ?></th>
                            <th><?= lang('timestamp'); ?></th>
                            <th><?= lang('replies'); ?></th>
                            <th><?= lang('action'); ?></th>
                            </thead>

                            <tbody style="tbody-center">
                            <?= user_getTickets(); ?>
                            </tbody>
                        </table>
                    <?php } ?>

                    <?php
                    if (isset($_GET['view'])) {
                        tickets::setRead($_GET['view'], 0);

                        echo tickets::getTicket($_GET['view']) . tickets::getReplies($_GET['view'], 0);
                    }
                    ?>

                    <?php if (isset($_GET['create'])) { ?>
                        <form method="POST">
                            <input type="text" placeholder="Description" name="descr" class="form-control"
                                   style="margin-bottom: 5px;">
                            <textarea id="text" name="text"></textarea>
                            <script>
                                $('#text').trumbowyg({
                                    removeformatPasted: true,
                                    autogrow: true,
                                    fullscreenable: false
                                });
                            </script>
                            <input type="submit" value="<?= lang('create'); ?>" class="btn btn-prom"
                                   style="margin-top: 5px;" name="submit">
                        </form>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php'); ?>
