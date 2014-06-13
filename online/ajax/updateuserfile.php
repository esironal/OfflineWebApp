<?php
require_once "../utils.php";

$state = check_connected();

// User is connected
if ($state) {

	// User has bought the option
	if (checkOptions("reload")) {

		// Text header
		header("Content-type:text/plain");

		// Write timestamp into user file
		createFile("../../",$_COOKIE["ok"]);

	} else { NeedOption(); }

// Not connected
} else { ForbiddenAccess(); }
?>
