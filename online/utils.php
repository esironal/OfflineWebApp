<?php

/******************************************************************************
 *
 * Includes
 *
 *****************************************************************************/

require_once "libs/utils_sql.php";
require_once "libs/utils_users.php";
require_once "libs/utils_ihm.php";
require_once "libs/utils_browsers.php";

/******************************************************************************
 *
 * MySQL
 *
 *****************************************************************************/


$config['host']		= "127.0.0.1";
$config['database']	= "demo";
$config['login']	= "root";
$config['password']	= "";


//If error stop webapp
if (!is_object(connectDataBase())) { echo "MySQL error!"; exit(); }

/******************************************************************************
 *
 * Configuration
 *
 *****************************************************************************/

//Starting time
$starting_time = microtime(true);

//Config cookies
$cookie_time_to_live = time() + (5 * 365 * 24 * 3600); //5 years
$cookie_password = "La vie est belle :)";

//Folder name
if (isset($_SERVER["SCRIPT_NAME"])) {
	$cookie_path = preg_replace("/^\/([^\/]+)\/.*$/", "$1", $_SERVER["SCRIPT_NAME"]);
} else { echo "Error! Cookie path invalid!"; exit(); }

//Dev mode (to detect automaticaly change in manifest)
$devmode = true;

/******************************************************************************
 *
 * Global variables
 *
 *****************************************************************************/

//Protect area
$area_default = "allow"; //Rule by default
$area_allow = array();
$area_deny = array();

/******************************************************************************
 *
 * Cookies, session and header
 *
 *****************************************************************************/

//Change path cookie
session_set_cookie_params(0, "/".$cookie_path."/");

//Create PHP session
session_start();

//Special header for manifest
header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 60*60*24*365*5));
header("Cache-Control: public");

?>
