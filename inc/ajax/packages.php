<?php

SESSION_START();

$page = 'ajax';
include('../functions.php');

if (!isset($_REQUEST['action'])) {
    die('Invalid load type');
}

if (isset($_REQUEST['action'])) {
    $a = $_REQUEST['action'];

    if ($a == 'get') {
        $category = $_REQUEST['category'];

        $ret = packages::getEdit('packages', $category);

        echo $ret;
    }

    if ($a == 'order') {
        $ids = $_REQUEST['ids'];

        $ids = explode(',', $ids);

        $count = 0;
        foreach ($ids as $id) {
            $db->execute("UPDATE packages SET order_id = ? WHERE id = ?", [
                $count, $id
            ]);

            $count++;
        }

        $ret = '
				<p class="bs-callout bs-callout-success alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Successfully ordered packages<br>
				</p>
			';

        echo $ret;
    }

    if ($a == 'updateJob') {
        $actions = $db->getOne("SELECT actions FROM actions WHERE timestamp = ? AND runonce = 0 LIMIT 1", $_REQUEST['timestamp']);

        $actions = json_decode($actions, true);
        $actions['customjob']['code'] = $_REQUEST['code'];

        $actions = json_encode($actions);

        $db->execute("UPDATE actions SET actions = ? WHERE timestamp = ? AND runonce = 0", [
            $actions, $_REQUEST['timestamp']
        ]);

        $db->execute("UPDATE prepurchase SET extra = ? WHERE id = ?", [
            $_REQUEST['code'], $_REQUEST['id']
        ]);

        $ret = '
				<p class="bs-callout bs-callout-success alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Successfully updated job code. It will take effect on next map change/restart<br>
				</p>
			';

        echo $ret;
    }
}