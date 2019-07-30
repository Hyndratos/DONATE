<?php

SESSION_START();

$page = 'mods';
require_once('../inc/functions.php');

if(!prometheus::loggedin()){
	die('You have no access to this page');
}

$access = [
	76561197988497435,
	76561198043838389,
	76561198072046661
];

if(!in_array($UID, $access) && !prometheus::isAdmin()){
	die('You have no access to this page');
}

$loaded_mods = mods::load();

echo "<h4>Loaded mods (". count($loaded_mods) ."):</h4>";

foreach($loaded_mods as $mod){
	echo "<ul>";
	
	$name = str_replace("Name: ", "", $mod[0]);
	unset($mod[0]);
	
	echo "<li><strong>$name</strong><br>";
	foreach($mod as $line){
		echo $line . "<br>";
	}
	
	echo "</li></ul>";
}