<?php
SESSION_START();

$page = 'privacy';
$page_title = 'Privacy Policy';

include('inc/functions.php');

if (!prometheus::loggedin()) {
    include('inc/login.php');
} else {
    $UID = $_SESSION['uid'];
}

?>

<?php include('inc/header.php'); ?>
<div class="content">
    <div class="container">
        <div class="row">
            <?php include('inc/news.php'); ?>
            <div class="col-xs-9">
                <div class="header">
                    <?= lang('privacy', 'Privacy Policy'); ?>
                </div>
                <?php echo page::get('privacy'); ?>
            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php'); ?>
