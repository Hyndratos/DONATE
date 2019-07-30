<?php

if (!permissions::has("imprint")) {
    die(lang('no_perm'));
}

if (isset($_POST['imprint_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    if (isset($_POST['imprint_enable'])) {
        $enable = 1;
    } else {
        $enable = 0;
    }

    setSetting($enable, 'imprint_enable', 'value2');

    unset($_POST['imprint_enable']);
    unset($_POST['imprint_submit']);
    foreach ($_POST as $key => $value) {
        setSetting($value, $key, 'value');
    }

    $message->Add('success', 'Successfully updated the imprint!');
    cache::clear('settings');

    prometheus::log('Modified the imprint', $_SESSION['uid']);
}

?>

<script type="text/javascript">
    $(function () {
        $(".form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: document.location.href,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    var msg = $(data).find('.bs-callout');

                    $("#message-location").html(msg);
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
            });
        }));
    });
</script>

<form method="POST" style="width: 100%;" class="form-horizontal form" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <h2><?= lang('imprint'); ?></h2>

			<span id="message-location">
				<?php $message->Display(); ?>
			</span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-9">
            <div class="checkbox">
                <input type="checkbox" id="imprint_enable"
                       name="imprint_enable" <?php echo getSetting('imprint_enable', 'value2') == 1 ? 'checked' : ''; ?>>
                <label><?= lang('enable_imprint'); ?></label>
            </div>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" style="margin-top: 7px;" data-toggle="tooltip"
                    data-placement="bottom" title="Do you want to enable the imprint page(Link in the footer etc)">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('company_name'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_company" placeholder="<?= lang('company_name'); ?>"
                   value="<?= getSetting('imprint_company', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('street_address'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_street" placeholder="<?= lang('street_address'); ?>"
                   value="<?= getSetting('imprint_street', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('post_address'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_post" placeholder="<?= lang('post_address'); ?>"
                   value="<?= getSetting('imprint_post', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('country'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_country" placeholder="<?= lang('country'); ?>"
                   value="<?= getSetting('imprint_country', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('trade_register'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_traderegister"
                   placeholder="<?= lang('trade_register'); ?>"
                   value="<?= getSetting('imprint_traderegister', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('company_id'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_companyid" placeholder="<?= lang('company_id'); ?>"
                   value="<?= getSetting('imprint_companyid', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('company_ceo'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_ceo" placeholder="<?= lang('company_ceo'); ?>"
                   value="<?= getSetting('imprint_ceo', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('contact_email'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_email" placeholder="<?= lang('contact_email'); ?>"
                   value="<?= getSetting('imprint_email', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label"><?= lang('contact_phone'); ?></label>

        <div class="col-sm-10">
            <input type="text" class="form-control" name="imprint_phone" placeholder="<?= lang('contact_phone'); ?>"
                   value="<?= getSetting('imprint_phone', 'value'); ?>">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="imprint_submit" value="true">
            <input type="submit" name="imprint_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
</form>