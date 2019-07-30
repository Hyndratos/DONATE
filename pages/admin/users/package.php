<?php

if (!permissions::has("assign_packages")) {
    die(lang('no_perm'));
}

if (isset($_POST['assign_submit'])) {
    if(!csrf_check())
        return util::error("Invalid CSRF token!");

    $error = false;

    $pkg = $_POST['assign_pkg'];
    $user = $_GET['id'];
    $state = $_POST['state'];
    $real = $_POST['real'];

    $userUID = $db->getOne("SELECT uid FROM players WHERE id = ?", $user);

    if (isset($_POST['assign_clonetime'])) {
        $clone = true;
    } else {
        $clone = false;
    }

    if ($pkg != '') {
        $customjob = actions::get($pkg, 'customjob', '') ? true : false;
        if ($customjob) {
            $pre = prepurchase::hasPre($userUID, 'customjob');
            if ($pre == false) {
                $error = true;
                $message->add('danger', 'This user has not created a custom job, tell them to create one before assigning this package to them!');
            }
        }

        if (!$error) {
            assignPackage($user, $pkg, $state, $clone, $real);

            prometheus::log('Assigned package ' . $pkg . ' to ' . $db->getOne("SELECT name FROM players WHERE id = ?", $user), $_SESSION['uid']);
            //cache::clear('purchase');

            $message->add('success', 'Successfully assigned package!');
        }
    } else {
        $message->add('danger', 'You must select a package first!');
    }
}

?>

<h2><?= lang('assign_package', 'Assign package'); ?></h2>
<form method="POST" style="width: 50%;">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <?php $message->Display(); ?>

    <div class="darker-box">
        <select name="assign_pkg" class="selectpicker" data-style="btn-prom" data-live-search="true">
            <option value=""><?= lang('select_pkg', 'Select package'); ?></option>
            <?php echo options::getPackages(); ?>
        </select>

        <select name="real" class="selectpicker" data-style="btn-prom">
            <option value="1"><?= lang('real_transaction', 'Count as a real transaction'); ?></option>
            <option
                value="0"><?= lang('not_real_transaction', 'Do not count as a real transaction (Will not add money to any stats)'); ?></option>
        </select>

        <select name="state" class="selectpicker" data-style="btn-prom">
            <option value="1"><?= lang('do_assign_actions', 'Assign actions'); ?></option>
            <option value="0"><?= lang('dont_assign_actions', 'Do not assign actions'); ?></option>
        </select>

        <div class="form-group">
            <div class="checkbox">
                <input type="checkbox" name="assign_clonetime">
                <label><?= lang('clone_expiretime', 'Clone expiretime of latest package of same type'); ?></label>
            </div>
        </div>
    </div>

    <input type="submit" name="assign_submit" class="btn btn-prom" value="<?= lang('assign', 'Assign'); ?>"
           style="margin-top: 5px;">

</form>