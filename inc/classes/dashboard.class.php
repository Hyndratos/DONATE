<?php

class dashboard
{
    public static function getCurrency($cur, $t = null, $e = null, $uid = null)
    {
        global $db;

        if ($uid == null) {
            if ($t == null or $t == 'total')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (txn_id <> 'Assigned by Admin' OR txn_id IS NULL)");

            if ($t == 'week')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (DATE_FORMAT(timestamp, '%U-%Y') = DATE_FORMAT(curdate(), '%U-%Y')) AND (txn_id <> 'Assigned by Admin' OR txn_id IS NULL)");

            if ($t == 'month')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (DATE_FORMAT(timestamp, '%m-%Y') = DATE_FORMAT(curdate(), '%m-%Y')) AND (txn_id <> 'Assigned by Admin' OR txn_id IS NULL)");

            if ($t == 'month' && $e != null)
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL $e MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL $e MONTH)");
        }

        if ($uid != null) {
            if ($t == null or $t == 'total')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (txn_id <> 'Assigned by Admin' OR txn_id IS NULL) AND uid = ?", [
                    $uid
                ]);

            if ($t == 'week')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (DATE_FORMAT(timestamp, '%U-%Y') = DATE_FORMAT(curdate(), '%U-%Y')) AND (txn_id <> 'Assigned by Admin' OR txn_id IS NULL) AND uid = ?", [
                    $uid
                ]);

            if ($t == 'month')
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE (DATE_FORMAT(timestamp, '%m-%Y') = DATE_FORMAT(curdate(), '%m-%Y')) AND (txn_id <> 'Assigned by Admin' OR txn_id IS NULL) AND uid = ?", [
                    $uid
                ]);

            if ($t == 'month' && $e != null)
                $price = $db->getOne("SELECT SUM(price) AS price FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL $e MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL $e MONTH) AND uid = ?", [
                    $uid
                ]);
        }

        if (is_array($price))
            $price = $price['price'];

        if ($price == null or $price == 0)
            return '0.00';
        else
            return $price;
    }

    public static function getTotalCurrency($cur, $t = null, $e = null, $nocc = false, $uid = null)
    {
        global $db;

        $ret = cache::get("getTotal_" . $t . "_" . $e . "_" . $nocc . "_" . $uid);

        if ($ret == null) {
            $cc = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $cur);

            if(!$nocc)
                $ret = $ret + dashboard::getCurrency($cur, $t, $e, $uid) . ' ' . $cc;
            else
                $ret = $ret + dashboard::getCurrency($cur, $t, $e, $uid);

            cache::set("getTotal_" . $t . "_" . $e . "_" . $nocc . "_" . $uid, $ret, '1d');
        }

        return $ret;
    }

    public static function getRevenue($type = null, $uid = null, $e = [])
    {
        global $db;

        $ret = cache::get("getRevenue_" . $type, $uid);

        if ($ret == null) {
            $arr = [];
            if ($type == 'money') {
                $cur = getSetting('dashboard_main_cc', 'value2');

                $arr[0] = dashboard::getTotalCurrency($cur, 'month', 0, true, $uid);
                $arr[1] = dashboard::getTotalCurrency($cur, 'month', 1, true, $uid);
                $arr[2] = dashboard::getTotalCurrency($cur, 'month', 2, true, $uid);
                $arr[3] = dashboard::getTotalCurrency($cur, 'month', 3, true, $uid);
                $arr[4] = dashboard::getTotalCurrency($cur, 'month', 4, true, $uid);
            }

            if ($type == 'credits') {
                if ($uid == null) {
                    $arr[0] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 0 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 0 MONTH) AND price IS NULL");
                    $arr[1] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND price IS NULL");
                    $arr[2] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 2 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH) AND price IS NULL");
                    $arr[3] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 3 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 3 MONTH) AND price IS NULL");
                    $arr[4] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 4 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 4 MONTH) AND price IS NULL");
                } else {
                    $arr[0] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 0 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 0 MONTH) AND price IS NULL AND uid = ?", $uid);
                    $arr[1] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND price IS NULL AND uid = ?", $uid);
                    $arr[2] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 2 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH) AND price IS NULL AND uid = ?", $uid);
                    $arr[3] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 3 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 3 MONTH) AND price IS NULL AND uid = ?", $uid);
                    $arr[4] = $db->getOne("SELECT SUM(credits) AS credits FROM transactions WHERE YEAR(timestamp) = YEAR(CURRENT_DATE - INTERVAL 4 MONTH) AND MONTH(timestamp) = MONTH(CURRENT_DATE - INTERVAL 4 MONTH) AND price IS NULL AND uid = ?", $uid);
                }
            }

            $ret = json_encode($arr);
            $ret = str_replace("null", "0", $ret);

            cache::set("getRevenue_" . $type, $ret, '1d', $uid);
        }

        return $ret;
    }

    public static function packageList()
    {
        global $db;

        $res = $db->getAll("SELECT * FROM packages");
        $ret = '';

        if ($res) {
            foreach ($res as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $servers = $row['servers'];
                $enabled = $row['enabled'];

                $servers = str_replace('[', '', $servers);
                $servers = str_replace(']', '', $servers);
                $servers = str_replace('"', '', $servers);
                $servers = str_replace(',', ', ', $servers);

                if ($enabled == 1) {
                    $astring = '<button type="submit" name="package_disable" class="btn btn-prom">' . lang("disable", "Disable") . '</button>';
                } else {
                    $astring = '<button type="submit" name="package_enable" class="btn btn-success">' . lang("enable", "Enable") . '</button>';
                }

                $actions = '
                        <form method="POST">
                            <input type="hidden" name="hidden" value="' . $id . '" style="display: inline-block;">
                            ' . $astring . '
                            <button type="button" name="package_set_inactive" class="btn btn-warning" href="" data-toggle="modal" data-target="#inactiveModal_' . $id . '">' . lang("inactive_everyone", "Set inactive for everyone") . '</button>
                            <button type="button" name="package_set_active" class="btn btn-warning" href="" data-toggle="modal" data-target="#activeModal_' . $id . '">' . lang("active_everyone", "Set active for everyone") . '</button>
                            <button type="button" name="package_delete" class="btn btn-danger" href="" data-toggle="modal" data-target="#deleteModal_' . $id . '">' . lang("del", "Del") . '</button>
                            <a href="admin.php?a=pkg&edit&id=' . $id . '" class="btn btn-default">' . lang("edit", "Edit") . '</a>
                            
                            <div class="modal fade" id="deleteModal_' . $id . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Are you sure?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this package?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Yes" class="btn btn-prom" name="package_delete">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="inactiveModal_' . $id . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Are you sure?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to set all inactive for this package?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Yes" class="btn btn-prom" name="package_set_inactive">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="activeModal_' . $id . '">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Are you sure?</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to set all active for this package?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Yes" class="btn btn-prom" name="package_set_active">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    ';

                $ret .= '
                        <tr>
                            <td>' . $id . '</td>
                            <td>' . $title . '</td>
                            <td>' . $servers . '</td>
                            <td>' . $actions . '</td>
                        </tr>
                    ';
            }
        } else {
            $ret = '
                    <tr>
                        <td>' . lang('no_packages', 'You currently have no packages on the system') . '</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                ';
        }

        return $ret;
    }

    public static function getPackageSales($atr = null)
    {
        global $db;

        $ret = cache::get("getPackageSales");

        if ($ret == null) {

            $res = $db->getAll("SELECT DISTINCT package FROM transactions WHERE package IS NOT NULL");

            // Initiate vars
            $ret = [];
            $array = array();

            $json = array();
            $label = '';
            $colour = '';

            if ($res != null)
                foreach ($res as $row)
                    $array[$row['package']] = $db->getOne("SELECT count(*) AS count FROM transactions WHERE package = ?", $row['package']);

            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $label = $db->getOne("SELECT title FROM packages WHERE id = ?", [$key])['title'];

                    $rand = dechex(rand(0x000000, 0xFFFFFF));
                    $colour = $rand;

                    $json[] = [
                        "value" => $value,
                        "color" => "#" . $colour,
                        "highlight" => "#" . $colour,
                        "label" => $label,
                    ];
                }
            } else {
                $json = [
                    "value" => 1,
                    "color" => "#1d1d1d",
                    "highlight" => "#1d1d1d",
                    "label" => "No packages sold!"
                ];
            }

            $ret = json_encode($json);

            cache::set("getPackageSales", $ret, '1y');
        }

        return $ret;
    }

    public static function getServerSales($atr = null)
    {
        global $db;

        $ret = cache::get("getServerSales");

        if ($ret == null) {

            $res = $db->getAll("SELECT DISTINCT package FROM transactions WHERE package IS NOT NULL");

            // Initiate vars
            $ret = [];
            $servers = '';
            $packages = [];
            $ids = '';

            $json = array();
            $array = array();
            $label = '';
            $colour = '';

            if ($res != null) {
                foreach ($res as $row) {
                    $packages[] = $row['package'];
                }
            }

            foreach ($packages as $pack) {
                $servers .= $db->getOne("SELECT servers FROM packages WHERE id = ?", [$pack])['servers'];
            }

            $servers = str_replace(',', '][', $servers);
            $servers = str_replace('["', '', $servers);
            $servers = str_replace('"]', ',', $servers);
            $servers = rtrim($servers, ',');

            $servers = explode(',', $servers);
            $servers = array_unique($servers);

            foreach ($servers as $key => $value) {
                $array[$value] = $db->getOne("SELECT count(*) AS value FROM transactions t JOIN packages p ON t.package = p.id WHERE p.servers LIKE ? AND t.name != 'Assigned by Admin' AND t.package IS NOT NULL", ['%"' . $value . '"%'])['value'];
            }

            if (!empty($array)) {
                foreach ($array as $key => $value) {
                    $label = $db->getOne("SELECT name FROM servers WHERE id = ?", $key);

                    $rand = dechex(rand(0x000000, 0xFFFFFF));
                    $colour = $rand;

                    $json[] = [
                        "value" => $value,
                        "color" => "#" . $colour,
                        "highlight" => "#" . $colour,
                        "label" => $label,
                    ];
                }
            } else {
                $json = [
                    "value" => 1,
                    "color" => "#1d1d1d",
                    "highlight" => "#1d1d1d",
                    "label" => "No packages sold!"
                ];
            }

            $ret = json_encode($json);

            cache::set("getServerSales", $ret, '1y');
        } 

        return $ret;
    }

    public static function currencyCount()
    {
        global $db;

        return $db->getOne("SELECT count(*) AS value FROM currencies")['value'];
    }

    public static function paging($p)
    {
        global $db;

        if ($p == 'log') {
            $max = $db->getOne("SELECT count(*) AS value FROM transactions")['value'];
            $site = 'admin.php?page=transactions';
        }

        if ($p == 'users') {
            $max = $db->getOne("SELECT count(*) AS value FROM players")['value'];
            $site = 'admin.php?page=users';
        }

        if ($p == 'logs') {
            $max = $db->getOne("SELECT count(*) AS value FROM logs")['value'];
            $site = 'admin.php?page=logs';
        }

        $needed = ceil($max / 9);
        if ($needed == 0) {
            $needed = 1;
        }

        if (!isset($_GET['p'])) {
            $curpage = 1;
        } else {
            $curpage = $_GET['p'];
        }

        $next = $curpage + 1;
        if ($curpage >= $needed) {
            $next = $needed;
        }

        $prev = $curpage - 1;
        if ($curpage <= 1) {
            $prev = 1;
        }

        $pages = '';

        $firstpage = 1;
        $lastpage = 10;
        if ($curpage > 5) {
            $firstpage = $curpage - 5;
            $lastpage = $curpage + 5;
        }

        for ($i = $firstpage; $i <= $needed; $i++) {
            if ($curpage == $i) {
                $active = 'active';
            } else {
                $active = '';
            }

            if ($i <= $lastpage) {
                $pages .= '
                        <li class="' . $active . '"><a href="' . $site . '&p=' . $i . '">' . $i . '</a></li>
                    ';
            }
        }

        if ($curpage <= 1) {
            $curpage = 1;
        }

        $first_class = '';
        if ($curpage == 1) {
            $first_class = 'disabled';
        }

        $last_class = '';
        if ($curpage == $needed) {
            $last_class = 'disabled';
        }

        $ret = '';
        $ret .= '
                <div class="row" style="text-align: right;">
                    <div class="col-xs-12">
                        <nav>
                            <ul class="pagination">
                                <li class="' . $first_class . '"><a href="' . $site . '&p=1"><span aria-hidden="true">&laquo;&laquo;</span><span class="sr-only">First</span></a></li>
                                <li class="' . $first_class . '"><a href="' . $site . '&p=' . $prev . '"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                ' . $pages . '
                                <li class="' . $last_class . '"><a href="' . $site . '&p=' . $next . '"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                                <li class="' . $last_class . '"><a href="' . $site . '&p=' . $needed . '"><span aria-hidden="true">&raquo;&raquo;</span><span class="sr-only">Last</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            ';

        return $ret;
    }

    public static function getMax($q)
    {
        global $db;

        if ($q == 'log') {
            $max = $db->getOne("SELECT count(*) AS value FROM transactions")['value'];
        }

        if ($q == 'users') {
            $max = $db->getOne("SELECT count(*) AS value FROM players")['value'];
        }

        if ($q == 'logs') {
            $max = $db->getOne("SELECT count(*) AS value FROM logs")['value'];
        }

        if (isset($_GET['p'])) {
            $p = ($_GET['p'] - 1) * 9;
        } else {
            $p = 0;
        }

        return $p;
    }

    public static function getBlacklist()
    {
        global $db;

        $ret = '';
        $res = $db->getAll("SELECT * FROM blacklist");

        if ($res) {
            foreach ($res as $row) {
                $id = $row['id'];
                $name = $row['name'];
                $steam64 = $row['steam64'];
                $steamid = $row['steamid'];
                $timestamp = $row['timestamp'];

                if(empty($name))
                    $name = 'Unnamed';

                $actions = '
                        <form method="POST">
                            <input type="hidden" name="hidden" value="' . $id . '">
                            <button class="btn btn-danger" name="blacklist_del">Delete</button>
                        </form>
                    ';

                $ret .= '
                        <tr>
                            <td>' . $name . '</td>
                            <td>' . $steam64 . '</td>
                            <td>' . $steamid . '</td>
                            <td>' . $timestamp . '</td>
                            <td>' . $actions . '</td>
                        </tr>
                    ';
            }
        } else {
            $ret = '
                    <tr>
                        <td>Nobody is currently blacklisted</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>               
                ';
        }

        return $ret;
    }

    public static function addToBlacklist($uid)
    {
        global $db;

        $url = "http://steamcommunity.com/profiles/" . $uid . "/?xml=1";
        $xml = simplexml_load_file($url);
        $name = $xml->steamID;

        $steamid = convertCommunityIdToSteamId($uid);

        $db->execute("INSERT INTO blacklist SET name = ?, steam64 = ?, steamid = ?", [
            $name, $uid, $steamid
        ]);
    }

    public static function getLogs()
    {
        global $db;

        $ret = '';
        $res = $db->getAll("SELECT * FROM logs ORDER BY id DESC LIMIT " . dashboard::getMax('logs') . ",10");

        if ($res) {
            foreach ($res as $row) {
                $action = $row['action'];
                $uid = $row['uid'];
                $timestamp = $row['timestamp'];

                $name = $db->getOne("SELECT name FROM players WHERE uid = ?", [$uid])['name'];

                $ret .= '
                        <tr>
                            <td>' . $action . '</td>
                            <td>' . $name . '</td>
                            <td>' . $timestamp . '</td>
                        </tr>
                    ';
            }
        } else {
            $ret = '
                    <tr>
                        <td>There hasn\'t been anything to keep track of</td>
                        <td></td>
                        <td></td>
                    </tr>
                ';
        }

        return $ret;
    }

    public static function transactionAmount()
    {
        global $db;

        return $db->getOne("SELECT count(*) FROM transactions");
    }

    public static function getRecent()
    {
        global $db;

        $ret = cache::get('recentDonators');

        if ($ret == null) {
            $limit = getSetting('show_recent', 'value');
            if ($limit == '' or !is_numeric($limit)) {
                $limit = 10;
            }

            $ret = '';
            $res = $db->getAll("SELECT p.id, p.name, t.package, t.price, t.credits, t.currency, t.timestamp, t.uid FROM transactions t JOIN players p ON t.uid = p.uid WHERE t.price IS NOT NULL AND t.txn_id != 'Assigned by Admin' ORDER BY t.id DESC LIMIT $limit");

            if ($res) {
                foreach ($res as $row) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $pid = $row['package'];
                    $uid = $row['uid'];
                    $p_name = $db->getOne("SELECT title FROM packages WHERE id = ?", $pid);
                    $currency = $row['currency'];

                    if (prometheus::isAdmin())
                        $link = 'admin.php?page=users&id=' . $id;
                    else
                        $link = 'http://steamcommunity.com/profiles/' . $uid . '/';

                    if(empty($name))
                        $name = 'Unnamed';

                    $total = round($row['price'], 2);
                    $credits = $row['credits'];

                    if ($total != 0) {
                        $cur = getSetting("dashboard_main_cc", 'value2');
                        $cur = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $cur);

                        if ($currency != $cur) {
                            $total = round(convertCur($currency, $total, $cur), 2);
                        }

                        $amount = $total . ' ' . $cur;
                    } else {
                        $amount = $credits . ' ' . lang('credits', 'Credits');
                    }

                    $timestamp = $row['timestamp'];

                    $ret .= '
                            <tr>
                                <td><a href="' . $link . '" target="_blank">' . $name . '</a></td>
                                <td>' . $p_name . '</td>
                                <td>' . $amount . '</td>
                                <td>' . $timestamp . '</td>
                            </tr>
                        ';
                }
            } else {
                $ret = '
                        <tr>
                            <td>' . lang('recent_none', 'There has not been any recent donators') . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    ';
            }

            cache::set('recentDonators', $ret, '1y');
        }

        return $ret;
    }

    public static function getTopDonators()
    {
        global $db;

        $ret = cache::get('topDonators');

        if ($ret == null) {
            $limit = getSetting('show_top', 'value');
            if ($limit == '' or !is_numeric($limit)) {
                $limit = 3;
            }

            $ret = '';
            $res = $db->getAll("SELECT SUM(t.price) AS total, p.id, p.name, t.uid FROM transactions t LEFT JOIN players p ON t.uid = p.uid WHERE t.price IS NOT NULL AND t.txn_id != 'Assigned by Admin' 
                GROUP BY p.id, p.name, t.uid ORDER BY total DESC LIMIT $limit");

            $cur = getSetting("dashboard_main_cc", 'value2');
            $currency = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $cur);

            if ($res) {
                foreach ($res as $row) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $uid = $row['uid'];
                    $total = round($row['total'], 2);

                    if(empty($name))
                        $name = 'Unnamed';

                    if (prometheus::isAdmin())
                        $link = 'admin.php?page=users&id=' . $id;
                    else
                        $link = 'http://steamcommunity.com/profiles/' . $uid . '/';

                    $ret .= '
                            <tr>
                                <td><a href="' . $link . '" target="_blank">' . $name . '</a></td>
                                <td>' . $total . ' ' . $currency . '</td>
                            </tr>
                        ';
                }
            } else {
                $ret = '
                        <tr>
                            <td>' . lang('top_none', 'There are no top donators') . '</td>
                            <td></td>
                        </tr>
                    ';
            }

            cache::set('topDonators', $ret, '1y');
        }

        return $ret;
    }
}
