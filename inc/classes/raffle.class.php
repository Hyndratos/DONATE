<?php

class raffle
{
    public static function getEdit($id, $col)
    {
        global $db;

        if ($id != '') {
            $ret = $db->getOne("SELECT $col FROM raffles WHERE id = ?", $id);
        } else {
            $ret = false;
        }

        return $ret;
    }

    public static function listRaffles()
    {
        global $db;

        $res = $db->getAll("SELECT * FROM raffles");
        $ret = '';

        foreach ($res as $row) {
            $id = $row['id'];
            $title = $row['title'];

            $ret .= '
					<option value="' . $id . '">' . $title . '</option>
				';
        }

        return $ret;
    }

    public static function end($early = false, $raffle_id = null)
    {
        global $db;

        if (!$early) {
            $res = $db->getAll("SELECT * FROM raffles");

            foreach ($res as $row) {
                $id = $row['id'];
                $end_amount = $row['end_amount'];
                $cur_amount = $db->getOne("SELECT count(*) AS value FROM raffle_tickets WHERE raffle_id = ?", [$id])['value'];
                $ended = $row['ended'];

                $package = $row['package'];

                if (!$early) {
                    if ($end_amount <= $cur_amount && $ended != 1) {
                        $winner = $db->getOne("SELECT uid FROM raffle_tickets WHERE raffle_id = ? ORDER BY RAND() LIMIT 1", $id);

                        $p_array = array(
                            "id" => $package,
                            "trans_id" => 0,
                            "uid" => $winner,
                            "type" => 1,
                            "extra" => "raffle_winner"
                        );
                        addAction($p_array);

                        $db->execute("UPDATE raffles SET winner = ?, ended = 1 WHERE id = ?", array($winner, $id));
                        cache::clear();
                    }
                }
            }
        } else {
            $winner = $db->getOne("SELECT uid FROM raffle_tickets WHERE raffle_id = ? ORDER BY RAND() LIMIT 1", $raffle_id);

            if($winner == 0)
                return false;

            $package = $db->getOne("SELECT package FROM raffles WHERE id = ?", $raffle_id);

            $p_array = array(
                "id" => $package,
                "trans_id" => 0,
                "uid" => $winner,
                "type" => 1,
                "extra" => "raffle_winner"
            );
            addAction($p_array);

            $db->execute("UPDATE raffles SET winner = ?, ended = 1 WHERE id = ?", array($winner, $raffle_id));
            cache::clear();
        }
    }

    public static function cleanup($id)
    {
        global $db;

        $db->execute("DELETE FROM raffle_tickets WHERE raffle_id = ?", [$id]);
        $db->execute("UPDATE raffles SET winner = 0, ended = 0 WHERE id = ?", [$id]);
        cache::clear();
    }
}