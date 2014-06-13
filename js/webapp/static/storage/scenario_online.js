/*******************************************************************************
 * 
 * 	All functions to manage online scenarios
 * 
 *******************************************************************************/

/**
 * Delete one scenario on the server
 *  
 * @param path "../"
 * @param datatosend Id of the scenario
 * @returns {Boolean} True if the scenario has been deleted
 */
function scenarioOnlineDeleteOne(path, datatosend) {
	var result = false;
    $.post(path+"online/ajax/scenario_delete.php", {
			id: datatosend
		}).done(function(data) {
			result = data;
			console.log("Demo - AJAX - scenarioOnlineDeleteOne - "+data);
		});
	return result;
}

/**
 * Send one scenario to the server
 * 
 * @param path
 * @param datatosend Scenario to send
 * @returns {Boolean} True if sent
 */
function scenarioOnlineSendOne(path, datatosend) {
	var result = false;
    $.post(path+"online/ajax/scenario_set.php", {
			scenario: datatosend
		}).done(function(data) {
			result = data;
			console.log("Demo - AJAX - scenarioOnlineSendOne - "+data);
		});
	return result;
}

/**
 * Return one scenario (parsed) from the server
 * 
 * @param path
 * @param id The id of the scenario
 * @returns 
 */
function scenarioOnlineGetOne(path, id) {

	var result = false;
    $.getJSON(path+'online/ajax/scenario_get.php?q=one&id='+id, function (arrayResults) {
		var scenario = new ScenarioObject(arrayResults[0].scenario_id, arrayResults[0].scenario_name, arrayResults[0].scenario_datetime);
		scenario.content = JSON.parse(arrayResults[0].scenario_json);
		result = scenario;
		console.log("Demo - AJAX - scenarioOnlineGetOne("+path+","+id+")");
    });
	return result;
}

/**
 * Return all scenarios (parsed) from the server
 * 
 * @param path
 * @param {Number} progress Time to refresh progress bar
 * @returns An array of online scenarios
 */
function scenarioOnlineGetAll(path, progress) {

	console.log("Demo - scenarios - Get all online scenarios...");
	var result = [];

    $.getJSON(path+'online/ajax/scenario_get.php?q=all', function (arrayResults) {

		if (progress) {
			ProgressPercent(20);
			window.setTimeout(function() { getall(); }, progress);
		} else {
			getall();
		}

		function getall() {

			var n_scenarios = arrayResults.length;
	
			console.log("Demo - AJAX - scenarioOnlineGetAll - "+ n_scenarios +" scenarios");

			// For each online scenario
			for (i in arrayResults) {
				var scenario = scenarioOnlineGetOne(path, arrayResults[i].scenario_id);
				result.push(scenario);
			}
		}
    });
    console.log("Demo - scenarios - ", result.length," online scenarios found");
	return result;
}

/**
 * Check name availability on server
 * 
 * @param path
 * @param name
 * @returns {Boolean}
 */
function scenarioOnlineCheckName(path, name) {
	var result = false;
    $.get(path+'online/ajax/scenario_check.php?name='+name, function (state) {
		if (state == "True") { result = true; }
		console.log("Demo - AJAX - ScenarioOnlineCheckName - "+state);
    });
	return result;
}
