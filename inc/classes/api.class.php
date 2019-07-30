<?php

class api
{
    public static function validHash($hash)
    {
        if ($hash == getSetting('api_hash', 'value')) {
            return true;
        } else {
            return false;
        }
    }

    public static function validSteam($id)
    {
        if (is_numeric($id) && strlen($id) == 17 or strpos($id, 'STEAM_0:') !== FALSE) {
            return true;
        } else {
            return false;
        }
    }

    public static function packageExists($id)
    {
        global $db;

        $res = $db->getOne("SELECT count(*) AS value FROM packages WHERE id = ?", [$id])['value'];

        if ($res == 1) {
            return true;
        } else {
            return false;
        }
    }
}