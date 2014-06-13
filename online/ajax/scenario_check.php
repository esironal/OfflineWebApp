<?php
require_once "../utils.php";

//Connected or not
$state = check_connected();

//If connected
if ($state) {

	//If user have buy option
	if (checkOptions("scenario")) {

		/*
		 * Check users inputs
		 * Good practices against hackers !
		 * Belt and shoulder strap :)
		 *
		 */

		$name = checkInput("get", "name", "/^[a-zA-Z0-9 ]+$/");

		//Good input
		if ($name != false) {

			/*
			 * SQL Query
			 *
			 */

			$sql = "SELECT 	`scenario_name`
					FROM webapp_scenarios
					WHERE (
						user_id=".$_SESSION["user"]["id"]." AND
						`scenario_name`='".$name."'
					);";

			/*
			 * Exec query, transform the result in json and close the database
			 *
			 */

			//If there is an sql query
			if ($sql) {

				//new PDO
				$db = connectDataBase();

				//Send sql query
				$query = $db->query($sql);

				header("Content-type:text/plain");

				//Result
				if ($query->rowCount() > 0) {

					echo "True";

				} else {
					echo "False";
				}

				//Close database
				$db = null;
			}

		//Error
		} else { echo "Bad inputs!!"; }

	//Need option
	} else { NeedOption(); }

//If not connected
} else { ForbiddenAccess(); }
?>
