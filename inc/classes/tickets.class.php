<?php

class tickets
{
    public static function read($p)
    {
        global $db, $UID;

        $i = 0;
        if ($p == 1) {
            $res = $db->getAll("SELECT seen FROM tickets");
            if ($res != NULL) {
                foreach ($res as $row) {
                    $read = $row['seen'];
                    if ($read == 0) {
                        $i++;
                    }
                }
            }
        } else {
            $res = $db->getAll("SELECT client_seen FROM tickets WHERE uid = ?", $UID);
            if ($res != NULL) {
                foreach ($res as $row) {
                    $read = $row['client_seen'];
                    if ($read == 0) {
                        $i++;
                    }
                }
            }
        }

        return $i;
    }

    public static function setRead($id, $p)
    {
        global $db;
        global $UID;

        if ($p == 1) {
            $db->execute("UPDATE tickets SET seen = 1 WHERE id = ?", $id);
        } else {
            $db->execute("UPDATE tickets SET client_seen = 1 WHERE id = ?", $id);
        }
    }

    public static function getTicket($p)
    {
        global $db;

        $res = $db->getAll("SELECT * FROM tickets WHERE id = ?", $p);
        $ret = '';

        foreach ($res as $row) {
            $id = $row['id'];
            $uid = $row['uid'];
            $descr = $row['descr'];
            $text = $row['text'];
            $timestamp = $row['timestamp'];

            if (getUserSetting('admin', $uid))
                $admin = '<font color="green" size="2px">' . lang('admin') . '</font>';
            else
                $admin = '';

            $ret = '
					<div class="header">
						' . htmlspecialchars(display($descr)) . '
					</div>
					<br>
					<div class="ticket-header">
						<img src="' . getUserSetting('steam_avatar', $uid) . '" width="50px" height="50px"></img>
							' . htmlspecialchars(getUserSetting('name', $uid)) . ' ' . $admin . '
						<div class="ticket-header-right">
							' . $timestamp . '
						</div>
					</div>
					' . $text . '
					<br><br>
				';
        }

        return $ret;
    }

    public static function getReplies($p, $a)
    {
        global $db;

        $res = $db->getAll("SELECT * FROM ticket_replies WHERE ticket_id = ?", $p);
        $ret = '';

        if ($res) {
            foreach ($res as $row) {
                $uid = $row['uid'];
                $text = $row['text'];
                $timestamp = $row['timestamp'];

                if (getUserSetting('admin', $uid)) {
                    $admin = '<font color="green" size="2px">Admin</font>';
                } else {
                    $admin = '';
                }

                $ret .= '
						<div class="ticket-header">
							<img src="' . getUserSetting('steam_avatar', $uid) . "\" width=\"50px\" height=\"50px\"/>
								" . htmlspecialchars(getUserSetting("name", $uid)) . ' ' . $admin . '
							<div class="ticket-header-right">
								' . $timestamp . '
							</div>
						</div>
						' . $text . '
						<br><br>
					';
            }
        }

        if ($a == 1) {
            if (tickets::getClosed($p)) {
                $ret .= '
						<form method="POST">
							<textarea id="reply" name="reply"></textarea>
							<script>
                                $("#reply").trumbowyg({
                                    removeformatPasted: true,
                                    autogrow: true,
                                    fullscreenable: false
                                });
							</script>
							<input type="submit" name="reply_submit" value="' . lang('reply') . '" class="btn btn-prom" style="margin-top: 5px;"> <div style="display: inline-block; float: right"><input type="submit" name="ticket_close" value="Close ticket" class="btn btn-danger" style="margin-top: 5px;"></div>
						</form>
					';
            } else {
                $ret .= '
						<form method="POST">
							<div style="display: inline-block; float: right"><input type="submit" name="ticket_open" value="Re-open ticket" class="btn btn-success" style="margin-top: 5px;"></div>
						</form>
					';
            }
        } else {
            if (tickets::getClosed($p)) {
                $ret .= '
						<form method="POST">
							<textarea id="reply" name="reply"></textarea>
							<script>
								$("#reply").trumbowyg({
                                    removeformatPasted: true,
                                    autogrow: true,
                                    fullscreenable: false
                                });
							</script>
							<input type="submit" name="reply_submit" value="' . lang('reply') . '" class="btn btn-prom" style="margin-top: 5px;"> <div style="display: inline-block; float: right"><input type="submit" name="ticket_close" value="Close ticket" class="btn btn-danger" style="margin-top: 5px;"></div>
						</form>
					';
            } else {
                $ret .= '
						<hr>
						' . lang('ticket_closed') . '
					';
            }
        }

        return $ret;
    }

    public static function addReply($p, $text, $a)
    {
        global $db;
        global $UID;

        $html = new parser($text);
        $text = $html->parseHtml();

        $db->execute("INSERT INTO ticket_replies SET ticket_id = ?, uid = ?, text = ?", [
            $p, $UID, $text
        ]);

        if ($a == 0) {
            $db->execute("UPDATE tickets SET seen = 0 WHERE id = ?", $p);
        } else {
            $db->execute("UPDATE tickets SET client_seen = 0 WHERE id = ?", $p);
        }
    }

    public static function close($id)
    {
        global $db;

        $db->execute("UPDATE tickets SET active = 0 WHERE id = ?", $id);
    }

    public static function open($id)
    {
        global $db;

        $db->execute("UPDATE tickets SET active = 1 WHERE id = ?", $id);
    }

    public static function getClosed($id)
    {
        global $db;

        $res = $db->getOne("SELECT active FROM tickets WHERE id = ?", $id);
        if ($res == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function create($descr, $text)
    {
        global $db;
        global $UID;

        $html = new parser($text);
        $text = $html->parseHtml();

        $db->execute("INSERT INTO tickets SET descr = ?, text = ?, uid = ?", [
            $descr, $text, $UID
        ]);
    }

}
