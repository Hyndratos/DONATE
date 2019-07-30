<?php

class goal
{
    public static function get()
    {
        global $db;

        $maincur = getSetting('dashboard_main_cc', 'value2');
        $cur = $db->getOne("SELECT cc FROM currencies WHERE id = ?", $maincur);
        $goal = getSetting('monthly_goal', 'value2');

        $day = getSetting('enable_goal', 'value');
        if ($day == '' or !is_numeric($day))
            $day = 1;

        if(stripos($day, '0') !== false && $day != '0')
            $day = substr($day, 1);

        if($day == 0)
            $day = 1;

        if($day < 10)
            $day = '0'.$day;

        /**
         * Grab everything from the set date (this month somewhen) and one month back in time. right??
         */
        
        $month = date('m');
        $date = date('Y') .'-'. $month .'-'. $day;

        $timestamp = new DateTime($date);
        
        # The day is less than or equal to today
        if($day <= date('d')){
            # This means we oughta start from scratch, probs go one month into the future as well lol
            $timestamp->add(new DateInterval("P1M"));
        }

        $timestamp = $timestamp->format('Y-m-d H:i:s');
        $total = $db->getOne("SELECT SUM(price) FROM transactions WHERE txn_id != 'Assigned by Admin' AND currency IS NOT NULL AND timestamp >= '$timestamp' - INTERVAL 1 MONTH");

        if ($goal != 0 && $total != 0) {
            $perc = $total / $goal * 100;

            $perc = round($perc);

            if ($perc > 100)
                $perc = 100;
        } else {
            $perc = 0;
        }

        if ($total == null)
            $total = 0;

        return [
            "cur" => $cur,
            "goal" => $goal,
            "total" => round($total, 2),
            "perc" => $perc
        ];
    }
}