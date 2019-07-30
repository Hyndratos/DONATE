<?php

class cache
{

    /**
     * @param string identifier
     * @param string value
     * @param string /int
     * @param string
     * @param string
     */
    public static function set($identifier, $value, $time, $uid = '', $extra = '')
    {
        global $cache;

        if ($extra != '') {
            $extra = '_' . $extra;
        }

        if ($uid != '') {
            $uid = '_' . $uid;
        }

        preg_match('/\d[h]|\d[d]|\d[w]|\d[m]|\d[y]/', $time, $match);
        if (isset($match[0])) {
            $time = timeStrToInt($match[0]);
        }

        $fullIdentifier = $identifier . $uid . $extra;

        $cache->set($fullIdentifier, $value, $time);
    }

    /**
     * @param  string identifier
     * @param  string
     * @param  string
     * @return string
     */
    public static function get($identifier, $uid = '', $extra = '')
    {
        global $cache;

        if ($extra != '') {
            $extra = '_' . $extra;
        }

        if ($uid != '') {
            $uid = '_' . $uid;
        }

        $fullIdentifier = $identifier . $uid . $extra;

        return $cache->get($fullIdentifier);
    }

    /**
     * @param  string identifier
     * @param  string
     * @param  string
     * @return [type]
     */
    public static function del($identifier, $uid = '', $extra = '')
    {
        global $cache;

        if ($extra != '') {
            $extra = '_' . $extra;
        }

        if ($uid != '') {
            $uid = '_' . $uid;
        }

        $fullIdentifier = $identifier . $uid . $extra;

        $cache->delete($fullIdentifier);
    }

    public static function clear($action = null, $uid = '')
    {
        global $cache;

        if ($uid != '')
            if (prometheus::loggedin())
                $uid = $_SESSION['uid'];

        if ($action == null)
            $cache->clean();

        if ($action == 'purchase') {

            cache::del('getPackageSales');
            cache::del('getServerSales');
            cache::del('dashboard_currencies');
            cache::del('topDonators');
            cache::del('recentDonators');
            cache::del('getRevenue_money');
            cache::del('getRevenue_credits');

            if ($uid != '') {
                cache::del('getRevenue_money', $uid);
                cache::del('getRevenue_credits', $uid);
                cache::del('credits', $uid);
                cache::del('getPackageHistory', $uid);
                cache::del('getPermanentPackages', $uid);
                cache::del('getNonPermanentPackages', $uid);
            }

        }

        if ($action == 'settings') {

            cache::del('settings');

        }

        if ($action == 'actions') {

            cache::del('actions');

        }

        if ($action == 'servers') {

            cache::del('servers');

        }

        if ($action == 'news') {

            cache::del('news_sidebar');

        }

        if ($action == 'frontpage') {

            cache::del('frontpage');

        }
    }
}