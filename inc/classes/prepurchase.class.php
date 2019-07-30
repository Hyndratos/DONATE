<?php

class prepurchase
{
    public static function hasPre($uid, $type)
    {
        global $db;

        $res = $db->getOne("SELECT id FROM prepurchase WHERE uid = ? AND type = ? AND delivered = 0 ORDER BY id DESC", [
            $uid, $type
        ]);

        if ($res) {
            return $res['id'];
        } else {
            return false;
        }
    }

    public static function getJson($id)
    {
        global $db;

        $res = $db->getOne("SELECT json FROM prepurchase WHERE id = ? ORDER BY id DESC", $id);

        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    public static function setFinished($id, $extra)
    {
        global $db;

        $db->execute("UPDATE prepurchase SET delivered = 1, extra = ? WHERE id = ?", [
            $extra, $id
        ]);
    }
}