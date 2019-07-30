<?php

class permissions
{
    public static function get($id = '')
    {
        global $db;

        $permissions = [
            "settings" => "Edit settings",
            "tos" => "Edit Terms of service",
            "frontpage" => "Edit frontpage",
            "news" => "Add/Edit news",
            "notifications" => "Edit notifications",
            "integration" => "Manage integration",
            "gateways" => "Manage gateways",
            "packages" => "Add/Edit packages",
            "servers" => "Add/Edit servers",
            "categories" => "Add/Edit categories",
            "currencies" => "Add/Edit currencies",
            "credit" => "Add/Edit credit packages",
            "raffles" => "Add/Edit raffles",
            "support" => "Answer support tickets",
            "transactions" => "See transactions",
            "permissions" => "Manage permissions",
            "users" => "Manage users",
            "sales" => "Manage sales",
            "updates" => "Manage updates",
            "logs" => "See logs",
            "stats" => "View stats",
            "api" => "Manage API",
            "other" => "See other features",
            "assign_credits" => "Assign credits",
            "assign_packages" => "Assign packages",
            "give_tickets" => "Give raffle tickets",
            "blacklist" => "Manage blacklist",
            "view_customjobs" => "View custom jobs",
            "theme" => "Edit or add themes",
            "imprint" => "Edit the imprint",
            "advent" => "Alter the advent calendar settings",
            "coupons" => "Add/Edit coupons",
            "privacy" => "Edit the Privacy Policy",
        ];

        $checked = '';

        if ($id != '') {
            $perms = $db->getOne("SELECT json FROM permission_groups WHERE id = ?", $id);

            $perms = json_decode($perms, true);
        }

        $ret = '';
        foreach ($permissions as $key => $value) {
            if ($id != '') {
                if (in_array($key, $perms) or in_array('all', $perms)) {
                    $checked = 'checked';
                }
            }

            $ret .= '
					<div class="col-lg-4 col-md-6 col-xs-12" style="margin-top: 5px;">
						<input type="checkbox" name="permissions[' . $key . ']" ' . $checked . '>
						<label>' . $value . '</label>
					</div>
				';

            $checked = '';
        }

        return $ret;
    }

    public static function value($id, $col)
    {
        global $db;

        if ($id != '') {
            return $db->getOne("SELECT $col FROM permission_groups WHERE id = ?", $id);
        } else {
            return false;
        }
    }

    public static function add($title, $json)
    {
        global $db;

        $db->execute("INSERT INTO permission_groups SET title = ?, json = ?", [
            $title, $json
        ]);
    }

    public static function update($id, $title, $json)
    {
        global $db;


        $db->execute("UPDATE permission_groups SET title = ?, json = ? WHERE id = ?", [
            $title, $json, $id
        ]);
    }

    public static function has($perm)
    {
        global $db, $UID, $cache;

        $permissions = $cache->get("permissions_" . $UID . "_" . getUrl('full'));

        if ($permissions == null) {
            $group = $db->getOne("SELECT perm_group FROM players WHERE uid = ?", $UID);
            $permissions = $db->getOne("SELECT json FROM permission_groups WHERE id = ?", $group);

            $cache->set("permissions_" . $UID . "_" . getUrl('full'), $permissions, 3600 * 23 * 7);
        }

        $permissions = json_decode($permissions, true);

        if (in_array($perm, $permissions) or in_array('all', $permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getOptions($user = null)
    {
        global $db;

        $ret = '';
        $res = $db->getAll("SELECT * FROM permission_groups");

        if ($user != null) {
            $perm_group = $db->getOne("SELECT perm_group FROM players WHERE id = ?", $user);
        }

        foreach ($res as $row) {
            $id = $row['id'];
            $title = $row['title'];

            $selected = '';
            if ($id == $perm_group) {
                $selected = 'selected';
            }

            $ret .= '
					<option value="' . $id . '" ' . $selected . '>' . $title . '</option>
				';
        }

        return $ret;
    }
}
