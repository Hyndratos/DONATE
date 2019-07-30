<?php

class prometheus
{
    public static function loggedin()
    {
        global $UID;

        if ($UID == NULL) {
            return false;
        } else {
            return true;
        }
    }

    public static function isAdmin()
    {
        global $db;
        global $UID;

        $admin = $db->getOne("SELECT admin FROM players WHERE uid = ?", [$UID])['admin'];

        if ($admin == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function log($msg, $uid)
    {
        global $db;

        $db->execute("INSERT INTO logs SET action = ?, uid = ?", [$msg, $uid]);
    }

    public static function updateCheck($return = false)
    {
        global $version;

        $nversion = str_replace('.', '', $version);

        $key = (string)getSetting('api_key', 'value');
        $url = 'http://updates.nmscripts.com/prometheus/'. $key .'/'. $nversion .'/';

        $json = cache::get("update_array");

        if ($json == null) {
            $json = file_get_contents_curl($url);

            cache::set("update_array", $json, '6h');
        }

        if ($return == false) {
            return $json;
        }

        if ($return == 'web') {
            return $url = 'http://updates.nmscripts.com/prometheus/'. $key .'/'. $nversion .'/web/';
        }

        if ($return == 'lua') {
            return $url = 'http://updates.nmscripts.com/prometheus/'. $key .'/'. $nversion .'/lua/';
        }
    }

    public static function sidebarOpen()
    {
        if (isset($_SESSION['prometheus_sidebar'])) {
            if ($_SESSION['prometheus_sidebar'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public static function lkcheck($n = null)
    {
        if ($n == null) {
            $n = getSetting('a' . $of = '' . 'pi_k' . $of = '' . 'ey', 'value');
        }
        $json = cache::get("ko");
        if ($json == NULL) {
            $json = file_get_contents_curl('http://a'.$l=''.'pi.nm'.$a=''.'scr'.$q=''.'ipts.c'.$q=''.'om/pro'.$a=''.'meth'.$v=''.'eus/va'.$v=''.'lid/'.$n);
            $a = json_decode($json, true);
            if ($a['va' . $cyka = '' . 'lid']) {
                cache::set("ko", $json, '6h');
            }
        }
        $a = json_decode($json, true);
        if ($a['va' . $lol = '' . 'lid']) {
            return true;
        } else {
            return false;
        }
    }
}