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

		$scenario = checkInput("post", "scenario", "/^.+$/");

		//Good input
		if ($scenario != false) {

			/*
			 * SQL Query
			 *
			 */

			$scenario = json_decode($scenario);
			$scenario_content = json_encode($scenario->{'content'});

			$sql = "INSERT INTO `webapp_scenarios` (
						`scenario_id`,
						`scenario_datetime`,
						`scenario_name`,
						`scenario_json`,
						`user_id`
					) VALUES (
						NULL,
						'".$scenario->{'datetime'}."',
						'".$scenario->{'name'}."',
						'".$scenario_content."',
						'".$_SESSION["user"]["id"]."'
					);";

			/*
			 * Exec query, transform the result in json and close the database
			 *
			 */

			//If there is an sql query
			if ($sql) {

				// New PDO
				$db = connectDataBase();

				// Send
				if ($db->exec($sql) == 1) {
					 echo "True";
				} else {
					 echo "False";
				}

				// Close database
				$db = null;
			}
		// Error
		} else { echo "False"; }

	// Need option
	} else { echo "False"; }

// Not connected
} else { echo "False"; }
?>
