<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (gateways::enabled('credits')) {
    $credits_enabled = 1;
} else {
    $credits_enabled = 0;
}

// Rank
$rank_array = array();

if (isset($_POST['rank'])) {
    $rank_when = strip_tags($_POST['rank_when']);
    $rank_after = strip_tags($_POST['rank_after']);

    if (isset($_POST['rank_before'])) {
        $rank_before = 1;
    } else {
        $rank_before = 0;
    }

    if (isset($_POST['rank_prefix_tick'])) {
        $rank_prefix = strip_tags($_POST['rank_prefix']);
    } else {
        $rank_prefix = '';
    }

    $rank_array = array(
        "rank" => array(
            "rank_when" => $rank_when,
            "rank_after" => $rank_after,
            "rank_before" => $rank_before,
            "rank_prefix" => $rank_prefix
        )
    );
}

// Pointshop 1
$pointshop1_array = array();

if (isset($_POST['pointshop1'])) {
    $pointshop1_points = strip_tags($_POST['pointshop1_points']);

    if (isset($_POST['pointshop1_mysql'])) {
        $pointshop1_mysql = 1;
    } else {
        $pointshop1_mysql = 0;
    }

    $pointshop1_array = array(
        "pointshop1" => array(
            "points" => $pointshop1_points,
            "mysql" => $pointshop1_mysql
        )
    );
}

// Pointshop 2
$pointshop2_array = array();

if (isset($_POST['pointshop2'])) {
    $pointshop2_points = strip_tags($_POST['pointshop2_points']);
    $pointshop2_premium = strip_tags($_POST['pointshop2_premium']);
    if ($pointshop2_premium == '') {
        $pointshop2_premium = 0;
    }

    if (isset($_POST['pointshop2_mysql'])) {
        $pointshop2_mysql = 1;
    } else {
        $pointshop2_mysql = 0;
    }

    $pointshop2_array = array(
        "pointshop2" => array(
            "points" => $pointshop2_points,
            "premium_points" => $pointshop2_premium,
            "mysql" => $pointshop2_mysql
        )
    );
}

// DarkRP Money
$darkrpMoney_array = array();

if (isset($_POST['darkrpMoney'])) {
    $darkrpMoney_money = strip_tags($_POST['darkrpMoney_money']);

    $darkrpMoney_array = array(
        "darkrpMoney" => array(
            "money" => $darkrpMoney_money
        )
    );
}

// DarkRP Levels
$darkrpLevels_array = array();

if (isset($_POST['darkrpLevels'])) {
    $darkrpLevels_lvl = strip_tags($_POST['darkrpLevels_lvl']);

    $darkrpLevels_array = array(
        "darkrpLevels" => array(
            "lvl" => $darkrpLevels_lvl
        )
    );
}

// DarkRP Levels
$darkrpScale_array = array();

if (isset($_POST['darkrpScale'])) {
    $darkrpScale_scale = strip_tags($_POST['darkrpScale_scale']);

    $darkrpScale_array = array(
        "darkrpScale" => array(
            "scale" => $darkrpScale_scale,
            "runtype" => "1"
        )
    );
}

// DayZ Item
$dayzItem_array = array();

if (isset($_POST['dayzItem'])) {
    $dayzItem_item = strip_tags($_POST['dayzItem_item']);
    $dayzItem_amount = strip_tags($_POST['dayzItem_amount']);

    $dayzItem_array = array(
        "dayzItem" => array(
            "item" => $dayzItem_item,
            "amount" => $dayzItem_amount
        )
    );
}

// DayZ Credits
$dayzCredits_array = array();

if (isset($_POST['dayzCredits'])) {
    $dayzCredits_amount = strip_tags($_POST['dayzCredits_amount']);

    $dayzCredits_array = array(
        "dayzCredits" => array(
            "amount" => $dayzCredits_amount,
        )
    );
}

// Weapons
$weapons_array = array();

if (isset($_POST['weapons'])) {
    $weapons_string = strip_tags($_POST['weapons_string']);
    $weapons_runtype = $_POST['weapons_runtype'];

    $weapons_array = array(
        "weapons" => array(
            "string" => $weapons_string,
            "runtype" => $weapons_runtype
        )
    );
}

// Console Command
$console_array = array();

if (isset($_POST['console_action'])) {
    $console_cmd_when = strip_tags($_POST['console_cmd_when']);
    $console_cmd_after = strip_tags($_POST['console_cmd_after']);
    $console_runtype = $_POST['console_runtype'];

    $console_array = array(
        "console" => array(
            "cmd_when" => $console_cmd_when,
            "cmd_after" => $console_cmd_after,
            "runtype" => $console_runtype
        )
    );
}

// Custom Action
$custom_array = array();

if (isset($_POST['custom_action'])) {
    $code_when = strip_tags($_POST['code_when']);
    $code_after = strip_tags($_POST['code_after']);
    $custom_runtype = $_POST['custom_runtype'];

    $custom_array = array(
        "custom_action" => array(
            "code_when" => $code_when,
            "code_after" => $code_after,
            "runtype" => $custom_runtype
        )
    );
}

// Non gameserver actions
$xenforo_array = array();

if (isset($_POST['xenforo'])) {
    $xenforo_usergroup = strip_tags($_POST['xenforo_usergroup']);

    $xenforo_array = array(
        "xenforo" => array(
            "usergroup" => $xenforo_usergroup
        )
    );
}

$teamspeak_array = array();

if (isset($_POST['teamspeak'])) {
    if (isset($_POST['teamspeak_group_tick'])) {
        $teamspeak_group = strip_tags($_POST['teamspeak_group']);
    } else {
        $teamspeak_group = '';
    }

    if (isset($_POST['teamspeak_channel_tick'])) {
        $teamspeak_channel_parent = strip_tags($_POST['teamspeak_channel_parent']);
        $teamspeak_channel_group = strip_tags($_POST['teamspeak_channel_group']);
    } else {
        $teamspeak_channel_parent = '';
        $teamspeak_channel_group = '';
    }

    $teamspeak_array = array(
        "teamspeak" => array(
            "group" => $teamspeak_group,
            "group_delivered" => 0,
            "channel_parent" => $teamspeak_channel_parent,
            "channel_group" => $teamspeak_channel_group,
            "channel_delivered" => 0,
        )
    );
}

$customjob_array = array();

if (isset($_POST['customjob'])) {

    // Check if you admin wants to let the user specify weapons
    if (isset($_POST['customjob_weapons_check'])) {
        $customjob_weapons_check = true;

        $customjob_weapons_list = $_POST['customjob_weapons_wep'];
        $customjob_weapons_list = json_encode($customjob_weapons_list);

        $customjob_weapons_price = $_POST['customjob_weapons_price'];
        $customjob_weapons_price = json_encode($customjob_weapons_price);

        $customjob_weapons_credits = $_POST['customjob_weapons_credits'];
        $customjob_weapons_credits = json_encode($customjob_weapons_credits);


        $customjob_weapons_max = $_POST['customjob_weapons_max'];


        $customjob_weapons_name = $_POST['customjob_weapons_name'];
        $customjob_weapons_name = json_encode($customjob_weapons_name);

        $customjob_weapons_static = '';
    } else {
        $customjob_weapons_check = false;

        $customjob_weapons_list = false;
        $customjob_weapons_price = false;
        $customjob_weapons_credits = false;
        $customjob_weapons_name = false;
        $customjob_weapons_max = false;

        $customjob_weapons_static = $_POST['customjob_weapons_static'];
    }

    // Check if you admin wants to let the user specify friends
    if (isset($_POST['customjob_friends_check'])) {
        $customjob_friends_check = true;

        $customjob_friends_amount = $_POST['customjob_friends_amount'];
        $customjob_friends_scaleprice = $_POST['customjob_friends_scaleprice'];

        if ($credits_enabled == 1) {
            $customjob_friends_scalecredits = $_POST['customjob_friends_scalecredits'];
        } else {
            $customjob_friends_scalecredits = false;
        }

        $customjob_friends_static = '';
    } else {
        $customjob_friends_check = false;

        $customjob_friends_amount = false;
        $customjob_friends_scaleprice = false;
        $customjob_friends_scalecredits = false;

        $customjob_friends_static = $_POST['customjob_friends_static'];
    }

    // Check if you admin wants to let the user specify salary
    if (isset($_POST['customjob_salary_check'])) {
        $customjob_salary_check = true;

        $customjob_salary_amount = $_POST['customjob_salary_amount'];
        $customjob_salary_max = $_POST['customjob_salary_max'];
        $customjob_salary_scaleprice = $_POST['customjob_salary_scaleprice'];

        if ($credits_enabled == 1) {
            $customjob_salary_scalecredits = $_POST['customjob_salary_scalecredits'];
        } else {
            $customjob_salary_scalecredits = false;
        }

        $customjob_salary_static = '';
    } else {
        $customjob_salary_check = false;

        $customjob_salary_amount = false;
        $customjob_salary_max = false;
        $customjob_salary_scaleprice = false;
        $customjob_salary_scalecredits = false;

        $customjob_salary_static = $_POST['customjob_salary_static'];
    }

    // Check if you admin wants to let the user specify models
    if (isset($_POST['customjob_models_check'])) {
        $customjob_models_check = true;

        $customjob_models_list = $_POST['customjob_models_name'];
        $customjob_models_list = json_encode($customjob_models_list);

        $customjob_models_model = $_POST['customjob_models_model'];
        $customjob_models_model = json_encode($customjob_models_model);

        $customjob_models_price = $_POST['customjob_models_price'];
        $customjob_models_price = json_encode($customjob_models_price);

        $customjob_models_credits = $_POST['customjob_models_credits'];
        $customjob_models_credits = json_encode($customjob_models_credits);

        $customjob_models_max = $_POST['customjob_models_max'];

        $customjob_models_static = '';
    } else {
        $customjob_models_check = false;

        $customjob_models_list = false;
        $customjob_models_model = false;
        $customjob_models_price = false;
        $customjob_models_credits = false;
        $customjob_models_max = false;

        $customjob_models_static = $_POST['customjob_models_static'];
    }

    $customjob_license_static = false;

    // Check if you admin wants to let the user specify license
    if (isset($_POST['customjob_license_check'])) {
        $customjob_license_check = true;

        $customjob_license_scaleprice = $_POST['customjob_license_scaleprice'];

        if ($credits_enabled == 1) {
            $customjob_license_scalecredits = $_POST['customjob_license_scalecredits'];
        } else {
            $customjob_license_scalecredits = false;
        }

        $customjob_models_static = false;
    } else {
        $customjob_license_check = false;

        $customjob_license_scaleprice = false;
        $customjob_license_scalecredits = false;

        if (isset($_POST['customjob_license_static'])) {
            $customjob_license_static = true;
        } else {
            $customjob_license_static = false;
        }
    }

    // Construct custom job array
    $customjob_array = array(
        "customjob" => array(
            "weapons" => $customjob_weapons_check,
            "weapons_list" => $customjob_weapons_list,
            "weapons_price" => $customjob_weapons_price,
            "weapons_credits" => $customjob_weapons_credits,
            "weapons_name" => $customjob_weapons_name,
            "weapons_max" => $customjob_weapons_max,
            "weapons_static" => $customjob_weapons_static,

            "friends" => $customjob_friends_check,
            "friends_amount" => $customjob_friends_amount,
            "friends_scaleprice" => $customjob_friends_scaleprice,
            "friends_scalecredits" => $customjob_friends_scalecredits,
            "friends_static" => $customjob_friends_static,

            "salary" => $customjob_salary_check,
            "salary_amount" => $customjob_salary_amount,
            "salary_max" => $customjob_salary_max,
            "salary_scaleprice" => $customjob_salary_scaleprice,
            "salary_scalecredits" => $customjob_salary_scalecredits,
            "salary_static" => $customjob_salary_static,

            "models" => $customjob_models_check,
            "models_list" => $customjob_models_list,
            "models_model" => $customjob_models_model,
            "models_price" => $customjob_models_price,
            "models_credits" => $customjob_models_credits,
            "models_max" => $customjob_models_max,
            "models_static" => $customjob_models_static,

            "license" => $customjob_license_check,
            "license_scaleprice" => $customjob_license_scaleprice,
            "license_scalecredits" => $customjob_license_scalecredits,
            "license_static" => $customjob_license_static,
        )
    );
}

// Sourcemod
$sourcemod_array = array();

if (isset($_POST['sourcemod'])) {
    $sourcemod_fg = $_POST['sourcemod_fg'];

    $sourcemod_array = array(
        "sourcemod" => array(
            "fg" => $sourcemod_fg
        )
    );
}

// Combining the arrays
$combined_array = array_merge(
    $rank_array,
    $pointshop1_array,
    $pointshop2_array,
    $weapons_array,
    $darkrpMoney_array,
    $darkrpLevels_array,
    $darkrpScale_array,
    $custom_array,
    $console_array,
    $xenforo_array,
    $dayzItem_array,
    $dayzCredits_array,
    $teamspeak_array,
    $customjob_array,
    $sourcemod_array
);

$combined_json = json_encode($combined_array);
// Compatibility

if (isset($_POST['comp'])) {
    $comp = checkboxArrayStrip($_POST['comp']);
} else {
    $comp = '[]';
}
