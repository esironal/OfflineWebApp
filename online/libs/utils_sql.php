<?php

/******************************************************************************
 *
 * MYSQL
 *
 *****************************************************************************/

//Connection to database
function connectDataBase() {
	try {
		global $config;
		$db = new PDO("mysql:dbname=".$config['database'].";host=".$config['host'].";charset=UTF8", $config['login'], $config['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	} catch (PDOException $e) {
		return $e->getMessage();
	}
}

/******************************************************************************
 *
 * LOG
 *
 *****************************************************************************/



//Log the running connection in database 
function log_me () {

	global $starting_time;

	//-------------------------------------------------------------------------
	// DATA
	//-------------------------------------------------------------------------
	$date = new DateTime();
	$date->setTimestamp(time());
	$log["log_datetime"] = $date->format('Y-m-d H:i:s');
	$log["log_runtime"] = microtime(true) - $starting_time;
	if (isset($_SERVER["REQUEST_METHOD"])) 			$log["log_method"] = addslashes(trim(cutString(4, $_SERVER["REQUEST_METHOD"]))); 				else $log["log_method"] = "NULL";
	if (isset($_SERVER["REMOTE_ADDR"])) 			$log["log_ip"] = $_SERVER['REMOTE_ADDR']; 														else $log["log_ip"] = "NULL";
	if (isset($_SERVER["REMOTE_PORT"])) 			$log["log_port"] = $_SERVER["REMOTE_PORT"]; 													else $log["log_port"] = "NULL";

	if (isset($_SESSION['user']['id']) && $_SESSION['user']['id']!="") $log["user_id"] = $_SESSION['user']['id']; else $log["user_id"] = "NULL";

	if (isset($_SERVER["HTTP_COOKIE"]))				$fk["cookie_content"] = addslashes(trim(cutString(65535, $_SERVER["HTTP_COOKIE"]))); 			else $log["cookie_id"] = "NULL";
	if (isset($_SERVER["HTTP_USER_AGENT"])) 		$fk["useragent_content"] = addslashes(trim(cutString(65535, $_SERVER["HTTP_USER_AGENT"]))); 	else $log["useragent_id"] = "NULL";
	if (isset($_SERVER["REQUEST_URI"])) 			$fk["uri_content"] = addslashes(trim(cutString(255, $_SERVER["REQUEST_URI"]))); 				else $log["uri_id"] = "NULL";
	if (isset($_SERVER["HTTP_REFERER"])) 			$fk["referer_content"] = addslashes(trim(cutString(255, $_SERVER["HTTP_REFERER"]))); 			else $log["referer_id"] = "NULL";
	if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) 	$fk["language_content"] = addslashes(trim(cutString(255, $_SERVER["HTTP_ACCEPT_LANGUAGE"]))); 	else $log["language_id"] = "NULL";

	//-------------------------------------------------------------------------
	// Search id for foreigns keys and insert them if not exist
	//-------------------------------------------------------------------------
	$db = connectDataBase();

	if (is_object($db) && isset($fk)) {

		//cookie
		if (isset($fk["cookie_content"])) {
			$log["cookie_id"] = searchLogsFK($db, "webapp_logs_cookies", "cookie_id", "cookie_content", $fk["cookie_content"]);
			if ($log["cookie_id"] == false) {
				insertLogsFK($db, "webapp_logs_cookies", "cookie_content", $fk["cookie_content"]);
				$log["cookie_id"] = searchLogsFK($db, "webapp_logs_cookies", "cookie_id", "cookie_content", $fk["cookie_content"]);
			}
		}

		//useragent
		if (isset($fk["useragent_content"])) {
			$log["useragent_id"] = searchLogsFK($db, "webapp_logs_useragents", "useragent_id", "useragent_content", $fk["useragent_content"]);
			if ($log["useragent_id"] == false) {
				insertLogsFK($db, "webapp_logs_useragents", "useragent_content", $fk["useragent_content"]);
				$log["useragent_id"] = searchLogsFK($db, "webapp_logs_useragents", "useragent_id", "useragent_content", $fk["useragent_content"]);
			}
		}

		//uri
		if (isset($fk["uri_content"])) {
			$log["uri_id"] = searchLogsFK($db, "webapp_logs_uris", "uri_id", "uri_content", $fk["uri_content"]);
			if ($log["uri_id"] == false) {
				insertLogsFK($db, "webapp_logs_uris", "uri_content", $fk["uri_content"]);
				$log["uri_id"] = searchLogsFK($db, "webapp_logs_uris", "uri_id", "uri_content", $fk["uri_content"]);
			}
		}

		//referer
		if (isset($fk["referer_content"])) {
			$log["referer_id"] = searchLogsFK($db, "webapp_logs_referers", "referer_id", "referer_content", $fk["referer_content"]);
			if ($log["referer_id"] == false) {
				insertLogsFK($db, "webapp_logs_referers", "referer_content", $fk["referer_content"]);
				$log["referer_id"] = searchLogsFK($db, "webapp_logs_referers", "referer_id", "referer_content", $fk["referer_content"]);
			}
		}

		//language
		if (isset($fk["language_content"])) {
			$log["language_id"] = searchLogsFK($db, "webapp_logs_languages", "language_id", "language_content", $fk["language_content"]);
			if ($log["language_id"] == false) {
				insertLogsFK($db, "webapp_logs_languages", "language_content", $fk["language_content"]);
				$log["language_id"] = searchLogsFK($db, "webapp_logs_languages", "language_id", "language_content", $fk["language_content"]);
			}
		}
		//-------------------------------------------------------------------------
		// Prepare value to be inserted
		//-------------------------------------------------------------------------
		foreach ($log as $k=>$v)
			if ($v != "NULL")
				$log[$k] = "'".$v."'";

		//-------------------------------------------------------------------------
		// Save log
		//-------------------------------------------------------------------------

		$sql = "INSERT INTO `webapp_logs` (
						`log_datetime`,	`log_runtime`, `log_method`,`log_ip`,
						`log_port`, `user_id`, `cookie_id`, `useragent_id`,
						`uri_id`, `referer_id`, `language_id`
				) VALUES (
						".$log["log_datetime"].", ".$log["log_runtime"].", ".$log["log_method"].", INET_ATON(".$log["log_ip"]."),
						".$log["log_port"].", ".$log["user_id"].", ".$log["cookie_id"].", ".$log["useragent_id"].",
						".$log["uri_id"].", ".$log["referer_id"].", ".$log["language_id"]."
				);";

		/*echo "<pre>";
		print_r($sql);
		echo "</pre>";*/

		if ($db->query($sql)) return true;
		else return false;
	}
}

//Insert for Foreign keys
function insertLogsFK($db, $table, $column_name, $column_content) {

	if (is_string($table) && is_string($column_name) && is_string($column_content)) {
		$sql  = "INSERT INTO `".$table."` (`".$column_name."`) VALUES ('".$column_content."');";

		/*echo "<pre>";
		print_r($sql);
		echo "</pre>";*/

		$query = $db->query($sql);
	}
}

//Search for Foreign keys
function searchLogsFK($db, $table, $column_id, $column_content, $search) {

	$sql  = "SELECT `".$column_id."` FROM `".$table."` ";
	$sql .= "WHERE `".$column_content."` = '".$search."';";

	/*echo "<pre>";
	print_r($sql);
	echo "</pre>";*/

	$query = $db->query($sql);
	$nb = $query->rowCount();

	if ($nb > 0) {
		$logs = $query->fetchAll(PDO::FETCH_ASSOC);
		return $logs[0][$column_id];
	} else {
		return false;
	}
}

//Return a string with a length max
function cutString($max, $string) {
	if (strlen($string) > $max)
		$string = substr($string,0,$max-1);
	return $string;
}


?>
