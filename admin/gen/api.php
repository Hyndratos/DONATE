<?php

if (!permissions::has("api")) {
    die(lang('no_perm'));
}

if (isset($_POST['api_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $error = false;

    if (!$error) {
        if (isset($_POST['api_enable'])) {
            setSetting(1, 'enable_api', 'value2');
        } else {
            setSetting(2, 'enable_api', 'value2');
        }

        cache::clear('settings');
    }
}

if (isset($_POST['api_generate'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    $hash = generateUniqueId(32);
    setSetting($hash, 'api_hash', 'value');

    cache::clear('settings');
}

?>

<script type="text/javascript">
    $(function () {
        $(".form").on('submit', (function (e) {
            for (var instanceName in CKEDITOR.instances) {
                CKEDITOR.instances[instanceName].updateElement();
            }

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

<form method="POST" class="form-horizontal form" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
			<span id="message-location">
				<?php $message->Display(); ?>
			</span>

            <h2>API Settings</h2>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-9">
            <div class="checkbox">
                <input type="checkbox"
                       name="api_enable" <?php echo getSetting('enable_api', 'value2') == 1 ? 'checked' : ''; ?>>
                <label>Enable API</label>
            </div>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" style="margin-top: 5px;" data-toggle="tooltip"
                    data-placement="bottom" title="This enabled the site API">?
            </button>
        </div>
    </div>
    <?php if (getSetting('enable_api', 'value2') == 1) { ?>

        <div class="form-group">
            <label class="col-sm-2 control-label">API Hash</label>

            <div class="col-sm-9" style="padding-top: 5px;">
                <?php

                if (getSetting('api_hash', 'value') != NULL) {
                    echo '<b>API Hash:</b> ' . getSetting('api_hash', 'value') . '<br>';
                } else {
                    echo 'You have not generated an API Hash<br>';
                }

                ?>
                <input type="submit" name="api_generate" value="Generate" class="btn btn-danger"
                       style="margin-top: 9px;">
            </div>
            <div class="col-sm-1">
                <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                        title="Generate a secret unique hash used for communicating with your sites API">?
                </button>
            </div>
        </div>

    <?php } ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="api_submit" value="true">
            <input type="submit" name="api_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <hr>
            <h2>What is this api?</h2>
            Everything is explained <a href="http://wiki.prometheusipn.com/index.php?title=Integration:api">here</a>
        </div>
    </div>
</form>