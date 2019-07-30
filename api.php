<?php

header('Content-Type: application/json');

$page = 'api';
require_once('inc/functions.php');

ob_clean();

if (getSetting('enable_api', 'value2') == 1) {
    //echo 'API Enabled';
    
    $notGoal = true;
    if(isset($_GET['action']) && $_GET['action'] == 'getGoal')
        $notGoal = false;

    if (!isset($_GET['hash']) && $notGoal)
        die(formatJson('{"error":1,"msg":"You have not specified a hash!"}'));

    if (isset($_GET['hash']) && !api::validHash($_GET['hash']) && $notGoal)
        die(formatJson('{"error":1,"msg":"This is not a valid hash!"}'));

    if (!isset($_GET['action']))
        $json = '{"error":1,"msg":"You need to specify an action!"}';

    if ($_GET['action'] == 'getGoal') {
        $array = goal::get();

        $cur = $array['cur'];
        $total = $array['total'];
        $goal = $array['goal'];
        $perc = $array['perc'];

        $total = round($total, 2);

        $json = '{"error":0,"cur":"' . $cur . '","total":"' . $total . '","goal":"' . $goal . '","perc":"' . $perc . '"}';
    }

    if ($_GET['action'] == 'assignPackage') {
        if (!isset($_GET['steamid']))
            $json = '{"error":1,"msg":"This action requires a steamid!"}';

        if (!api::validSteam($_GET['steamid']))
            $json = '{"error":1,"msg":"Invalid steamid!"}';

        if (!isset($_GET['package']))
            $json = '{"error":1,"msg":"You need to specify a package!"}';

        if (!api::packageExists($_GET['package']))
            $json = '{"error":1,"msg":"This is not a valid package!"}';

        /**
         * Now do the actual action
         */

        if (strpos($_GET['steamid'], 'STEAM_0:') !== FALSE)
            $steamid = convertSteamIdToCommunityId($_GET['steamid']);
        else
            $steamid = $_GET['steamid'];

        $steamid = $db->getOne("SELECT id FROM players WHERE uid = ?", $steamid);
        assignPackage($steamid, $_GET['package']);

        $json = '{"error":0,"msg":"Package assigned successfully"}';
    }

    if ($_GET['action'] == 'addCredits') {
        if (!isset($_GET['steamid']))
            $json = '{"error":1,"msg":"This action requires a steamid!"}';

        if (!api::validSteam($_GET['steamid']))
            $json = '{"error":1,"msg":"Invalid steamid!"}';

        if (!isset($_GET['amount']))
            $json = '{"error":1,"msg":"You need to specify a credits amount!"}';

        /**
         * Now do the actual action
         */

        if (strpos($_GET['steamid'], 'STEAM_0:') !== FALSE)
            $steamid = convertSteamIdToCommunityId($_GET['steamid']);
        else
            $steamid = $_GET['steamid'];

        $current = credits::get($steamid);
        $new = (int)$current + (int)$_GET['amount'];
        credits::set($steamid, $new);

        $json = '{"error":0,"msg":"Credits assigned successfully"}';
    }

    if ($_GET['action'] == 'getPackages'){
        $packages = $db->getAll("SELECT * FROM packages");
        $ret = '';

        if($packages){
            $arr = [
                "error" => 0
            ];

            foreach($packages as $row){
                $arr['packages'][$row['id']] = [
                    'title' => $row['title'],
                    'price' => $row['price'],
                    'custom_price' => $row['custom_price'],
                    'custom_price_min' => $row['custom_price_min'],
                    'servers' => $row['servers'],
                    'credits' => $row['credits'],
                    'permanent' => $row['permanent'],
                    'days' => $row['days'],
                    'labels' => htmlentities($row['labels']),
                    'descr' => htmlentities($row['lower_text']),
                    'subscription' => $row['subscription'],
                    'image' => $row['img'],
                ];
            }

            $json = json_encode($arr);
        } else
             $json = '{"error":1,"msg":"There are no packages to display"}';
    }
} else
    $json = '{"error":1,"msg":"The API is disabled"}';

die(formatJson($json));
