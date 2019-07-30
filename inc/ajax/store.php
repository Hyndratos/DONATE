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
        $store = new store($_REQUEST['type']);

        if ($_REQUEST['type'] == 'package') {
            $store->setServer($_REQUEST['id']);

            $sortArray = [
                "sortby" => $_REQUEST['sortby'],
                "cat" => $_REQUEST['category'],
                "search" => $_REQUEST['search']
            ];
        } else {
            $sortArray = [
                "sortby" => $_REQUEST['sortby'],
                "search" => $_REQUEST['search']
            ];
        }

        $store->setSortOptions($sortArray);

        echo $store->display();
    }
}