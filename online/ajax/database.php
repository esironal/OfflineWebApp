<?php
require_once "../utils.php";

//Connected or not
$state = check_connected();

//If connected
if ($state) {

	/*
	 * Check users inputs
	 * Good practices against hackers !
	 * Belt and shoulder strap :)
	 *
	 */

		$mois = checkInput ("get", "mois", "/^[0-9]{1,2}+$/");

	/*
	 * SQL Query
	 *
	 */

		//Init
		$sql = false;

		//Check by type
		if ($mois != false) {

			$sql = "SELECT `ca`, `benef`
				FROM demo_exemple
				WHERE `mois`=".$mois.";";
				
		} else {
				echo "Bad inputs !!";
				exit();
		}

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

			//Result
			if ($query->rowCount() > 0) {

				//All results
				$result = $query->fetchAll(PDO::FETCH_ASSOC);

				//Nb cols in the results
				$cols = count($result[0]);

				//Types of the columns (string, float, etc...)
				$col_types = array();

				//Create an array "Name of column ==> Type of data"
				while($cols-- > 0) { 
					$col_info = $query->getColumnMeta($cols);
					$col_types[ $col_info['name'] ] = $col_info['native_type']; 
				}

				//Clean the new array
				unset($col_types[""]); //empty type

				//Change the type of cells
				$cpt = 0;
				foreach ($result as $cellule) {
					foreach ($cellule as $k => $v) {
						if ($col_types[$k] == "DOUBLE") $result[$cpt][$k] = (float)$v;
						if ($col_types[$k] == "LONG")  $result[$cpt][$k] = (int)$v;
					}
					$cpt++;
				}

				//Special header for json file
				header("Content-Type: application/json");

				//JSON
				echo json_encode($result);

			} else {
				 echo "No result.";
			}

			//Close database
			$db = null;

		//Error
		} else {

			echo "Unable to find an SQL query for this input !";
		}

//If not connected
} else { ForbiddenAccess(); }
?>
