/*******************************************************************************
 * 
 * 	All functions to manage scenarios synchronization
 * 
 *******************************************************************************/

/**
 * Return all single scenarios from the first array (check only on name)
 * 
 * @param array1 First array of scenarios
 * @param array2 Second array of scenarios
 * @returns {Array} The scenarios from the first array that are not in the second array
 */
/*function scenarioSynchroGetSingle(array1, array2) {
	var results = [];
	var find;
	for (var i = 0; i < array1.length; i++) {
		find = false;
		for (var j = 0; j < array2.length; j++)
			if (array1[i].name == array2[j].name)
				find = true;
		if (!find) results.push(array1[i]);
	}
	return results;
}*/

/**
 * Compare 2 ISODateString
 * 
 * @param d1 First ISODateString
 * @param d2 Second ISODateString
 * @returns {Number} 0 if d1 = d2; 1 if d1 > d2; 2 if d2 > d1
 */
function scenarioSynchroCompareDate(d1, d2) {
	d1 = Date.parse(d1);
	d2 = Date.parse(d2);
	if (d1 > d2) { return 1; } else if (d1 < d2) { return 2; } else { return 0; }
}

/**
 * Compare array1 and array2 (check on name and datetime)
 * If 2 scenarios have the same name and 
 * 		date of the scenario in the second array > date of the scenario in the first array 
 * => return the scenario from the first array 
 * 
 * @param results
 * @param array1 First array of scenarios
 * @param array2 Second array of scenarios
 * @returns
 */
/*function scenarioSynchroCheckDuplicate(results, array1, array2) {
	var find;
	for (var i = 0; i < array1.length; i++) {
		find = false;
		for (var j = 0; j < array2.length; j++) {
			// Same name and date of array2 > date of array1 
			if (array1[i].name == array2[j].name
				&& scenarioSynchroCompareDate(array1[i].datetime, array2[j].datetime) == 2) {
				find = true;
				break;
			}
		}
		if (find) results.push(array1[i]);
	}
	return results;
}*/

/**
 * 
 * @param toDelete
 * @param toAdd
 * @param arrayFrom
 * @param arrayTo
 */
function scenarioSynchroGetDuplicate(toDelete, toAdd, arrayFrom, arrayTo) {

	if (arrayFrom.length > 0) {
		
		var findScenarioToDelete;

		for (var i = 0; i < arrayFrom.length; i++) {

			if (arrayTo.length > 0) {

				findScenarioToDelete = false;
	
				for (var j = 0; j < arrayTo.length; j++) {
	
					// Same name and date of arrayTo > date of arrayFrom 
					if (arrayFrom[i].name == arrayTo[j].name
						&& scenarioSynchroCompareDate(arrayFrom[i].datetime, arrayTo[j].datetime) == 2) {
	
						// Add more recent scenario
						toAdd.push(arrayTo[j]);
						findScenarioToDelete = true;
						break;
					}
				}
				if (findScenarioToDelete)
					// Delete old scenario
					toDelete.push(arrayFrom[i]);

			} // else no duplicate
		}

	} // else no duplicate
}


function scenarioSynchroGetSingle(toAdd, arrayFrom, arrayTo) {

	if (arrayFrom.length > 0) {

		var findSameScenario;

		for (var i = 0; i < arrayFrom.length; i++) {
	
			if (arrayTo.length > 0) {

				findSameScenario = false;

				for (var j = 0; j < arrayTo.length; j++) {

					// Loop until scenario with the same name is found
					if (arrayFrom[i].name == arrayTo[j].name) {
	
						findSameScenario = true;
						break;
					}
				}
				// No scenario with the same name has been found => add new scenario
				if (!findSameScenario) toAdd.push(arrayFrom[i]);

			} else {

				// Add new scenario
				toAdd.push(arrayFrom[i]);
			}
		}
	}
}

/**
 * Show in console all scenarios from an array (to debug)
 *  
 * @param title
 * @param array
 */
function scenarioSynchroDebug(title, array) {

	console.log("------------------------------------");
	console.log(" +++ "+ title +" +++ ");
	console.log("------------------------------------");

	for (var i = 0; i < array.length; i++)
		console.log("- "+ array[i].name + " (" + array[i].datetime + ")");
}
