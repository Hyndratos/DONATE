<?php

SESSION_START();

ob_start();

$page = 'admin';
$page_title = 'Admin';

require_once('inc/functions.php');

if (!prometheus::isAdmin())
    die('You are not an admin, get out of here');

if (prometheus::loggedin() && prometheus::isAdmin()) {
    update::run();

    $message = new FlashMessages();

    if (isset($_POST['search']))
        util::redirect('admin.php?page=users&q=' . $_POST['search']);

    if (isset($_POST['edit_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $db->execute("DELETE FROM servers WHERE id = ?", $id);
        prometheus::log('Deleted server: ' . $id, $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['raffle_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $db->execute("DELETE FROM raffles WHERE id = ?", $id);
        prometheus::log('Deleted raffle: ' . $id, $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['cur_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $db->execute("DELETE FROM currencies WHERE id = ?", $id);
        prometheus::log('Deleted a currency', $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['cat_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $db->execute("DELETE FROM categories WHERE id = ?", $id);
        prometheus::log('Deleted a category', $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['group_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];
        $db->execute("DELETE FROM permission_groups WHERE id = ?", $id);
        prometheus::log('Deleted a permission group', $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['credit_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        credits::del($_GET['id']);
        prometheus::log('Deleted credit package ' . $id, $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if (isset($_POST['theme_del'])) {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        theme::del($_GET['id']);
        prometheus::log('Deleted theme ' . $id, $_SESSION['uid']);

        util::redirect('admin.php');
    }

    if(isset($_POST['cou_del']))
    {
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $id = $_GET['id'];

        $db->execute("DELETE FROM coupons WHERE id = ?", $id);

        prometheus::log('Deleted coupon ' . $id, $_SESSION['uid']);

        util::redirect('admin.php');
    }
}

ob_end_clean();
?>

<?php include('inc/header.php'); ?>

<?php if (!prometheus::loggedin() && !prometheus::isAdmin()) { ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <?php include('inc/news.php'); ?>
                <div class="col-xs-9">
                    <div class="header">
                        Not authorized
                    </div>
                    You are not authorized to view this area. Sign in first!
                </div>
            </div>
        </div>
    </div>
    <?php include('inc/footer.php'); ?>
<?php } ?>

<?php if (prometheus::loggedin() && prometheus::isAdmin() && getSetting('installed', 'value2') == 1) { ?>
    <div class="full-content-wrapper">
        <?php
        include('inc/admin_sidebar.php');
        ?>

        <div class="main-content-box">
            <?php
            if (isset($_GET['a']) && $_GET['a'] != 'dashboard') {

                include_once('admin' . DIRECTORY_SEPARATOR . $_GET['a'] . '.php');

            } else {
                echo '
						<div class="content-page-top">
						    <span><i class="fa fa-pie-chart"></i>Dashboard</span>
						</div>
						<div class="content-outer-hbox">
						    <div class="scrollable content-inner">
						 	   <div class="row">
						            <div class="col-lg-12">

					';

                include_once('pages/admin/navigation.php');

                echo '</div>
	        			</div>';

                if (isset($_GET['page']) && !isset($_GET['action'])) {
                    include('pages/admin/' . $_GET['page'] . '.php');
                } elseif (isset($_GET['page']) && isset($_GET['action'])) {
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $UID_a = $db->getOne("SELECT uid FROM players WHERE id = ?", $id);
                    }

                    include('pages/admin/' . $_GET['page'] . '/' . $_GET['action'] . '.php');
                } else {
                    include('pages/admin/dashboard.php');
                }

                echo '</div>';
            }

            ?>
        </div>
    </div>

    <?php include('inc/footer.php'); ?>
<?php } ?>
