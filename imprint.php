<?php
SESSION_START();

$page = 'imprint';
$page_title = 'Imprint';

require_once('inc/functions.php');
require_once('inc/classes/steamLogin.class.php');

if (!prometheus::loggedin()) {
    include('inc/login.php');
} else {
    $UID = $_SESSION['uid'];
}

$imprint_company = getSetting('imprint_company', 'value');
$imprint_street = getSetting('imprint_street', 'value');
$imprint_post = getSetting('imprint_post', 'value');
$imprint_country = getSetting('imprint_country', 'value');
$imprint_traderegister = getSetting('imprint_traderegister', 'value');
$imprint_companyid = getSetting('imprint_companyid', 'value');
$imprint_ceo = getSetting('imprint_ceo', 'value');
$imprint_email = getSetting('imprint_email', 'value');
$imprint_phone = getSetting('imprint_phone', 'value');
?>

<?php include('inc/header.php'); ?>
<div class="content">
    <div class="container">
        <div class="row">
            <?php include('inc/news.php'); ?>
            <div class="col-xs-9">
                <div class="header">
                    <?= lang('imprint', 'Imprint'); ?>
                </div>

                <table class="table table-striped">
                    <tbody>

                    <?php if ($imprint_company != '') { ?>
                        <tr>
                            <td><b><?= lang('company_name'); ?></b></td>
                            <td><?= $imprint_company; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_street != '') { ?>
                        <tr>
                            <td><b><?= lang('street_address'); ?></b></td>
                            <td><?= $imprint_street; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_post != '') { ?>
                        <tr>
                            <td><b><?= lang('post_address'); ?></b></td>
                            <td><?= $imprint_post; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_country != '') { ?>
                        <tr>
                            <td><b><?= lang('country'); ?></b></td>
                            <td><?= $imprint_country; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_traderegister != '') { ?>
                        <tr>
                            <td><b><?= lang('trade_register'); ?></b></td>
                            <td><?= $imprint_traderegister; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_companyid != '') { ?>
                        <tr>
                            <td><b><?= lang('company_id'); ?></b></td>
                            <td><?= $imprint_companyid; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_ceo != '') { ?>
                        <tr>
                            <td><b><?= lang('company_ceo'); ?></b></td>
                            <td><?= $imprint_ceo; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_email != '') { ?>
                        <tr>
                            <td><b><?= lang('contact_email'); ?></b></td>
                            <td><?= $imprint_email; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($imprint_phone != '') { ?>
                        <tr>
                            <td><b><?= lang('contact_phone'); ?></b></td>
                            <td><?= $imprint_phone; ?></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php'); ?>
