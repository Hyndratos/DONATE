<?php

/**
 *
 * @package Steam Community API
 * @copyright (c) 2010 ichimonai.com
 * @license http://opensource.org/licenses/mit-license.php The MIT License
 *
 */
class SteamSignIn
{
    const STEAM_LOGIN = 'https://steamcommunity.com/openid/login';

    /**
     * Get the URL to sign into steam
     *
     * @param mixed returnTo URI to tell steam where to return, MUST BE THE FULL URI WITH THE PROTOCOL
     * @param bool useAmp Use &amp; in the URL, true; or just &, false.
     * @return string The string to go in the URL
     */
    public static function genUrl($returnTo = false, $useAmp = true)
    {
        global $using_ssl;

        if(!isset($using_ssl))
            $using_ssl = false;

        if ($using_ssl)
            $ssl = 'https';
        else
            $ssl = 'http';

        if (!isset($_SERVER['HTTP_HOST']))
            $_SERVER['HTTP_HOST'] = '';

        if (!isset($_SERVER['SCRIPT_NAME']))
            $_SERVER['SCRIPT_NAME'] = '';

        if ($_SERVER['HTTP_HOST'] == $_SERVER['SCRIPT_NAME']) {
            $returnTo = $ssl . '://' . $_SERVER['HTTP_HOST'];
        } elseif (stripos(strtolower($_SERVER['SCRIPT_NAME']), 'http://') !== false) {
            $url = str_replace('http://', '', strtolower($_SERVER['SCRIPT_NAME']));
            $returnTo = $ssl . '://' . $url;
        } else {
            $returnTo = $ssl . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        }

        $params = array(
            'openid.ns' => 'http://specs.openid.net/auth/2.0',
            'openid.mode' => 'checkid_setup',
            'openid.return_to' => $returnTo,
            'openid.realm' => $ssl . '://' . $_SERVER['HTTP_HOST'],
            'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        );

        $sep = ($useAmp) ? '&amp;' : '&';
        return self::STEAM_LOGIN . '?' . http_build_query($params, '', $sep);
    }

    /**
     * Validate the incoming data
     *
     * @return string Returns the SteamID64 if successful or empty string on failure
     */
    public static function validate()
    {
        // Star off with some basic params
        if (isset($_GET['openid_assoc_handle']) && isset($_GET['openid_signed']) && isset($_GET['openid_sig'])) {
            $params = array(
                'openid.assoc_handle' => $_GET['openid_assoc_handle'],
                'openid.signed' => $_GET['openid_signed'],
                'openid.sig' => $_GET['openid_sig'],
                'openid.ns' => 'http://specs.openid.net/auth/2.0',
            );
        }

        // Get all the params that were sent back and resend them for validation
        $signed = '';
        if (isset($_GET['openid_signed']))
            $signed = explode(',', $_GET['openid_signed']);

        if ($signed != '') {
            foreach ($signed as $item) {
                $val = $_GET['openid_' . str_replace('.', '_', $item)];
                $params['openid.' . $item] = get_magic_quotes_gpc() ? stripslashes($val) : $val;
            }
        }

        // Finally, add the all important mode.
        $params['openid.mode'] = 'check_authentication';

        // Stored to send a Content-Length header
        $data = http_build_query($params);
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                    "Accept-language: en\r\n" .
                    "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ));

        $result = file_get_contents(self::STEAM_LOGIN, false, $context);

        // Validate wheather it's true and if we have a good ID
        if (isset($_GET['openid_claimed_id'])) {
            preg_match("#^http://steamcommunity.com/openid/id/([0-9]{17,25})#", $_GET['openid_claimed_id'], $matches);
            $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;
        }

        // Return our final value
        return preg_match("#is_valid\s*:\s*true#i", $result) == 1 ? $steamID64 : '';
    }
}
