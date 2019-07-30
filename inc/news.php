<?php

if (getSetting('disable_news', 'value2') == 0) {

    $news_width = 9;

    ?>
    <div class="col-xs-3" style="padding-right: 0;">
        <div class="header">
            <?= lang('news'); ?>
        </div>
        <?php echo news::get(); ?>
    </div>
    <?php

} else {
    $news_width = 12;
}

?>
