<?php

if (!permissions::has("other")) {
    die(lang('no_perm'));
}

if (isset($_POST['send_test'])) {
    $message->add('success', 'Sent a test message to the server');

    $p = array(
        "id" => 0,
        "text" => "Prometheus: Testing ... 1, 2, 3",
        "trans_id" => 0,
        "uid" => 0,
        "type" => 3
    );
    addAction($p);
}

?>

<form method="POST" style="width: 40%;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <h2><?= lang('other_features'); ?></h2>
    <?php $message->Display(); ?>
    <?= lang('test_message', 'Send test message to server'); ?><br>
    <input type="submit" name="send_test" class="btn btn-prom" value="<?= lang('submit'); ?>" style="margin-top: 5px;">
</form>