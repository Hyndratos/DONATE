<?php
if (getSetting('featured_package', 'value2') != 0) {
    echo getFeatured('');
}
?>

<div class="header">
    <?= lang('select_server'); ?>
</div>

<?php if (gateways::enabled('credits') && prometheus::loggedin()) { ?>
    <p class="bs-callout bs-callout-info alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <?= lang('need_credits', 'Need more credits? <a href="store.php?page=credits">Click here!</a>'); ?>
    </p>
<?php } ?>

<?php if (store::countGlobals() > 0 && store::countServers() > 1 && getSetting('enable_globalPackages', 'value2') == 1) { ?>
    <a href="store.php?page=global">
        <div class="srv-box"><i class="fa fa-database fa-4x"></i>

            <div class="srv-label">Global packages</div>
        </div>
    </a>
<?php } ?>

<div class="row">
    <?php echo store::getServers(); ?>
</div>