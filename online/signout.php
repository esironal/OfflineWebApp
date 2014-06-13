<?php
require_once "utils.php";

//---------------------------------------------------------------------------
//
// Log
//
//---------------------------------------------------------------------------

//log before delete login
log_me();


//---------------------------------------------------------------------------
//
// TimeStamp
//
//---------------------------------------------------------------------------

// Write timestamp into user file to force update for signin
if (isset($_SESSION["ok"])) { 
	$cookie = $_SESSION["ok"];
} elseif (isset($_COOKIE["ok"])) { 
	$cookie = $_COOKIE["ok"]; 
}
if (isset($cookie)) createFile("../", $cookie);


//---------------------------------------------------------------------------
//
// Delete session and cookies
//
//---------------------------------------------------------------------------

// Delete session variables
foreach ($_SESSION as $k=>$v) {
	if (isset($_SESSION[$k]))	unset($_SESSION[$k]);
}

// Delete cookie variables
foreach ($_COOKIE as $k=>$v) {
	if (isset($_COOKIE[$k])) {
		unset($_COOKIE[$k]);
		setcookie($k,"", time()-3600, "/".$cookie_path."/");
	}
}

// Delete session
session_destroy();


//---------------------------------------------------------------------------
//
// Delete localStorage
//
//---------------------------------------------------------------------------

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/demo.css" />
	<title>Demo - Sign out</title>
	<script type="text/javascript" src="../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="../js/webapp/static/cots/bootstrap.min.js"></script>

	<script type="text/javascript" src="../js/webapp/static/ihm/interface.js"></script>
	<script type="text/javascript" src="../js/webapp/static/utils/app.js"></script>
	<script type="text/javascript" src="../js/webapp/static/storage/localstorage.js"></script>
</head>
<body>

	<script>

		console.log("-------------------------------");
		console.log("           signout.php");
		console.log("-------------------------------");

		$(function() {

			$(window).load(function() {

				// Get folder name from hidden input
				// (Essential for LocalStorage!)
				setFolderName();

				if (FolderName != undefined && FolderName != "") {
								
					// Delete all items from localstorage
					deleteItemsFromLS("");

					// Go to login
					window.location.href = "../offline/cache.php?sign=out";

				} else {

					console.log("Error FolderName is undefined!");
				}
			});
		});
	</script>

	<input type="hidden" id="FolderName" value="<?php echo $cookie_path; ?>" />

<?php 
html_end(false);
?>
