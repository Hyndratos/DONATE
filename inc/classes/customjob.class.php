<?php

class customjob
{
    public static function getWeapons($id, $enabled)
    {
        $ret = '';

        if ($enabled) {
            $list = actions::get($id, 'customjob', 'weapons_list');

            $cur = getEditPackage($id, 'curname');

            if ($list != false && $list != '') {
                $price = actions::get($id, 'customjob', 'weapons_price');
                $credits = actions::get($id, 'customjob', 'weapons_credits');
                $name = actions::get($id, 'customjob', 'weapons_name');

                $list = json_decode($list, true);
                $price = json_decode($price, true);
                $credits = json_decode($credits, true);
                $name = json_decode($name, true);

                foreach ($list as $key => $value) {
                    if(gateways::enabled('credits'))
                        $lang = lang('job_costs', 'Costs $1 or $2 credits', [$price[$key] . ' ' . $cur, $credits[$key]]);
                    else
                        $lang = lang('job_costs_money', 'Costs $1', [$price[$key] . ' ' . $cur]);

                    $ret .= '
							<div class="checkbox">
								<input type="checkbox" class="weapon" name="weapon[' . $key . ']" price="' . $price[$key] . '" credits="' . $credits[$key] . '">
								<label>' . $name[$key] . ' (' . $value . ') - ' . $lang . '</label>
							</div>
						';
                }
            } else {
                $ret = '
						No weapons specified. Notify your server admin about this.
					';
            }
        } else {
            $list = actions::get($id, 'customjob', 'weapons_static');

            if ($list == '') {
                $ret = 'This custom job has no weapons';
            } else {
                $list = explode(',', $list);

                $ret .= '<ul>';

                foreach ($list as $weapon) {
                    $ret .= '<li>' . $weapon . '</li>';
                }

                $ret .= '</ul>';
            }
        }

        return $ret;
    }

    public static function getModels($id, $enabled)
    {
        $ret = '';

        if ($enabled) {
            $list = actions::get($id, 'customjob', 'models_list');

            $cur = getEditPackage($id, 'curname');

            if ($list != false && $list != '') {
                $price = actions::get($id, 'customjob', 'models_price');
                $credits = actions::get($id, 'customjob', 'models_credits');

                $list = json_decode($list, true);
                $price = json_decode($price, true);
                $credits = json_decode($credits, true);

                foreach ($list as $key => $value) {
                    if(gateways::enabled('credits'))
                        $lang = lang('job_costs', 'Costs $1 or $2 credits', [$price[$key] . ' ' . $cur, $credits[$key]]);
                    else
                        $lang = lang('job_costs_money', 'Costs $1', [$price[$key] . ' ' . $cur]);

                    $ret .= '
							<div class="checkbox">
								<input type="checkbox" class="model" name="model[' . $key . ']" price="' . $price[$key] . '" credits="' . $credits[$key] . '">
								<label>' . $value . ' - ' . $lang . '</label>
							</div>
						';
                }
            } else {
                $ret = '
						No models specified. Notify your server admin about this.
					';
            }
        } else {
            $list = actions::get($id, 'customjob', 'models_static');

            if ($list == '') {
                $ret = 'This custom job has no models';
            } else {
                $list = explode(',', $list);

                $ret .= '<ul>';

                foreach ($list as $model) {
                    $ret .= '<li>' . $model . '</li>';
                }

                $ret .= '</ul>';
            }
        }

        return $ret;
    }

    public static function getTable()
    {
        global $db;

        $disable_customjob = getSetting('disable_customjob', 'value2');

        if ($disable_customjob == 0) {
            $res = $db->getAll("SELECT p.id, a.actions, p.extra, p.uid, p.json AS info, a.server, a.timestamp FROM prepurchase p JOIN actions a ON p.uid = a.uid WHERE p.type = 'customjob' AND a.active = 1 AND a.actions LIKE '%\"customjob\":%' AND p.delivered = 1 GROUP BY p.id");
        } else {
            $res = $db->getAll("SELECT id, uid, extra, json AS info, timestamp FROM prepurchase WHERE type = 'customjob'");
        }

        $ret = '';

        if ($res) {
            foreach ($res as $row) {
                $id = $row['id'];
                $info = $row['info'];
                $uid = $row['uid'];
                $timestamp = $row['timestamp'];

                if($disable_customjob == 0) {
                    $actions = $row['actions'];

                    if ($row['extra'] == '') {
                        $array = json_decode($actions, true);
                        $code = $array['customjob']['code'];
                    } else {
                        $code = display($row['extra']);
                    }
                } else {
                    $code = display($row['extra']);
                }

                $info = json_decode($info, true);

                $actions = '
						<span class="showCode btn btn-prom">Show code</span>
					';

                $people = convertCommunityIdToSteamId($uid) . ',' . $info['friends'];
                $people = rtrim($people, ',');

                $ret .= '
						<tr>
							<td>' . $info['name'] . '</td>
							<td>' . $people . '</td>
							<td>
								<span style="display: none;" id="id">' . $id . '</span>
								<span style="display: none;" id="timestamp">' . $timestamp . '</span>
								<span style="display: none;" id="code">' . $code . '</span>
								' . $actions . '
							</td>
						</tr>
					';
            }
        } else {
            $ret = '
					<tr>
						<td>There are no active custom jobs at the moment</td>
						<td></td>
						<td></td>
					</tr>
				';
        }

        return $ret;
    }
}