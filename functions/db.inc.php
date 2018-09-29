<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
/* Database config */
$db_host		= 'localhost';
$db_user		= 'timekeeper';
$db_pass		= 'timekeeping';
$db_database	= 'timekeeper'; 

$mysqli = mysqli_init();
if (!$mysqli) {
    die('mysqli_init failed');
}

if (!$mysqli->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
    die('Setting MYSQLI_INIT_COMMAND failed');
}

if (!$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
    die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
}

if (!$mysqli->real_connect($db_host,$db_user,$db_pass,$db_database)) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

//echo 'Succès... ' . $mysqli->host_info . "\n";



/* End config */
//$dbhandle = mysqli_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');
//$selected = mysqli_select_db($dbhandle, "timekeeper") or die("Could not select examples");

