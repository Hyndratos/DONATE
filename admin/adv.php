<?php

if (!permissions::has("advent")) {
    die(lang('no_perm'));
}

if (prometheus::loggedin() && prometheus::isAdmin()) {
    advent::populate();

    if(isset($_POST['submit'])){
        if(!csrf_check())
            return util::error("Invalid CSRF token!");

        $pkg = [];
        if(isset($_POST['pkg'])){
            $pkg = $_POST['pkg'];
        }               
    
        advent::update($_POST['image'], $pkg);

        $message->add('success', 'Successfully updated the advent calendar');
    }
}

?>

<div class="content-page-top">
    <span><i class="fa fa-tree"></i> <?= lang('advent_calendar'); ?></span>
</div>
<div class="content-outer-hbox">
    <div class="scrollable content-inner">
        <div class="row">
            <div class="col-lg-12">
                <div id="message-location">
                    <?php 

                        $message->display();

                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="darker-box">
                    If you choose multiple packages for one day a random one will be given, not all of them!
                </div>
            </div>
        </div>

        <div class="row">
            <form method="POST" class="form">
                <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                <?= advent::getForm(); ?>

                <div class="col-xs-12">
                    <button type="submit" class="btn btn-prom" name="submit"><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

