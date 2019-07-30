<?php

//setSetting($_POST['backup'], 'backup', 'value');

ob_start();

$error = false;

$ret =
    '	/*
		Theme: ' . $_POST['theme_name'] . '
		Prometheus Version: ' . $version . '
		*/
	';

foreach ($_POST['theme_rgb'] as $key => $val) {
    if (!empty($val)) {
        $cssval = 'rgb(' . $val . ') ' . $_POST['theme_extra'][$key];

        if(isset($_POST['theme_wrap'][$key]) && !empty($_POST['theme_wrap'][$key])){
            $cssval = $_POST['theme_wrap'][$key] . '(' . $val . ') ' . $_POST['theme_extra'][$key];
        }

        $ret .= $_POST['theme_class'][$key] . '{';
        $ret .= $_POST['theme_classtype'][$key] . ': '.$cssval.' !important;';

        if(isset($_POST['theme_extra_attr'][$key])){
            foreach($_POST['theme_extra_attr'][$key] as $attr){
                $ret .= $attr;
            }
        }

        $ret .= '}';
    }
}

$file = 'themes/' . $_POST['theme_name'] . '/style.css';
if (file_exists($file)) {
    $error = true;

    $message->add('danger', 'A theme with this name already exists, choose a different name!');
}

if (!isset($_GET['id'])) {
    if ($_POST['theme_name'] == '') {
        $error = true;

        $message->add('danger', 'You need to enter a valid theme name!');
    }
}

if (!$error) {

    if (!isset($_GET['id'])) {
        chmod('themes', 0777);

        @mkdir('themes/' . $_POST['theme_name'], 0777);
        $cssFile = fopen('themes/' . $_POST['theme_name'] . '/style.css', 'w');
        fwrite($cssFile, $ret);
        fclose($cssFile);

        // 777 write/read/execute permission
        chmod('themes/' . $_POST['theme_name'] . '/style.css', 0777);

        setSetting($_POST['theme_name'], 'theme', 'value');
    } else {
        $cssFile = fopen('themes/' . $_GET['id'] . '/style.css', 'w');
        fwrite($cssFile, $ret);
        fclose($cssFile);

        setSetting($_GET['id'], 'theme', 'value');
    }

    $message->add('success', 'Successfully added/edited theme. You can switch themes in the general settings -> settings area. This theme will be applied upon refresh');
}

ob_end_flush();