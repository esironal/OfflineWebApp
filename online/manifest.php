<?php
require "utils.php";

//Special header for manifest file
header('Content-type: text/cache-manifest'); 

//-------------------------------------------------------------------------------
// Configuration
//-------------------------------------------------------------------------------

//User file cache
$FileCacheExist=false;
if (isset($_SESSION["ok"])) { 
	$cookie = $_SESSION["ok"];
	$FileCacheExist=true;
} elseif (isset($_COOKIE["ok"])) { 
	$cookie = $_COOKIE["ok"];
	$FileCacheExist=true;
}


//MD5 var to files
$hashes = "";

//-------------------------------------------------------------------------------
// Functions to write file names and calculate MD5 files (to the $hashes var)
//-------------------------------------------------------------------------------

//Search files to cache from folder
// fallback : Fallback file
function verifUpdate_from_folder($folder, $fallback="") {

	global $devmode, $hashes;

	if ($fallback!="") $fallback = " ".$fallback;

	$dir = new RecursiveDirectoryIterator($folder);

	foreach (new RecursiveIteratorIterator($dir) as $file) {
		$info = pathinfo($file);
		if ($file -> IsFile() && substr($file -> getFileName(), 0, 1) != ".") {
			if ($file != "../online/manifest.php") {
				$file = str_replace("\\", "/", $file);
				echo str_replace(' ', '%20', $file) . $fallback."\n";
				if ($devmode) $hashes .= md5_file($file);
			}
		}
	}
}

//Search files to cache from file
// fallback : Fallback file
function verifUpdate_from_file($file, $fallback="", $auto=false) {

	global $devmode, $hashes;

	if (!$auto && $devmode) $auto=true;

	if ($fallback!="") $fallback = " ".$fallback;

	$file = str_replace("\\", "/", $file);
	echo str_replace(' ', '%20', $file) . $fallback."\n";
	if ($auto) $hashes .= md5_file($file);
}

//-------------------------------------------------------------------------------
// Offline
//-------------------------------------------------------------------------------
echo "CACHE MANIFEST\n";


echo "\nCACHE:\n";

	//-- Folders --
	verifUpdate_from_folder("../css");
	verifUpdate_from_folder("../fonts");
	verifUpdate_from_folder("../img");
	verifUpdate_from_folder("../js");
	verifUpdate_from_folder("../offline");

	//-- Files --
	verifUpdate_from_file("../index.php");

	//Manual files
	//Because manifest is stupid
	echo "../offline/cache.php?sign=in\n";
	echo "../offline/cache.php?sign=out\n";
	echo "../\n";

	//User file
	if ($FileCacheExist) verifUpdate_from_file("../cache/". $cookie, "", true);


//-------------------------------------------------------------------------------
// Online
//-------------------------------------------------------------------------------
echo "\nNETWORK:\n";

	verifUpdate_from_file("internet.php");

//-------------------------------------------------------------------------------
// Replacement Online to Offline
//-------------------------------------------------------------------------------
echo "\nFALLBACK:\n";

	//All files called by javascript
	verifUpdate_from_folder("ajax", 		"../offline/false.php");

	//Admin files
	verifUpdate_from_folder("admin", 		"../offline/fallback_child.php");

	//Options
	verifUpdate_from_folder("options", 		"../offline/fallback_child.php");

	//Signout
	verifUpdate_from_file("signout.php", 	"../offline/fallback.php");


//-------------------------------------------------------------------------------
// Hash to update automatically the manifest
//-------------------------------------------------------------------------------
echo "\n# Hash: ".md5($hashes)."\n";



?>
