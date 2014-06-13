<?php
require_once "../utils.php";

$state = check_connected();

header("Content-type:text/plain");

// User is connected
if ($state) {

	// User has bought the option
	if (checkOptions("scenario")) {

		/*
		 * Check users inputs
		 * Good practices against hackers !
		 * Belt and shoulder strap :)
		 *
		 */

		$id = checkInput("post", "id", "/^[0-9]+$/");

		//Good input
		if ($id != false) {

			/*
			 * SQL Query
			 *
			 */

			$sql = "DELETE FROM `webapp_scenarios`
					WHERE `scenario_id` = ".$id."
					AND `user_id` = ".$_SESSION["user"]["id"].";";

			/*
			 * Exec query, transform the result in json and close the database
			 *
			 */

			// If there is an sql query
			if ($sql) {

				// New PDO
				$db = connectDataBase();

				// Send
				if ($db->exec($sql) == 1) {
					 echo "True";
				} else {
					 echo "False";
				}

				//Close database
				$db = null;
			}

		// Error
		} else { echo "False"; }

	// Need option
	} else { echo "False"; }

// Not connected
} else { echo "False"; }
?>
