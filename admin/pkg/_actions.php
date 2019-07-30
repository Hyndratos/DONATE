<?php

if (!isset($_GET['id']) or $_GET['id'] == '') {
    $id = 0;
    $_GET['id'] = '0';
}

if (gateways::enabled('credits')) {
    $credits_enabled = 1;
} else {
    $credits_enabled = 0;
}

?>

<div class="form-group">
    <div class="col-sm-12">
        <div class="pkg-step" id="pkg-step-2">
            <span>Step 2</span>
            Assign actions
        </div>
    </div>
</div>

<div id="pkg-step-2-content" style="display: none;">
    <div class="form-group">
        <div class="col-sm-12">
            <h2><?= lang('assign_actions', 'Assign Actions'); ?></h2>
            <?= lang('actions_text', 'Assign what actions you want this package to perform after it has been purchased by a player.'); ?>
            <br><br>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="rank" <?php echo actions::get($_GET['id'], 'rank', '') ? 'checked' : ''; ?>>
                <label>ULX, Evolve, Moderator, AssMod Rank</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'rank', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <div id="rank_normal"
                         style="<?php echo actions::get($_GET['id'], 'rank', 'rank_prefix') ? 'display: none;' : ''; ?>">
                        <code>Notice for ASSMod users: Because Assmod is shit, ranks are number based, so you must type
                            the rank number here</code><br>
                        Rank to give when the package is bought
                        <input type="text" class="form-control" name="rank_when" placeholder="Name of rank"
                               style="margin-top: 5px; margin-bottom: 5px;"
                               value="<?= actions::get($_GET['id'], 'rank', 'rank_when'); ?>">
                    </div>

                    <input type="checkbox" name="rank_before"
                           id="rank_before" <?php echo actions::get($_GET['id'], 'rank', 'rank_before') == 1 ? 'checked' : ''; ?>>
                    <label>Give previous rank when runs out?</label>

                    <div id="rank_after"
                         style="margin-top:5px;margin-bottom:5px; <?php echo actions::get($_GET['id'], 'rank', 'rank_before') == 1 ? 'display: none;' : ''; ?>">
                        Rank to give when donator runs out
                        <input type="text" class="form-control" name="rank_after" placeholder="Name of rank"
                               style="margin-top: 5px;" value="<?= actions::get($_GET['id'], 'rank', 'rank_after'); ?>">
                    </div>
                    <br>
                    <input type="checkbox" id="rank_prefix_tick"
                           name="rank_prefix_tick" <?php echo actions::get($_GET['id'], 'rank', 'rank_prefix') ? 'checked' : ''; ?>
                           style="margin-top:5px;">
                    <label>Put prefix infront of current rank?</label>

                    <div id="rank_after2"
                         style="margin-top:5px;margin-bottom:5px; <?php echo actions::get($_GET['id'], 'rank', 'rank_prefix') ? '' : 'display: none;'; ?>">
                        <code>This prefix will be put infront of the users current rank on the server. This does not
                            work for ASSMod. If you put vip_ in the field and the users rank is mod on the server the
                            new rank would be vip_mod</code>
                        <input type="text" class="form-control" name="rank_prefix" placeholder="Prefix"
                               style="margin-top: 5px;"
                               value="<?= actions::get($_GET['id'], 'rank', 'rank_prefix'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="pointshop1" <?php echo actions::get($_GET['id'], 'pointshop1', '') ? 'checked' : ''; ?>>
                <label>Pointshop 1</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'pointshop1', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="number" class="form-control" name="pointshop1_points"
                           placeholder="Amount to give (Number)"
                           value='<?= actions::get($_GET['id'], 'pointshop1', 'points'); ?>'>
                    <br>
                    <code>If you are using pointshop MySQL please tick this option:</code><br><br>
                    <input type="checkbox"
                           name="pointshop1_mysql" <?php echo actions::get($_GET['id'], 'pointshop1', 'mysql') == 1 ? 'checked' : ''; ?>>
                    <label>Pointshop 1: MySQL Enabled?</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="pointshop2" <?php echo actions::get($_GET['id'], 'pointshop2', '') ? 'checked' : ''; ?>>
                <label>Pointshop 2</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'pointshop2', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <code>Put one to 0 if you don't want the panel to give it</code>
                    <input type="number" style="margin-top: 5px;" class="form-control" name="pointshop2_points"
                           placeholder="Normal Points (Number)"
                           value='<?= actions::get($_GET['id'], 'pointshop2', 'points'); ?>'>
                    <input type="number" style="margin-top: 5px; margin-bottom: 5px;" class="form-control"
                           name="pointshop2_premium" placeholder="Premium Points (Number)"
                           value='<?= actions::get($_GET['id'], 'pointshop2', 'premium_points'); ?>'>
                    <br>
                    <code>If you are using pointshop MySQL please tick this option:</code><br><br>
                    <input type="checkbox"
                           name="pointshop2_mysql" <?php echo actions::get($_GET['id'], 'pointshop2', 'mysql') ? 'checked' : ''; ?>>
                    <label>Pointshop 2: MySQL Enabled?</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="darkrpMoney" <?php echo actions::get($_GET['id'], 'darkrpMoney', '') ? 'checked' : ''; ?>>
                <label>DarkRP Money</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'darkrpMoney', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="number" class="form-control" name="darkrpMoney_money"
                           placeholder="Amount to give (Number)"
                           value='<?= actions::get($_GET['id'], 'darkrpMoney', 'money'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="darkrpLevels" <?php echo actions::get($_GET['id'], 'darkrpLevels', '') ? 'checked' : ''; ?>>
                <label>DarkRP Add Levels</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'darkrpLevels', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="number" class="form-control" name="darkrpLevels_lvl"
                           placeholder="Amount to give (Number)"
                           value='<?= actions::get($_GET['id'], 'darkrpLevels', 'lvl'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="darkrpScale" <?php echo actions::get($_GET['id'], 'darkrpScale', '') ? 'checked' : ''; ?>>
                <label>DarkRP ScaleXP</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'darkrpScale', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="number" step="any" min="0" class="form-control" name="darkrpScale_scale"
                           placeholder="Amount to scale by (Number)"
                           value='<?= actions::get($_GET['id'], 'darkrpScale', 'scale'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="customjob" <?php echo actions::get($_GET['id'], 'customjob', '') ? 'checked' : ''; ?>>
                <label>DarkRP Custom Job</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'customjob', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    If you enable this action the price you specified above acts as the base price. <b>Do not use custom
                        price with this action</b>
                    <h6>Weapons</h6>
                    <input type="checkbox" class="customjob_weapons_check"
                           name="customjob_weapons_check" <?php echo actions::get($_GET['id'], 'customjob', 'weapons') ? 'checked' : ''; ?>>
                    <label>Let the user specify weapons to add to the job</label>

                    <div class="customjob_weapons"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'weapons') ? '' : 'display: none;'; ?>">
                        <div class="row" id="customjob_weapons_list">
                            <?= actions::customjob($_GET['id'], 'weapons'); ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <input type="number" class="form-control" style="margin-top: 5px;"
                                       name="customjob_weapons_max" placeholder="0 - infinite"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'weapons_max'); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <i class="fa fa-plus fa-2x" style="color: darkgreen; cursor:pointer; margin-top: 10px"
                                   id="addWeapon"></i>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $('#addWeapon').on('click', function () {
                                var highest = 0;

                                $('.customjob_weapons_wep').each(function (i, obj) {
                                    var num = parseInt($(obj).attr('num'), 10);

                                    if (num > highest) {
                                        highest = num;
                                    }
                                });

                                highest = parseInt(highest, 10) + 1;

                                var value = '<div class="weapon">' +
                                    '<div class="col-xs-3">' +
                                    '<input type="text" name="customjob_weapons_name[' + highest + ']" num="' + highest + '" class="form-control customjob_weapons_name" style="margin-top: 5px;" placeholder="Weapon name">' +
                                    '</div>' +
                                    '<div class="col-xs-4">' +
                                    '<input type="text" name="customjob_weapons_wep[' + highest + ']" num="' + highest + '" class="form-control customjob_weapons_wep" style="margin-top: 5px;" placeholder="Weapon classname">' +
                                    '</div>' +
                                    '<div class="col-xs-2">' +
                                    '<input type="number" step="any" min="0" name="customjob_weapons_price[' + highest + ']" class="form-control" style="margin-top: 5px;" placeholder="Price">' +
                                    '</div>' +
                                    '<div class="col-xs-2">' +
                                    '<input type="number" step="any" min="0" name="customjob_weapons_credits[' + highest + ']" class="form-control" style="margin-top: 5px;" placeholder="Credits">' +
                                    '</div>' +
                                    '<div class="col-xs-1">' +
                                    '<i class="fa fa-minus-circle delWeapon" style="color: #c10000; cursor:pointer; padding-top: 14px;"></i>' +
                                    '</div>' +
                                    '</div>';

                                $('#customjob_weapons_list').append(value);
                                delWeapon();
                            });

                            delWeapon();
                            function delWeapon() {
                                $('.delWeapon').on('click', function () {
                                    $(this).parent().parent().remove();
                                });
                            }
                        </script>

                    </div>

                    <div class="customjob_weapons2"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'weapons') ? 'display: none;' : ''; ?>">
                        <input type="text" name="customjob_weapons_static" class="form-control" style="margin-top: 5px;"
                               placeholder='weapon1,weapon2,weapon3'
                               value="<?= actions::get($_GET['id'], 'customjob', 'weapons_static'); ?>">
                    </div>

                    <h6>Friends</h6>
                    <input type="checkbox" class="customjob_friends_check"
                           name="customjob_friends_check" <?php echo actions::get($_GET['id'], 'customjob', 'friends') ? 'checked' : ''; ?>>
                    <label>Let the user add friends to the job</label>

                    <div class="customjob_friends"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'friends') ? '' : 'display: none;'; ?>">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <input type="number" step="any" min="0" name="customjob_friends_amount"
                                       class="form-control" style="margin-top: 5px;"
                                       placeholder="Amount of allowed friends"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'friends_amount'); ?>">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <input type="number" step="any" min="0" name="customjob_friends_scaleprice"
                                       class="form-control" style="margin-top: 5px;"
                                       placeholder="Price to add for each friend added"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'friends_scaleprice'); ?>">
                            </div>
                            <?php if ($credits_enabled == 1) { ?>
                                <div class="col-xs-12 col-md-6">
                                    <input type="number" step="any" min="0" name="customjob_friends_scalecredits"
                                           class="form-control" style="margin-top: 5px;"
                                           placeholder="Credits to add for each friend added"
                                           value="<?= actions::get($_GET['id'], 'customjob', 'friends_scalecredits'); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="customjob_friends2"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'friends') ? 'display: none;' : ''; ?>">
                        <input type="number" name="customjob_friends_static" class="form-control"
                               style="margin-top: 5px;" placeholder='Amount of friends to include'
                               value="<?= actions::get($_GET['id'], 'customjob', 'friends_static'); ?>">
                    </div>


                    <h6>Salary</h6>
                    <input type="checkbox" class="customjob_salary_check"
                           name="customjob_salary_check" <?php echo actions::get($_GET['id'], 'customjob', 'salary') ? 'checked' : ''; ?>>
                    <label>Let the user define salary</label>

                    <div class="customjob_salary"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'salary') ? '' : 'display: none;'; ?>">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <input type="number" name="customjob_salary_amount" class="form-control"
                                       style="margin-top: 5px;" placeholder="Base salary"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'salary_amount'); ?>">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <input type="number" step="any" min="0" name="customjob_salary_max" class="form-control"
                                       style="margin-top: 5px;"
                                       placeholder="Max amount of times allowed to scale salary by"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'salary_max'); ?>">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <input type="number" step="any" min="0" name="customjob_salary_scaleprice"
                                       class="form-control" style="margin-top: 5px;"
                                       placeholder="Price to add per base salary + base salary"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'salary_scaleprice'); ?>">
                            </div>
                            <?php if ($credits_enabled == 1) { ?>
                                <div class="col-xs-12 col-md-6">
                                    <input type="number" name="customjob_salary_scalecredits" class="form-control"
                                           style="margin-top: 5px;"
                                           placeholder="Credits to add per base salary + base salary"
                                           value="<?= actions::get($_GET['id'], 'customjob', 'salary_scalecredits'); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="customjob_salary2"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'salary') ? 'display: none;' : ''; ?>">
                        <input type="number" name="customjob_salary_static" class="form-control"
                               style="margin-top: 5px;" placeholder="Salary (Static amount)"
                               value="<?= actions::get($_GET['id'], 'customjob', 'salary_static'); ?>">
                    </div>

                    <h6>Model</h6>
                    <input type="checkbox" class="customjob_models_check"
                           name="customjob_models_check" <?php echo actions::get($_GET['id'], 'customjob', 'models') ? 'checked' : ''; ?>>
                    <label>Let the user define job models</label>

                    <div class="customjob_models"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'models') ? '' : 'display: none;'; ?>">
                        <div class="row" id="customjob_models_list">
                            <?= actions::customjob($_GET['id'], 'models'); ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">
                                <input type="number" class="form-control" style="margin-top: 5px;"
                                       name="customjob_models_max" placeholder="0 - infinite"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'models_max'); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <i class="fa fa-plus fa-2x" style="color: darkgreen; cursor:pointer; margin-top: 10px"
                                   id="addModel"></i>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $('#addModel').on('click', function () {
                                var highest = 0;

                                $('.customjob_models_name').each(function (i, obj) {
                                    var num = parseInt($(obj).attr('num'), 10);

                                    if (num > highest) {
                                        highest = num;
                                    }
                                });

                                highest = parseInt(highest, 10) + 1;

                                var value = '<div class="model">' +
                                    '<div class="col-xs-3">' +
                                    '<input type="text" name="customjob_models_name[' + highest + ']" num="' + highest + '" class="form-control customjob_models_name" style="margin-top: 5px;" placeholder="Model name">' +
                                    '</div>' +
                                    '<div class="col-xs-4">' +
                                    '<input type="text" name="customjob_models_model[' + highest + ']" class="form-control" style="margin-top: 5px;" placeholder="Model path">' +
                                    '</div>' +
                                    '<div class="col-xs-2">' +
                                    '<input type="number" step="any" min="0" name="customjob_models_price[' + highest + ']" class="form-control" style="margin-top: 5px;" placeholder="Price">' +
                                    '</div>' +
                                    '<div class="col-xs-2">' +
                                    '<input type="number" step="any" min="0" name="customjob_models_credits[' + highest + ']" class="form-control" style="margin-top: 5px;" placeholder="Credits">' +
                                    '</div>' +
                                    '<div class="col-xs-1">' +
                                    '<i class="fa fa-minus-circle delModel" style="color: #c10000; cursor:pointer; padding-top: 14px;"></i>' +
                                    '</div>' +
                                    '</div>';

                                $('#customjob_models_list').append(value);
                                delModel();
                            });

                            delModel();
                            function delModel() {
                                $('.delModel').on('click', function () {
                                    $(this).parent().parent().remove();
                                });
                            }
                        </script>
                    </div>

                    <div class="customjob_models2"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'models') ? 'display: none;' : ''; ?>">
                        <input type="text" name="customjob_models_static" class="form-control" style="margin-top: 5px;"
                               placeholder="path/to/model1.mdl,path/to/model2.mdl,path/to/model3.mdl"
                               value="<?= actions::get($_GET['id'], 'customjob', 'models_static'); ?>">
                    </div>

                    <h6>License</h6>
                    <input type="checkbox" class="customjob_license_check"
                           name="customjob_license_check" <?php echo actions::get($_GET['id'], 'customjob', 'license') ? 'checked' : ''; ?>>
                    <label>Let the user decide if they want a license or not</label>

                    <div class="customjob_license"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'license') ? '' : 'display: none;'; ?>">
                        <div class="row">
                            <div class="col-xs-12 col-md-12">
                                <input type="number" name="customjob_license_scaleprice" class="form-control"
                                       style="margin-top: 5px;" placeholder="Price to add if user chooses yes"
                                       value="<?= actions::get($_GET['id'], 'customjob', 'license_scaleprice'); ?>">
                            </div>
                            <?php if ($credits_enabled == 1) { ?>
                                <div class="col-xs-12 col-md-12">
                                    <input type="number" name="customjob_license_scalecredits" class="form-control"
                                           style="margin-top: 5px;" placeholder="Credits to add if user chooses yes"
                                           value="<?= actions::get($_GET['id'], 'customjob', 'license_scalecredits'); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="customjob_license2"
                         style="<?php echo actions::get($_GET['id'], 'customjob', 'license') ? 'display: none;' : ''; ?>">
                        <input type="checkbox" class="customjob_license_static"
                               name="customjob_license_static" <?php echo actions::get($_GET['id'], 'customjob', 'license_static') ? 'checked' : ''; ?>
                               style="margin-top: 5px;">
                        <label>Give the user a license</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(".customjob_weapons_check").on("ifChanged", function () {
            $('.customjob_weapons').toggle();
            $('.customjob_weapons2').toggle();
        });

        $(".customjob_friends_check").on("ifChanged", function () {
            $('.customjob_friends').toggle();
            $('.customjob_friends2').toggle();
        });

        $(".customjob_salary_check").on("ifChanged", function () {
            $('.customjob_salary').toggle();
            $('.customjob_salary2').toggle();
        });

        $(".customjob_models_check").on("ifChanged", function () {
            $('.customjob_models').toggle();
            $('.customjob_models2').toggle();
        });

        $(".customjob_license_check").on("ifChanged", function () {
            $('.customjob_license').toggle();
            $('.customjob_license2').toggle();
        });
    </script>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="dayzItem" <?php echo actions::get($_GET['id'], 'dayzItem', '') ? 'checked' : ''; ?>>
                <label>DayZ Item</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'dayzItem', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="text" class="form-control" name="dayzItem_item" placeholder="Item name"
                           value='<?= actions::get($_GET['id'], 'dayzItem', 'item'); ?>'>
                    <input type="text" class="form-control" style="margin-top: 5px;" name="dayzItem_amount"
                           placeholder="Item amount (Number)"
                           value='<?= actions::get($_GET['id'], 'dayzItem', 'amount'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="dayzCredits" <?php echo actions::get($_GET['id'], 'dayzCredits', '') ? 'checked' : ''; ?>>
                <label>DayZ Credits</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'dayzCredits', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <input type="text" class="form-control" name="dayzCredits_amount"
                           placeholder="Amount of credits (Number)"
                           value='<?= actions::get($_GET['id'], 'dayzCredits', 'amount'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="weapons" <?php echo actions::get($_GET['id'], 'weapons', '') ? 'checked' : ''; ?>>
                <label>Weapons</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'weapons', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <select class="form-control" name="weapons_runtype">
                        <?php echo options::getRuntype($id, 'weapons'); ?>
                    </select>
                    Give a weapon at every spawn (Multiple seperated by a comma)
                    <input type="text" class="form-control" name="weapons_string" placeholder="Weapon classname"
                           style="margin-top: 5px;" value="<?= actions::get($_GET['id'], 'weapons', 'string'); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="console_action" <?php echo actions::get($_GET['id'], 'console', '') ? 'checked' : ''; ?>>
                <label>Console Command</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'console', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <select class="form-control" name="console_runtype">
                        <?php echo options::getRuntype($id, 'console'); ?>
                    </select>
                    <code>{Name}</code> - Gets replaced by players Name<br>
                    <code>{SteamID}</code> - Gets replaced by players SteamID<br>
                    <code>{Steam64}</code> - Gets replaced by players Steam64 ID. <br>
                    These are case sensitive! Remember the {} brackets!
                    <input type="text" class="form-control" name="console_cmd_when"
                           placeholder="CMD Ran at above action" style="margin-top: 5px;"
                           value='<?= actions::get($_GET['id'], 'console', 'cmd_when'); ?>'>
                    <input type="text" class="form-control" name="console_cmd_after" placeholder="CMD Ran after expired"
                           style="margin-top: 5px;" value='<?= actions::get($_GET['id'], 'console', 'cmd_after'); ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="custom_action" <?php echo actions::get($_GET['id'], 'custom_action', '') ? 'checked' : ''; ?>>
                <label>Custom Action</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'custom_action', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <select class="form-control" name="custom_runtype">
                        <?php echo options::getRuntype($id, 'custom_action'); ?>
                    </select>
                    <code>Prometheus.Temp.Ply</code> - The player (This does not work with the instant runtype)<br>
                    <code>Prometheus.Temp.SteamID</code> - Players SteamID.<br>
                    <code>Prometheus.Temp.Steam64</code> - Players Steam64 ID. <br>
                    <code>Prometheus.Temp.MoneySpent</code> - The money the player spent on the package. <br>
                    <code>Prometheus.Temp.MoneyEverSpent</code> - The money the player has ever spent on any packages or
                    credit packages combined. <br>
                    These are case sensitive!
                    <textarea name="code_when" placeholder="Code snippet"
                              style="margin-top: 5px; margin-bottom: 15px; height: 300px; max-width: 100%;"
                              class="form-control"><?= actions::get($_GET['id'], 'custom_action', 'code_when'); ?></textarea>

                    <input type="checkbox" id="custom_action_after"
                           name="custom_action_after" <?php echo actions::get($_GET['id'], 'custom_action', 'code_after') ? 'checked' : ''; ?>>
                    <label>Run code on expire?</label>

                    <div id="code_after"
                         style="margin-top: 5px; <?php echo actions::get($_GET['id'], 'custom_action', 'code_after') ? '' : 'display: none;'; ?>">
                        <code>Prometheus.Temp.Ply</code> - The player (This does not work with the instant runtype)<br>
                        <code>Prometheus.Temp.SteamID</code> - Players SteamID.<br>
                        <code>Prometheus.Temp.Steam64</code> - Players Steam64 ID. <br>
                        <code>Prometheus.Temp.MoneySpent</code> - The money the player spent on the package. <br>
                        <code>Prometheus.Temp.MoneyEverSpent</code> - The money the player has ever spent on any
                        packages or credit packages combined. <br>
                        These are case sensitive!
                        <textarea name="code_after" placeholder="Code snippet"
                                  style="margin-top: 5px; margin-bottom: 15px; height: 300px; max-width: 100%;"
                                  class="form-control"><?= actions::get($_GET['id'], 'custom_action', 'code_after'); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="teamspeak" <?php echo actions::get($_GET['id'], 'teamspeak', '') ? 'checked' : ''; ?>>
                <label>Teamspeak 3</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'teamspeak', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <code>For this action to work you need to have Teamspeak 3 properly configured in the integration
                        area of the settings!</code>

                    <input type="checkbox" id="teamspeak_group_tick"
                           name="teamspeak_group_tick" <?php echo actions::get($_GET['id'], 'teamspeak', 'group') ? 'checked' : ''; ?>>
                    <label>Assign a server group to a user?</label>

                    <div id="teamspeak_group_options"
                         style="margin-top: 5px; <?php echo actions::get($_GET['id'], 'teamspeak', 'group') ? '' : 'display: none;'; ?>">
                        <code>Server group name is case sensitive!</code>
                        <input type="text" class="form-control" name="teamspeak_group"
                               placeholder="Server group to give the user" style="margin-top: 5px;"
                               value='<?= actions::get($_GET['id'], 'teamspeak', 'group'); ?>'>
                    </div>
                    <br>
                    <input type="checkbox" id="teamspeak_channel_tick"
                           name="teamspeak_channel_tick" <?php echo actions::get($_GET['id'], 'teamspeak', 'channel_parent') ? 'checked' : ''; ?>>
                    <label>Give the user their own channel?</label>

                    <div id="teamspeak_channel_options"
                         style="margin-top: 5px; <?php echo actions::get($_GET['id'], 'teamspeak', 'channel_parent') ? '' : 'display: none;'; ?>">
                        <input type="text" class="form-control" name="teamspeak_channel_parent"
                               placeholder="Channel ID of the parent channel" style="margin-top: 5px;"
                               value='<?= actions::get($_GET['id'], 'teamspeak', 'channel_parent'); ?>'>
                        <input type="text" class="form-control" name="teamspeak_channel_group"
                               placeholder="Group ID of the channel admin rank" style="margin-top: 5px;"
                               value='<?= actions::get($_GET['id'], 'teamspeak', 'channel_group'); ?>'>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <div class="checkbox">
                <input type="checkbox" class="action_checkbox"
                       name="sourcemod" <?php echo actions::get($_GET['id'], 'sourcemod', '') ? 'checked' : ''; ?>>
                <label>Sourcemod</label>

                <div class="options"
                     style="<?php echo actions::get($_GET['id'], 'sourcemod', '') ? '' : 'display: none;'; ?> padding: 10px; background: #202020;">
                    <code>For this action to work you need to select a game other than Garry's Mod when editing/adding a
                        server, then fill out IP, Port and RCon password!</code>
                    <input type="text" class="form-control" name="sourcemod_fg" placeholder="Flags or group"
                           value='<?= actions::get($_GET['id'], 'sourcemod', 'fg'); ?>'>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-12">
        <div class="pkg-step" id="pkg-step-3">
            <span>Step 3</span>
            Extra options<br>
        </div>
    </div>
</div>

<div id="pkg-step-3-content" style="display: none;">
    <div class="form-group">
        <div class="col-sm-12">
            <h2><?= lang('upgradeable', 'Upgradeable from'); ?></h2>
            <?= lang('upgradeable_text', "If you own the package selected, you get this one at a discounted price of the selected packages' price"); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <?= checkbox_getPackages($_GET['id'], 'upgrade'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <h2><?= lang('hide'); ?></h2>
            <?= lang('hide_text'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <?= checkbox_getPackages($_GET['id'], 'hide'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <h2><?= lang('not_compatible', 'Not compatible with'); ?></h2>
            <?= lang('compatible_text', "If you own this package, you can't get the packages selected below"); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <?= checkbox_getPackages($_GET['id'], 'comp'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <h2><?= lang('buy_disable', 'Disable packages'); ?></h2>
            <?= lang('buy_disable_text', "Disable these packages if you buy this package"); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <?= checkbox_getPackages($_GET['id'], 'disable'); ?>
        </div>
    </div>
</div>
