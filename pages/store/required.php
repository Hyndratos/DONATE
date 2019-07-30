<?php

if (isset($_POST['teamspeak_group_submit'])) {
    $error = false;

    if ($_POST['teamspeak_unique'] == '') {
        $error = true;

        $message->add("danger", "You need to enter your Teamspeak 3 UniqueID!");
    }

    if (!$error) {
        $uniqueID = strip_tags($_POST['teamspeak_unique']);

        try {
            actions::claim('teamspeak_group', $uniqueID, $_SESSION['uid']);
        } catch (Exception $e) {
            $message->add("success", "You have now been granted your Teamspeak 3 servergroup :)");
        }
    }
}

if (isset($_POST['teamspeak_channel_submit'])) {
    $error = false;

    if ($_POST['teamspeak_unique'] == '') {
        $error = true;

        $message->add("danger", "You need to enter your Teamspeak 3 UniqueID!");
    }

    if (!$error) {
        $uniqueID = strip_tags($_POST['teamspeak_unique']);
        $name = strip_tags($_POST['teamspeak_name']);
        $topic = strip_tags($_POST['teamspeak_topic']);
        $pass = strip_tags($_POST['teamspeak_pass']);

        $values = array(
            "uniqueID" => $uniqueID,
            "name" => $name,
            "topic" => $topic,
            "pass" => $pass
        );

        if (actions::claim('teamspeak_channel', $values, $_SESSION['uid']) == null) {
            $message->add("success", "You have now been granted your Teamspeak 3 channel :)");
        } else {
            echo actions::claim('teamspeak_channel', $values, $_SESSION['uid']);
        }
    }
}

if (isset($_POST['teamspeak_channel_skip'])) {
    actions::skip('teamspeak_channel', $_SESSION['uid']);
}

if (isset($_POST['teamspeak_group_skip'])) {
    actions::skip('teamspeak_group', $_SESSION['uid']);
}


?>

<?php if (prometheus::loggedin()) { ?>
    <div class="header">
        ACTION REQUIRED!
    </div>

    <?php $message->display(); ?>

    <div class="row">
        <?php if (!actions::delivered('teamspeak_group', $_SESSION['uid'])) { ?>
            <div class="col-md-12">
                <div class="stat-box-header" style="border-bottom: 0px;">Teamspeak 3 Group</div>
                <form method="POST">
                    <p class="bs-callout bs-callout-info alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <b>Action required!</b> To claim your Teamspeak 3 usergroup, enter your Teamspeak 3 unique id
                        below<br>
                    </p>
                    <div class="input-group">
                        <input type="text" name="teamspeak_unique"
                               placeholder="UniqueID (Found in Teamspeak Settings -> Identities)" class="form-control"
                               style="margin-top: 5px;">
						<span class="input-group-btn">
							<input type="submit" name="teamspeak_group_submit" style="margin-top: 5px;"
                                   class="btn btn-prom" value="<?= lang('submit'); ?>">
						</span>
                    </div>

                    <input type="submit" name="teamspeak_group_skip" style="margin-top: 5px;" class="btn btn-danger"
                           value="Skip">
                </form>
            </div>
        <?php } ?>

        <?php if (!actions::delivered('teamspeak_channel', $_SESSION['uid'])) { ?>
            <div class="col-md-12">
                <div class="stat-box-header" style="border-bottom: 0px;">Teamspeak 3 Channel</div>
                <form method="POST">
                    <p class="bs-callout bs-callout-info alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <b>Action required!</b> To claim your Teamspeak 3 channel, enter your details below<br>
                    </p>
                    <div class="input-group">
                        <input type="text" name="teamspeak_unique"
                               placeholder="UniqueID (Found in Teamspeak Settings -> Identities)" class="form-control"
                               style="margin-top: 5px;">
                        <input type="text" name="teamspeak_name" placeholder="Channel name" class="form-control"
                               style="margin-top: 5px;">
                        <input type="text" name="teamspeak_topic" placeholder="Channel topic" class="form-control"
                               style="margin-top: 5px;">
                        <input type="password" name="teamspeak_pass" placeholder="Channel password" class="form-control"
                               style="margin-top: 5px;"><br>
                        <input type="submit" name="teamspeak_channel_submit" style="margin-top: 5px;"
                               class="btn btn-prom" value="<?= lang('submit'); ?>">
                    </div>

                    <input type="submit" name="teamspeak_channel_skip" style="margin-top: 5px;" class="btn btn-danger"
                           value="Skip">
                </form>
            </div>
        <?php } ?>

        <?php if (actions::delivered()) { ?>
            <div class="col-md-12">
                You have no actions that require your input right now.
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="header">
        Unauthorised
    </div>
    Unauthorised access!
<?php } ?>