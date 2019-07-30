<?php

class actions
{
    public static function get($id, $val, $val2, $uid = null)
    {
        global $db;

        if($uid == null){
            if(prometheus::loggedin()){
                $uid = $_SESSION['uid'];
            }
        }

        $actions = $db->getOne("SELECT actions FROM packages WHERE id = ?", $id);

        $actions = json_decode($actions, true);

        $ret = false;

        if (isset($actions[$val]) && !isset($actions[$val][$val2])) {
            $ret = true;
        }

        if ($val2 != '') {
            if (isset($actions[$val]) && isset($actions[$val][$val2])) {
                $ret = $actions[$val][$val2];
            } else {
                $ret = false;
            }
        }

        if($uid != null){
            if (is_numeric(actions::delivered('customjob', $uid)) && $_GET['page'] == 'customjob') {
                if ($val == 'customjob' && stripos($val2, "price") !== false or stripos($val2, "credits") !== false) {
                    $ret = preg_replace('/[\d+]/', "0", $actions[$val][$val2]);
                }
            }
        }

        return $ret;
    }

    public static function missing()
    {
        global $db;

        $res = $db->getAll("SELECT actions FROM packages WHERE enabled = 1");
        foreach ($res as $row) {
            if ($row['actions'] == '' or $row['actions'] == NULL or $row['actions'] == '[]') {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function delivered($type = null, $uid = null)
    {
        global $db;

        $res = $db->getAll("SELECT actions, active FROM actions WHERE uid = ?", $uid);
        $delivered = true;

        foreach ($res as $row) {
            $active = $row['active'];
            $actions = $row['actions'];
            $a = json_decode($actions, true);

            if ($active == 1 && isset($a['teamspeak'])) {
                if ($type == 'teamspeak_group') {
                    if (isset($a['teamspeak']) && isset($a['teamspeak']['group_delivered']) && $a['teamspeak']['group_delivered'] == 0) {
                        if ($a['teamspeak']['group'] != '') {
                            $delivered = false;
                        }
                    }
                }

                if ($type == 'teamspeak_channel') {
                    if (isset($a['teamspeak']) && isset($a['teamspeak']['channel_delivered']) && $a['teamspeak']['channel_delivered'] == 0) {
                        if ($a['teamspeak']['channel_parent'] != '') {
                            $delivered = false;
                        }
                    }
                }
            }

            if ($active == 1 && isset($a['customjob'])) {
                if ($type == 'customjob') {
                    if (isset($a['customjob']['raffle']) && $a['customjob']['raffle'] == true) {
                        $delivered = $a['customjob']['pid'];
                    }
                }
            }
        }

        if ($type == null) {
            if (!actions::delivered('teamspeak_group', $_SESSION['uid']) or
                !actions::delivered('teamspeak_channel', $_SESSION['uid'])
            ) {
                $delivered = false;
            }
        }

        return $delivered;
    }

    public static function skip($type, $uid)
    {
        global $db;

        $res = $db->getAll("SELECT * FROM actions WHERE uid = ?", $uid);

        foreach ($res as $row) {
            $actions = $row['actions'];
            $active = $row['active'];
            $id = $row['id'];

            $a = json_decode($actions, true);

            if ($active == 1 && isset($a['teamspeak'])) {
                if ($type == 'teamspeak_group') {
                    if (isset($a['teamspeak']['group_delivered'])) {
                        $a['teamspeak']['group_delivered'] = 1;

                        $a = json_encode($a);
                        $db->execute("UPDATE actions SET actions = ? WHERE uid = ? AND id = ?", array($a, $uid, $id));
                    }
                }

                if ($type == 'teamspeak_channel') {
                    if (isset($a['teamspeak']['channel_delivered'])) {
                        $a['teamspeak']['channel_delivered'] = 1;

                        $a = json_encode($a);
                        $db->execute("UPDATE actions SET actions = ? WHERE uid = ? AND id = ?", array($a, $uid, $id));
                    }
                }
            }

        }
    }

    public static function claim($type, $values, $uid = null)
    {
        global $db;

        $error = false;

        $res = $db->getAll("SELECT * FROM actions WHERE uid = ?", $uid);

        foreach ($res as $row) {
            $actions = $row['actions'];
            $id = $row['id'];

            $a = json_decode($actions, true);

            if ($type == 'teamspeak_group' && isset($a['teamspeak']) && $a['teamspeak']['group_delivered'] == 0) {
                $a['teamspeak']['group_delivered'] = 1;

                // teamspeak 3 claim group

                $ts3 = TeamSpeak3::factory("serverquery://" . getSetting('teamspeak_username', 'value') . ":" . getSetting('teamspeak_password', 'value') . "@" . getSetting('teamspeak_ip', 'value') . ":" . getSetting('teamspeak_queryport', 'value2') . "/?server_port=" . getSetting('teamspeak_port', 'value2'));

                $servergroup = $ts3->serverGroupGetByName($a['teamspeak']['group']);
                $client = $ts3->clientGetByUid($values);

                $client->addServerGroup($servergroup->getId());

                $a = json_encode($a);
                $db->execute("UPDATE actions SET actions = ? WHERE uid = ? AND id = ?", [
                    $a, $uid, $id
                ]);
            }

            if ($type == 'teamspeak_channel' && isset($a['teamspeak']) && $a['teamspeak']['channel_delivered'] == 0) {
                $a['teamspeak']['channel_delivered'] = 1;

                $ts3 = TeamSpeak3::factory("serverquery://" . getSetting('teamspeak_username', 'value') . ":" . getSetting('teamspeak_password', 'value') . "@" . getSetting('teamspeak_ip', 'value') . ":" . getSetting('teamspeak_queryport', 'value2') . "/?server_port=" . getSetting('teamspeak_port', 'value2'));

                $ts3->channelCreate(array(
                    "channel_name" => $values['name'],
                    "channel_topic" => $values['topic'],
                    "channel_codec" => TeamSpeak3::CODEC_OPUS_VOICE,
                    "channel_flag_permanent" => TRUE,
                    "channel_password" => $values['pass'],
                    "cpid" => $a['teamspeak']['channel_parent'],
                ));

                $channel = $ts3->channelGetByName($values['name']);
                $channelID = $channel->getId();

                if ($a['teamspeak']['channel_group'] != '') {
                    $client = $ts3->clientGetByUid($values['uniqueID']);
                    $client->setChannelGroup($channelID, $a['teamspeak']['channel_group']);
                }

                $a = json_encode($a);
                $db->execute("UPDATE actions SET actions = ? WHERE uid = ? AND id = ?", array($a, $uid, $id));
            }
        }
    }

    public static function updateExistingActions($pid)
    {
        global $db, $updateable_actions;

        $actions = $db->getOne("SELECT actions FROM packages WHERE id = ?", $pid);
        $actions_a = json_decode($actions, true);

        /**
         * Split out any updateable_actions if set
         */
        $updateable_a = array();

        foreach ($updateable_actions as $action) {
            if (isset($actions_a[$action])) {
                $updateable_a[$action] = $actions_a[$action];

                unset($actions_a[$action]);
            }
        }

        if (count($updateable_a) != 0) {
            $new_actions = json_encode($updateable_a);
            $old_actions = $db->getOne("SELECT actions FROM actions WHERE package = ? AND updateable = 1", $pid);

            $timestamp = date('Y-m-d H:i:s');
            setSetting($timestamp, 'actions_lastupdated', 'value3');

            /**
             * Need to check if changed
             */
            if ($new_actions != $old_actions) {
                //die('reached');
                // insert into db
                $db->execute("UPDATE actions SET actions = ?, delivered = 0 WHERE package = ? AND updateable = 1", [$new_actions, $pid]);
            }
        }
    }

    public static function getActionValue($pid, $action)
    {
        global $db;

        $actions = $db->getOne("SELECT actions FROM packages WHERE id = ?", $pid);
        $actions_a = json_decode($actions, true);

        if (isset($actions_a[$action])) {
            return $actions_a[$action];
        } else {
            return false;
        }
    }

    public static function customjob($id, $type)
    {
        $ret = '';

        if ($type == 'weapons') {
            $list = actions::get($id, 'customjob', 'weapons_list');

            if ($list != false && $list != '') {
                $price = actions::get($id, 'customjob', 'weapons_price');
                $credits = actions::get($id, 'customjob', 'weapons_credits');
                $name = actions::get($id, 'customjob', 'weapons_name');

                $list = json_decode($list, true);
                $price = json_decode($price, true);
                $credits = json_decode($credits, true);
                $name = json_decode($name, true);


                $count = 0;
                foreach ($list as $key => $value) {
                    $del = '';
                    if ($count != 0) {
                        $del = '
								<div class="col-xs-1">
									<i class="fa fa-minus-circle delWeapon" style="color: #c10000; cursor:pointer; padding-top: 14px;"></i>							
								</div>
							';
                    }

                    $ret .= '
							<div class="weapon">
								<div class="col-xs-3">
									<input type="text" name="customjob_weapons_name[' . $key . ']" num="' . $key . '" class="form-control customjob_weapons_name" style="margin-top: 5px;" placeholder="Weapon name" value="' . $name[$key] . '">
								</div>
								<div class="col-xs-4">
									<input type="text" name="customjob_weapons_wep[' . $key . ']" num="' . $key . '" class="form-control customjob_weapons_wep" style="margin-top: 5px;" placeholder="Weapon classname" value="' . $value . '">
								</div>
								<div class="col-xs-2">
									<input type="number" step="any" min="0" name="customjob_weapons_price[' . $key . ']" class="form-control" style="margin-top: 5px;" placeholder="Price" value="' . $price[$key] . '">
								</div>
								<div class="col-xs-2">
									<input type="number" step="any" min="0" name="customjob_weapons_credits[' . $key . ']" class="form-control" style="margin-top: 5px;" placeholder="Credits" value="' . $credits[$key] . '">
								</div>
								' . $del . '
							</div>
						';

                    $count++;
                }
            } else {
                $ret = '
						<div class="weapon">
							<div class="col-xs-3">
								<input type="text" name="customjob_weapons_name[0]" num="0" class="form-control customjob_weapons_name" style="margin-top: 5px;" placeholder="Weapon name">
							</div>
							<div class="col-xs-4">
								<input type="text" name="customjob_weapons_wep[0]" num="0" class="form-control customjob_weapons_wep" style="margin-top: 5px;" placeholder="Weapon classname">
							</div>
							<div class="col-xs-2">
								<input type="number" step="any" min="0" name="customjob_weapons_price[0]" class="form-control" style="margin-top: 5px;" placeholder="Price">
							</div>
							<div class="col-xs-2">
								<input type="number" step="any" min="0" name="customjob_weapons_credits[0]" class="form-control" style="margin-top: 5px;" placeholder="Credits">
							</div>
						</div>
					';
            }
        }

        if ($type == 'models') {
            $list = actions::get($id, 'customjob', 'models_list');

            if ($list != false && $list != '') {
                $model = actions::get($id, 'customjob', 'models_model');
                $price = actions::get($id, 'customjob', 'models_price');
                $credits = actions::get($id, 'customjob', 'models_credits');

                $list = json_decode($list, true);
                $model = json_decode($model, true);
                $price = json_decode($price, true);
                $credits = json_decode($credits, true);


                $count = 0;
                foreach ($list as $key => $value) {
                    $del = '';
                    if ($count != 0) {
                        $del = '
								<div class="col-xs-1">
									<i class="fa fa-minus-circle delModel" style="color: #c10000; cursor:pointer; padding-top: 14px;"></i>							
								</div>
							';
                    }

                    $ret .= '
							<div class="model">
								<div class="col-xs-3">
									<input type="text" name="customjob_models_name[' . $key . ']" num="' . $key . '" class="form-control customjob_models_name" style="margin-top: 5px;" placeholder="Model Name" value="' . $value . '">
								</div>
								<div class="col-xs-4">
									<input type="text" name="customjob_models_model[' . $key . ']" class="form-control" style="margin-top: 5px;" placeholder="Model path" value="' . $model[$key] . '">
								</div>
								<div class="col-xs-2">
									<input type="number" name="customjob_models_price[' . $key . ']" class="form-control" style="margin-top: 5px;" placeholder="Price" value="' . $price[$key] . '">
								</div>
								<div class="col-xs-2">
									<input type="number" name="customjob_models_credits[' . $key . ']" class="form-control" style="margin-top: 5px;" placeholder="Credits" value="' . $credits[$key] . '">
								</div>
								' . $del . '
							</div>
						';

                    $count++;
                }
            } else {
                $ret = '
						<div class="model">
							<div class="col-xs-3">
								<input type="text" name="customjob_models_name[0]" num="0" class="form-control customjob_models_name" style="margin-top: 5px;" placeholder="Model Name">
							</div>
							<div class="col-xs-4">
								<input type="text" name="customjob_models_model[0]" class="form-control" style="margin-top: 5px;" placeholder="Model path">
							</div>
							<div class="col-xs-2">
								<input type="number" name="customjob_models_price[0]" class="form-control" style="margin-top: 5px;" placeholder="Price">
							</div>
							<div class="col-xs-2">
								<input type="number" name="customjob_models_credits[0]" class="form-control" style="margin-top: 5px;" placeholder="Credits">
							</div>
						</div>
					';
            }
        }

        return $ret;
    }
}
