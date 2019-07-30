<?php

if (!permissions::has("notifications")) {
    die(lang('no_perm'));
}

if (isset($_POST['messages_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
        
    setSetting(strip_tags($_POST['message_receiverPerma']), 'message_receiverPerma', 'value');
    setSetting(strip_tags($_POST['message_receiverNonPerma']), 'message_receiverNonPerma', 'value');
    setSetting(strip_tags($_POST['message_receiverRevoke']), 'message_receiverRevoke', 'value');
    setSetting(strip_tags($_POST['message_receiverExpire']), 'message_receiverExpire', 'value');
    setSetting(strip_tags($_POST['message_others']), 'message_others', 'value');
    setSetting(strip_tags($_POST['message_othersCredits']), 'message_othersCredits', 'value');
    setSetting(strip_tags($_POST['message_receiverCredits']), 'message_receiverCredits', 'value');

    $message->Add('success', 'Successfully updated the messages! Server must be restarted for this to take effect!');

    prometheus::log('Modified the ingame messages', $_SESSION['uid']);
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

<form method="POST" style="width: 100%;" class="form-horizontal" role="form">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
			<span id="message-location">
				<?php $message->Display(); ?>
			</span>

            <h2>Ingame Notifications</h2>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <code>{package}</code> = The package name<br>
            <code>{name}</code> = The player's name<br>
            <code>{expire}</code> = When it expires<br>
            <code>{amount}</code> = Amount of credits (For a credit package, not normal package)<br><br>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Permanent</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_receiverPerma" placeholder=""
                   value='<?= getSetting("message_receiverPerma", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message the player will receive ingame if they bought a permanent package.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Non Permanent</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_receiverNonPerma" placeholder=""
                   value='<?= getSetting("message_receiverNonPerma", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message the player will receive ingame if they bought a non permanent package.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Revoked</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_receiverRevoke" placeholder=""
                   value='<?= getSetting("message_receiverRevoke", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message the player will receive ingame their package was revoked.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Expired</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_receiverExpire" placeholder=""
                   value='<?= getSetting("message_receiverExpire", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message the player will receive ingame their package expired.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Others</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_others" placeholder=""
                   value='<?= getSetting("message_others", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message other players will receive when a package is bought.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Receiver credits</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_receiverCredits" placeholder=""
                   value='<?= getSetting("message_receiverCredits", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message the receiver will see when they have purchased credits.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Others credits</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="message_othersCredits" placeholder=""
                   value='<?= getSetting("message_othersCredits", "value"); ?>'>
        </div>
        <div class="col-sm-1">
            <button type="button" class="help-box" data-toggle="tooltip" data-placement="bottom"
                    title="This is the message others will see when someone has purchased credits.">?
            </button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="messages_submit" value="true">
            <input type="submit" name="messages_submit" value="<?= lang('submit'); ?>" class="btn btn-prom"
                   style="margin-top: 5px;">
        </div>
    </div>
</form>