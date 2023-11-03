<?php
date_default_timezone_set('Europe/London');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
define('DB_HOST_CU', 'localhost');
//define('DB_USER_CU', 'flyparkp_main');
define('DB_USER_CU', 'parkingzoneco_dba');
//define('DB_PASS_CU', '*pSHa.txDA+1');
define('DB_PASS_CU', 'r5g#V7ntqglF');
//define('DB_NAME_CU', 'flyparkp_main');
define('DB_NAME_CU', 'parkingzoneco_db');
define("DB_PREFIX", '');
define("csvpath","csv/");
include 'class.db.php';
$db = new DB();
$db->init(DB_HOST_CU, DB_USER_CU, DB_PASS_CU, DB_NAME_CU, DB_PREFIX);
include('mailer/class.phpmailer.php');
include 'functions.php';
include 'aph_functions.php';

$moduleSettings = getModuleSettings();
$siteSettings = getSiteSettings();
function set_cookie($cookie_value){
	$cookie_name = "traffic";
	setcookie($cookie_name, $cookie_value, time() + (3600), "/");
}
function create_cookie($cookie_value){
	if (isset($_COOKIE['traffic'])) {
		unset($_COOKIE['traffic']);
	}
	set_cookie($cookie_value);
}
?>