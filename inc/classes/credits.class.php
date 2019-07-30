<?php

class credits
{
    public static function hasEnough($uid, $pkg, $type, $coupon = false)
    {
        global $db;

        $verify = new verification('credits', $uid, $pkg, $coupon);
        $cost = $verify->getPrice($type, 'credits');

        $amt = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);
        if ($amt >= $cost) {
            return true;
        } else {
            return false;
        }
    }

    public static function withdraw($uid, $pkg, $type, $coupon = false)
    {
        global $db;

        $verify = new verification('credits', $uid, $pkg, $coupon);
        $cost = $verify->getPrice($type, 'credits');

        $amt = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);
        $new = $amt - $cost;
        $db->execute("UPDATE players SET credits = ? WHERE uid = ?", [
            $new, $uid
        ]);
    }

    public static function add($p)
    {
        global $db;

        $db->execute("INSERT INTO credit_packages SET title = ?, descr = ?, amount = ?, price = ?", [
            $p['title'], $p['descr'], $p['amt'], $p['price']
        ]);
    }

    public static function get($uid)
    {
        global $db;

        $ret = cache::get('credits', $uid);

        if ($ret == null) {
            $ret = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);

            cache::set('credits', $ret, '1y', $uid);
        }

        return $ret;
    }

    public static function transfer($uid, $amt)
    {
        global $db;

        $self_amt = $db->getOne("SELECT credits FROM players WHERE uid = ?", $_SESSION['uid']);
        $self_amt_after = $self_amt - $amt;
        $db->execute("UPDATE players SET credits = ? WHERE uid = ?", [
            $self_amt_after, $_SESSION['uid']
        ]);

        $other_amt = $db->getOne("SELECT credits FROM players WHERE uid = ?", $uid);
        $other_amt_after = $other_amt + $amt;
        $db->execute("UPDATE players SET credits = ? WHERE uid = ?", [
            $other_amt_after, $uid
        ]);

        cache::del('credits', $_SESSION['uid']);
        cache::del('credits', $uid);
    }

    public static function set($uid, $amt)
    {
        global $db;

        $db->execute("UPDATE players SET credits = ? WHERE uid = ?", [
            $amt, $uid
        ]);

        cache::del('credits', $uid);
    }

    public static function getValue($id, $val)
    {
        global $db;

        if ($id != '') {
            return $db->getOne("SELECT $val FROM credit_packages WHERE id = ?", $id);
        } else {
            return false;
        }
    }

    public static function del($id)
    {
        global $db;

        $db->execute("DELETE FROM credit_packages WHERE id = ?", [$id]);
    }

    public static function update($p)
    {
        global $db;

        $db->execute("UPDATE credit_packages SET title = ?, descr = ?, amount = ?, price = ? WHERE id = ?", [
            $p['title'], $p['descr'], $p['amt'], $p['price'], $p['id']
        ]);
    }
}
