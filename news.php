<?php
SESSION_START();

$page = 'home';
$page_title = 'News';

require_once('inc/functions.php');

if (!prometheus::loggedin()) {
    include('inc/login.php');
} else {
    $UID = $_SESSION['uid'];
}

$id = $_GET['id'];
?>

<?php include('inc/header.php'); ?>
<div class="content">
    <div class="container">
        <div class="row">
            <?php include('inc/news.php'); ?>
            <div class="col-xs-9">
                <div class="header">
                    News Post - <?= news::getPostVal($id, 'date'); ?>
                </div>
                <?= news::getPostVal($id, 'content'); ?>
            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php'); ?>
