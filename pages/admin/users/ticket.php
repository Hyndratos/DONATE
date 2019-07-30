<?php if (!permissions::has("give_tickets")) {
    die(lang('no_perm'));
} ?>

<?php

if (isset($_POST['raffle_ticket_add'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");
    
    $raffle_id = $_POST['raffle_id'];

    $db->execute("INSERT INTO raffle_tickets SET raffle_id = ?, uid = ?", array($raffle_id, $UID_a));

    $message->add("success", "Assigned a raffle ticket to this player");
}

?>

<h2><?= lang('give_ticket', 'Give ticket'); ?></h2>
<form method="POST" style="width: 40%;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <?php $message->Display(); ?>
    <select class="form-control" name="raffle_id">
        <?= raffle::listRaffles(); ?>
    </select>
    <input type="submit" name="raffle_ticket_add" class="btn btn-prom"
           value="<?= lang('give_ticket', 'Give ticket'); ?>" style="margin-top: 5px;">
</form>