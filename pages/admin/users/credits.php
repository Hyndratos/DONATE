<?php

if (!permissions::has("assign_credits")) {
    die(lang('no_perm'));
}

if (isset($_POST['assign_credits'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $credits = $_POST['credits'];

    if ($credits != '' && is_numeric($credits)) {
        $user = $_GET['id'];
        $a_uid = $db->getOne("SELECT uid FROM players WHERE id = ?", $user);

        credits::set($a_uid, $credits);

        prometheus::log('Set the credits of ' . $db->getOne("SELECT name FROM players WHERE id = ?", $user) . ' to ' . $credits, $_SESSION['uid'])['name'];
        cache::clear('purchase');

        $message->add('success', 'Credits set successfully!');
    } else {
        $message->add('danger', 'Credits can\'t be blank, and must be a numeric value!');
    }
}

?>

<h2><?= lang('set_credits', 'Set credits'); ?></h2>
<form method="POST" style="width: 40%;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <?php $message->Display(); ?>
    <input type="text" class="form-control" placeholder="1 (Credits)" name="credits"
           value="<?= credits::get($UID_a); ?>">
    <input type="submit" name="assign_credits" class="btn btn-prom" value="<?= lang('set', 'Set'); ?>"
           style="margin-top: 5px;">
</form>