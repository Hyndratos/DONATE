<?php

class packages
{
    public static function alreadyOwn($p, $for = null)
    {
        global $db;
        global $UID;

        if ($for == null) {
            $res = $db->getOne("SELECT package FROM actions WHERE uid = ? AND active = 1 AND package = ?", array($UID, $p))['package'];
        } else {
            $res = $db->getOne("SELECT package FROM actions WHERE uid = ? AND active = 1 AND package = ?", array($for, $p))['package'];
        }

        if ($res != NULL) {
            return true;
        } else {
            return false;
        }
    } 

    public static function ownedOnce($p, $for = null)
    {
        global $db;
        global $UID;

        if ($for == null) {
            $res = $db->getOne("SELECT package FROM actions WHERE uid = ? AND package = ?", array($UID, $p))['package'];
        } else {
            $res = $db->getOne("SELECT package FROM actions WHERE uid = ? AND package = ?", array($for, $p))['package'];
        }

        if ($res != NULL) {
            return true;
        } else {
            return false;
        }
    }

    public static function hide($id, $for = null)
    {
        global $db;

        $count = 0;
        $res = $db->getOne("SELECT hide FROM packages WHERE id = ?", $id);

        $hide = false;
        $packages = '';

        if ($res != '[]') {

            $res = json_decode($res, true);

            foreach ($res as $pkg) {
                if (packages::alreadyOwn($pkg, $for)) {
                    $count++;
                } else {
                    $pkgName = getEditPackage($pkg, 'title');
                    $packages .= '<li>' . $pkgName . '</li>, ';
                }
            }

            $packages = '<br><br><span style="color: gray; font-family: arial; font-size: 16px;"><ul>' . rtrim($packages, '</li>, ') . '</ul></span>';

            if ($count == 0) {
                $hide = true;
            } else {
                $hide = false;
            }
        }

        $arr = [
            'hide' => $hide,
            'packages' => $packages
        ];

        return $arr;
    }

    public static function ownsFree($p, $for = null)
    {
        global $db;
        global $UID;

        if($for == null)
            $for = $UID;

        $res = $db->getOne("SELECT a.package FROM actions a JOIN packages p ON p.id = a.package WHERE a.uid = ? AND a.package = ? AND p.price = 0 AND p.credits = 0", array($for, $p))['package'];

        if ($res != NULL)
            return true;
        else
            return false;
    }

    public static function notCompatible($p, $for = null)
    {
        global $db;
        global $UID;

        if($for == null)
            $for = $UID;

        $res = $db->getAll("SELECT t.package, p.non_compatible
            FROM transactions t 
            JOIN actions a ON (a.uid = t.uid) 
            JOIN packages p ON (p.id = t.package)
            WHERE t.uid = ? 
            AND a.active = 1
            AND t.package IS NOT NULL
            GROUP BY t.package", 
        [$for]);

        foreach ($res as $pack) {
            $comp = $pack['non_compatible'];

            if ($comp != '[]') {
                $comp = json_decode($comp, true);

                if ($comp == NULL) $comp = [];

                if (in_array($p, $comp, true))
                    return true;
                else
                    return false;
            } else {
                return false;
            }
        }
    }

    public static function upgradeable($p, $a = null, $for = null)
    {
        global $db, $UID;

        if (is_numeric($a)) {
            $a = null;
        }

        $upgradeableFrom = $db->getOne("SELECT upgradeable FROM packages WHERE id = ?", $p);

        if ($upgradeableFrom != '[]') {
            $upgradeableFrom = json_decode($upgradeableFrom, true);
            $upgradeableFrom = $upgradeableFrom[0];

            if ($for == null) {
                $res = $db->getAll("SELECT * FROM transactions t JOIN actions a ON a.uid = t.uid WHERE t.uid = ? AND t.package = ? AND a.active = 1", [
                    $UID, $upgradeableFrom
                ]);
            } else {
                $res = $db->getAll("SELECT * FROM transactions t JOIN actions a ON a.uid = t.uid WHERE t.uid = ? AND t.package = ? AND a.active = 1", [
                    $for, $upgradeableFrom
                ]);
            }

            if ($res) {
                if ($a == 'list') {
                    return $upgradeableFrom;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function upgradeInfo($id, $pkg, $type, $extra = null)
    {
        global $db;

        if ($type == 'price') {
            if ($extra == null) {
                $extra = $db->getOne("SELECT price FROM packages WHERE id = ?", $id);
            }

            $pkg_price = $db->getOne("SELECT price FROM packages WHERE id = ?", $pkg);
            $ret = $extra - $pkg_price;
        }

        if ($type == 'credits') {
            if ($extra == null) {
                $extra = $db->getOne("SELECT credits FROM packages WHERE id = ?", $id);
            }

            $pkg_credits = $db->getOne("SELECT credits FROM packages WHERE id = ?", $pkg);
            $ret = $extra - $pkg_credits;
        }

        if ($type == 'name') {
            $pkg_name = $db->getOne("SELECT title FROM packages WHERE id = ?", $pkg);

            $ret = $pkg_name;
        }

        return $ret;
    }

    public static function disabled($pid)
    {
        global $db;

        $enabled = $db->getOne("SELECT enabled FROM packages WHERE id = ?", $pid);

        if ($enabled == 1) {
            return false;
        } else {
            return true;
        }
    }

    public static function rebuyable($pid)
    {
        global $db;

        $rebuyable = $db->getOne("SELECT rebuyable FROM packages WHERE id = ?", $pid);

        if ($rebuyable == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAboveMinAmount($pid, $amt)
    {
        global $db;

        $custom_price = $db->getOne("SELECT custom_price FROM packages WHERE id = ?", $pid);
        $custom_price_min = $db->getOne("SELECT custom_price_min FROM packages WHERE id = ?", $pid);

        if ($custom_price == 1) {
            if ($amt < $custom_price_min) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getPreview($id, $coupon = false)
    {
        global $db;

        $ret = '';
        $res = $db->getAll("SELECT * FROM packages WHERE id = ?", $id);

        $sale_ar = getSetting('sale_packages', 'value');
        $sale_ar = json_decode($sale_ar, true);
        $perc = getSetting('sale_percentage', 'value2');

        $cur = getSetting('dashboard_main_cc', 'value2');
        $cc = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $cur);

        foreach ($res as $row) {
            $title = $row['title'];
            $price = $row['price'];
            $credits = $row['credits'];
            $labels = $row['labels'];
            $lower_text = $row['lower_text'];
            $permanent = $row['permanent'];
            $custom_price = $row['custom_price'];

            if ($permanent == 0)
                $perm = lang('non_permanent');
            else
                $perm = lang('permanent');

            $oldprice = '';
            $credits_old = '';

            $upgrade = packages::upgradeable($id);
            if ($upgrade) {
                $pkg = packages::upgradeable($id, 'list');
                $credits = packages::upgradeInfo($id, $pkg, 'credits', $credits);
                $price = packages::upgradeInfo($id, $pkg, 'price', $price);
                $pkg_name = packages::upgradeInfo($id, $pkg, 'name');
            }

            if ($custom_price == 0) {
                if (store::sale($id, $sale_ar, $perc)) {
                    $oldprice = '<s style="font-size: 30px; color: #c10000;">' . $price . ' ' . $cc . '</s>';
                    $orgprice = $price;
                    $price = $perc / 100 * $orgprice;
                    $price = $orgprice - $price;
                    $price = number_format($price, 2, '.', '');

                    $credits_old = '<s style="font-size: 30px; color: #c10000;">' . $credits . '</s>';
                    $credits = $credits * (100 - $perc) / 100;
                }

                if($coupon != false && getSetting('enable_coupons', 'value2') == 1){
                    if(coupon::isValid($coupon, $id)){
                        $coupon_id = coupon::getIdByCode($coupon);

                        $coupon_percent = coupon::getValue($coupon_id, 'percent');

                        if($coupon_percent == 100){
                            $price = 0;
                            $credits = 0;
                        } else {
                            $orgprice = $price;
                            $price = $coupon_percent / 100 * $orgprice;
                            $price = $orgprice - $price;
                            $price = number_format($price, 2, '.', '');

                            $credits = $credits * (100 - $coupon_percent) / 100;
                        }
                    }
                }
            }

            $price_block = '';
            if (getSetting('credits_only', 'value2') == 0 && !gateways::enabled('credits'))
                $price_block = '<span>' . $price . ' ' . $cc . ' ' . $oldprice . '</span>';
            elseif (getSetting('credits_only', 'value2') == 0 && gateways::enabled('credits'))
                $price_block = '
                        <span>
                            ' . $price . ' ' . $cc . ' ' . $oldprice . '<br>
                            ' . $credits . ' ' . lang("credits") . ' ' . $credits_old . '
                        </span>
                    ';
            elseif (getSetting('credits_only', 'value2') == 1)
                $price_block = '
                        <span>
                            ' . $credits . ' ' . lang("credits") . ' ' . $credits_old . '
                        </span>
                    ';

            if ($custom_price == 1)
                $price_block = '<span>' . $_GET['price'] . ' ' . $cc . ' ' . $oldprice . '</span>';

            $label = '';

            if ($labels != '[]' && $labels != null) {
                $labels = json_decode($labels, true);

                if (count($labels) != 0) {
                    $label = '';
                    foreach ($labels as $key => $value) {
                        $label .= '
                                <li>' . $value . '</li>
                            ';
                    }
                }
            }

            $customjob = actions::get($id, 'customjob', '') ? true : false;

            if (!$customjob) {
                $ret = '
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <div class="store-box-header">' . $title . '</div>
                            <div class="store-box">
                                <div class="store-box-upper">
                                    ' . $price_block . '
                                    <ul style="margin-bottom: 0;">
                                        <li style="border-top: 0px; border-bottom: 0px;"><b>' . $perm . '</b></li>
                                    </ul>
                                    <ul>
                                        ' . $label . '
                                    </ul>
                                </div>
                                <div class="store-box-lower">
                                    ' . $lower_text . '
                                </div>
                            </div>
                        </div>
                    ';
            } else {
                $pre = prepurchase::hasPre($_SESSION['uid'], 'customjob');
                $json = prepurchase::getJson($pre);
                $array = json_decode($json, true);

                $price = $array['fullTotalPrice'];
                $credits = $array['fullTotalCredits'];

                $price_block = '';
                if (getSetting('credits_only', 'value2') == 0 && !gateways::enabled('credits')) {
                    $price_block = '<span>' . $price . ' ' . $cc . '</span>';
                } elseif (getSetting('credits_only', 'value2') == 0 && gateways::enabled('credits')) {
                    $price_block = '
                            <span>
                                ' . $price . ' ' . $cc . '<br>
                                ' . $credits . ' ' . lang("credits") . '
                            </span>
                        ';
                } elseif (getSetting('credits_only', 'value2') == 1) {
                    $price_block = '
                            <span>
                                ' . $credits . ' ' . lang("credits") . '
                            </span>
                        ';
                }

                if ($array['weapons'] != '') {
                    $weaponsA = explode(',', $array['weapons']);
                    $weapons = '';

                    if (is_numeric($weaponsA[0])) {
                        $WList = actions::get($_GET['pid'], 'customjob', 'weapons_list');
                        $WList = json_decode($WList, true);

                        foreach ($weaponsA as $key => $wep) {
                            $weapons .= $WList[$wep] . ',';
                        }
                    } else {
                        $weapons = $array['weapons'];
                    }
                } else {
                    $weapons = 'None';
                }

                $weapons = rtrim($weapons, ',');

                if ($array['models'] != '') {
                    $modelsA = explode(',', $array['models']);
                    $models = '';

                    if (is_numeric($modelsA[0])) {
                        $MList = actions::get($_GET['pid'], 'customjob', 'models_list');
                        $MList = json_decode($MList, true);

                        foreach ($modelsA as $key => $model) {
                            $models .= $MList[$model] . ',';
                        }
                    } else {
                        $models = $array['models'];
                    }
                } else {
                    $models = 'None';
                }

                $models = rtrim($models, ',');

                $license = $array['license'] == 1 ? 'Yes' : 'No';
                $friends = $array['friends'] == '' ? 'None' : $array['friends'];

                $ret = '
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <div class="store-box-header">' . $title . '</div>
                            <div class="store-box">
                                <div class="store-box-upper">
                                    ' . $price_block . '
                                    <ul style="margin-bottom: 0;">
                                        <li style="border-top: 0px; border-bottom: 0px;"><b>' . $perm . '</b></li>
                                    </ul>
                                    <ul>
                                        ' . $label . '
                                    </ul>
                                </div>
                                <div class="store-box-lower">
                                    ' . $lower_text . '
                                    <br><br>
                                    <b>Order summary:</b><br>
                                    <b>Name:</b> ' . $array['name'] . '<br>
                                    <b>Chat command:</b> ' . $array['cmd'] . '<br>
                                    <b>Description:</b> ' . $array['desc'] . '<br>
                                    <b>Colour:</b> <span style="color: rgb(' . $array['colour'] . ')">' . $array['colour'] . '</span><br>
                                    <br>
                                    <b>Weapons:</b> ' . $weapons . '<br>
                                    <b>Models:</b> ' . $models . '<br>
                                    <b>Friends:</b> ' . $friends . '<br>
                                    <b>Salary:</b> ' . $array['salary'] . '<br>
                                    <b>License:</b> ' . $license . '<br>
                                </div>
                            </div>
                        </div>
                    ';
            }
        }

        return $ret;
    }

    public static function getEdit($type = null, $cate = 'none')
    {
        global $db;

        $ret = '';

        if ($type == 'categories') {
            $categories = $db->getAll("SELECT DISTINCT(p.category), c.name, c.order_id FROM packages p JOIN categories c ON p.category = c.id WHERE p.enabled = 1 ORDER BY c.order_id ASC");
            $cat_list = '<button type="submit" class="categoryLink" value="none">All</button>';

            foreach ($categories as $cat) {
                $count = $db->getOne("SELECT count(*) AS value FROM packages WHERE enabled = 1 AND category = ?", $cat['category']);

                $cat_list .= '
                        <button type="submit" class="categoryLink" value="' . $cat['category'] . '">' . $cat['name'] . ' <span>[' . $count . ']</span></button>
                    ';
            }

            $ret .= '<div class="row"><div class="col-xs-12">';
            $ret .= $cat_list;
            $ret .= '</div></div>';
        }

        if ($type == 'packages') {
            $ret .= '<div class="row">';

            $servers = $db->getAll("SELECT * FROM servers ORDER BY order_id ASC");
            foreach ($servers as $server) {
                $id = $server['id'];
                $name = $server['name'];

                $ret .= '
                        <div class="col-xs-4">
                            <h5>' . $name . '</h5>
                            <select class="selectpicker" data-live-search="true" data-style="btn-prom" onChange="location.href=\'admin.php?a=pkg&edit&id=\' + this.value;">
                                <option>' . lang('select_package') . '</option>
                                ' . options::getPackages($id, '', $cate) . '
                            </select>
                        </div>
                    ';
            }

            $ret .= '</div>';
        }

        return $ret;
    }

    public static function getMove()
    {
        global $db;

        $ret = '';
        $res = $db->getAll("SELECT * FROM packages WHERE enabled = 1 ORDER BY order_id ASC");

        if ($res) {
            foreach ($res as $row) {
                $id = $row['id'];
                $title = $row['title'];

                $ret .= '
                        <li><i class="fa fa-arrows-v" style="padding-right: 10px;"></i><span class="pid">' . $id . '</span> - ' . $title . '</li>
                    ';
            }
        }

        return $ret;
    }
}