<?php

SESSION_START();

$page = 'ajax';
include('../functions.php');

if (!isset($_REQUEST['action'])) {
    die('Invalid load type');
}

if (isset($_REQUEST['action'])) {
    $a = $_REQUEST['action'];

    if ($a == 'setState') {
        $_SESSION['prometheus_sidebar'] = $_REQUEST['state'];
    }
}