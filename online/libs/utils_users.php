<?php

/******************************************************************************
 *
 * INPUT
 *
 *****************************************************************************/

//To verify the validity of user input
//$type = "post" or "get"
//Return false if not valid
function checkInput($type, $variable, $pattern) {

	$input = false;

	//Check by type
	switch ($type) {

		//POST VARIABLE
		case "post" :
			if (isset($_POST[$variable]))
				$input = $_POST[$variable];
			break;

		//GET VARIABLE
		case "get" :
			if (isset($_GET[$variable]))
				$input = $_GET[$variable];
			break;
	}

	//Check by regex
	if ($input && preg_match($pattern, $input))	
	return $input; else return false;
}

/******************************************************************************
 *
 * MANAGE MANIFEST
 *
 *****************************************************************************/

// Write timestamp into file
function createFile($path, $name) {
	$file = fopen($path."cache/".$name, "w");
	fwrite ($file, time());
	fclose($file);
}


/******************************************************************************
 *
 * USER INFO
 *
 *****************************************************************************/

//Get information from login with database
//Return an array
function getInfosFromLogin($login) {

	//Check user
	$db = connectDataBase();
	$sql = "SELECT `user_id`, `user_login`, `group_name` FROM `webapp_users`
			WHERE `user_login` = '$login' LIMIT 1;";
	$query = $db->query($sql);

	//Ok if one result
	if ($query->rowCount() == 1) {

		//Login
		$results["login"] = $login;

		//Group
		$group = $query->fetchAll(PDO::FETCH_ASSOC);
		$results["group"] = $group[0]["group_name"];

		//Id
		$results["id"] = $group[0]["user_id"];

		//If the group is not administrator
		if ($results["group"] != "root") {

			//Get Grants
			$sql = "SELECT `option_name` FROM `webapp_grants`
					WHERE `group_name` = '".$group[0]["group_name"]."';";
			$query = $db->query($sql);
	
			//If grants
			if ($query->rowCount() > 0) {

				//Save grants in SESSION
				$grants = $query->fetchAll(PDO::FETCH_ASSOC);	
				foreach ($grants as $grant) {
					$results["grants"][] = $grant["option_name"];
				}
			}
		}

		//Return results array
		return $results;
	}

	//Error
	return false;
}

/******************************************************************************
 *
 * AUTHENTICATION
 *
 *****************************************************************************/

//Check PHP Session
function check_connected() {

	global $cookie_password;
	global $area_default, $area_allow, $area_deny;

	//If the user doesn't have a cookie and doesn't try to connect
	if (!isset($_COOKIE["ok"]) && !isset($_SESSION["ok"])) {

		//echo "no cookie, no session<hr>";
		return false;

	//Else the user has a cookie or he is connecting
	} else {

		//Default
		$go = false;

		//If the user has a cookie => get login from it
		if (isset($_COOKIE["ok"])) {
			$login = getLoginFromCookie();
			if ($login != false) {

				$_SESSION["user"] = getInfosFromLogin($login);
				$_SESSION["ok"] = $_COOKIE["ok"];
				$_SESSION["id_country"] = $_COOKIE["id_country"];
				$go = true;
			}

		//The user is connecting
		} elseif (isset($_SESSION["ok"])) {
			$go = true;
		}

		//Bad authentication
		if (!$go) {
			//echo "bad cookie<hr>";
			return false;
		}

		//Check grant 
		if ($_SESSION["user"]["group"] != "root") {

			//if the running page has rules
			if (!empty($area_allow) || !empty($area_deny)) {

				//Default : everybody is allowed
				if ($area_default == "allow") {

					$go = true;

					//Foreach group to deny
					foreach ($area_deny as $group) {
						if ($group == $_SESSION["user"]["group"]) {
							$go = false;
							break;
						}
					}

				//Else : everybody is denied
				} elseif ($area_default == "deny") {

					$go = false;

					//Foreach group to allow
					foreach ($area_allow as $group) {
						if ($group == $_SESSION["user"]["group"]) {
							$go = true;
							break;
						}
					}
				}
			}

			//Access forbiden
			if (!$go) {
				//echo "no option<hr>";
				return false;
			}
		}
	}

	//Ok
	return true;
}

//Return the login from cookie
function getLoginFromCookie() {

	global $cookie_password;

	$db = connectDataBase();
	$sql = "SELECT `user_login` FROM `webapp_users`";
	$query = $db->query($sql);
	if ($query->rowCount() > 0) {
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $line) {
			$password = $cookie_password." ".$line["user_login"];
			if ($_COOKIE["ok"] == hash("sha512", $password)) {
				return $line["user_login"];
				break;
			}
		}
	}
	$db = null;
	return false;
}

//Politic to protect the running page
//allow: Everybody can see the page
//deny:  Nobody can see the page
function politic ($politic) {
	global $area_default;
	$area_default = $politic;
}

//Allow the group_name to access the page
function allow ($group_name) {
	global $area_allow;
	$area_allow[] = $group_name;
}

//Deny the group_name to access the page
function deny ($group_name) {
	global $area_deny;
	$area_deny[] = $group_name;
}

//Check option in grant list user
function checkOptions($option) {
	if (isset($_SESSION["user"]["group"]) && $_SESSION["user"]["group"] != "root") {
		if (isset($_SESSION["user"]["grants"])) {
			foreach ($_SESSION["user"]["grants"] as $grant) {
				if ($grant == $option) {
					return true;
					break;
				}
			}
		}
		return false;
	} else return true;
}

//Check if root group
function checkRoot() {
	if (isset($_SESSION["user"]["group"]) && $_SESSION["user"]["group"] == "root")
	return true; else return false;
}


?>
