<?php
require_once "../utils.php";

header("Content-type:text/plain");

//Log connection
if (log_me()) {
	echo "True";
} else {
	echo "False";
}
?>
