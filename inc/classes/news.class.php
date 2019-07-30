<?php

class news
{
    public static function del($p)
    {
        global $db;

        $db->execute("DELETE FROM news WHERE id = ?", [$p]);
        cache::clear();
    }

    public static function add($p)
    {
        global $db;
        global $UID;

        $date = date('d M Y');

        $html = new parser($p);
        $p = $html->parseHtml();

        $db->execute("INSERT INTO news SET content = ?, date = ?, uid = ?", array($p, $date, $UID));
        cache::clear('news');
    }

    public static function update($p)
    {
        global $db;

        $content = $p['text'];
        $html = new parser($content);
        $content = $html->parseHtml();

        $db->execute("UPDATE news SET content = ? WHERE id = ?", array($content, $p['id']));
        cache::clear('news');
    }

    public static function get()
    {
        global $db;
        global $cache;

        $ret = $cache->get('news_sidebar_' . getUrl('full'));

        if ($ret == null) {

            $res = $db->getAll("SELECT * FROM news ORDER BY id DESC LIMIT 5");
            if ($res != NULL) {
                foreach ($res as $row) {
                    $date = $row['date'];
                    $id = $row['id'];
                    $uid = $row['uid'];

                    if ($uid != NULL && userExists($uid))
                        $pname = $db->getOne("SELECT name FROM players WHERE uid = ?", [$uid])['name'];
                    else
                        $pname = 'Admin';

                    $content = $db->getOne("SELECT LEFT(content, 200) AS content FROM news WHERE id = ?", [$id])['content'];
                    $content = $content . '... <a href="news.php?id=' . $id . '">Read more</a>';

                    if ($date == date('d M Y')) {
                        $ret .= '
								<div class="news-block">
									<b>Today</b><br>
									' . display($content) . '<br>
									<span>' . lang('by') . ' ' . $pname . '</span>
								</div><br>
							';
                    } else {
                        $ret .= '
								<div class="news-block">
									<b>' . $date . '</b><br>
									' . display($content) . '<br>
									<span>' . lang('by') . ' ' . $pname . '</span>
								</div><br>
							';
                    }
                }
            } else {
                $ret = '
						<div class="content">
							<div class="news-block">
								<b>' . lang('no_news') . '</b><br>
								' . lang('no_news_text') . '
							</div>
						</div>
					';
            }

            $cache->set('news_sidebar_' . getUrl('full'), $ret, 600 * 6 * 24);
        }

        return $ret;
    }

    public static function getPost($p)
    {
        global $db;

        $res = $db->getAll("SELECT * FROM news WHERE id = ?", [$p]);
        foreach ($res as $row) {
            $id = $row['id'];
            $content = $row['content'];

            $ret = '
					<form method="POST">
						<input type="hidden" value="' . $id . '" name="news_edit_hidden">
						<textarea id="news_edit_textarea" name="news_edit_textarea">' . $content . '</textarea>
						<br>
						<input type="submit" name="news_edit_submit" value="' . lang('submit') . '" class="btn btn-prom">
					</form>
				';
        }

        return $ret;
    }

    public static function getTable()
    {
        global $db;

        $res = $db->getAll("SELECT * FROM news ORDER BY id DESC LIMIT 10");
        $ret = '';

        if ($res != NULL) {
            foreach ($res as $row) {
                $id = $row['id'];
                $date = $row['date'];
                $content = $db->getOne("SELECT LEFT(content, 100) AS content FROM news WHERE id = ?", [$id])['content'];
                if (strlen($content) == 100) {
                    $content = $content . ' ...';
                }

                $ret .= '
						<form method="POST">
							<input type="hidden" value="' . $id . '" name="news_hidden">
							<tr>
								<td>' . $id . '</td>
								<td width="55%">' . $content . '</td>
								<td>' . $date . '</td>
								<td>
									<input type="submit" class="btn btn-warning" name="news_edit" value="Edit">
								</td>
								<td>
									<input type="submit" value="Del" class="btn btn-prom" name="news_delete">
								</td>
							</tr>
						</form>
					';
            }
        } else {
            $ret = '<tr><td>' . lang('no_news_articles') . '.</td><td></td><td></td><td></td><td></td></tr>';
        }

        return $ret;
    }

    public static function getPostVal($id, $val)
    {
        global $db;

        return $db->getOne("SELECT $val FROM news WHERE id = ?", [$id])[$val];
    }
}
