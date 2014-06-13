/*******************************************************************************
 * 
 * 	All functions to manage offline scenarios
 * 
 *******************************************************************************/

function ScenarioObject(id, name, datetime) {

	this.id = id;
	this.name = name;
	this.datetime = datetime;
	this.content = [];

	this.add = function(item) {
		this.content.push(item);
	};
}

/**
 * Delete a scenario from the local storage.
 *  
 * @param id The id of the scenario
 * @returns {Boolean} Return true if at least one scenario has been deleted
 */
function scenarioOfflineDeleteOne(id) {
	return deleteItemsFromLS("scenario_"+ id);
}

/**
 * Return the first available id for scenarios in local storage
 * 
 * @returns {Number} The id available for a new scenario
 */
function scenarioOfflineGetAvailableId() {

	var items = getItemsFromLS("scenario_");
	var last_id = 1;

	if (items.length > 0) {

		// For each scenario
		for (var i = 0; i < items.length; i++) {

			// Parse scenario to get the id...
			var scenario = JSON.parse(items[i].content);

			if (scenario.id > last_id) last_id = scenario.id;
		}
		return last_id + 1;

	} else {
		// The default scenario has id = 1
		return last_id;
	}
}

/**
 * Check if an offline scenario already has this name
 * 
 * @param name The name of the new scenario
 * @returns {Boolean} True if the scenario name is available
 */
function checkAvailableOfflineScenarioName(name) {
	
	var available = true;
	var items = getItemsFromLS("scenario_");

	// For each scenario
	for (var i = 0; i < items.length; i++) {
		
		// Parse scenario to get the name...
		var scenario = JSON.parse(items[i].content);

		if (scenario.name == name) {
			available = false;
			break;
		}	
	}
	console.log("Demo - scenarios - checkAvailableOfflineScenarioName: ", available);
	return available;
}

/**
 * Return one scenario from local storage
 * 
 * @param id The id of the scenario
 * @returns The scenario
 */
function scenarioOfflineGetOne(id) {
	var item = new LocalStorageItem(FolderName+"_scenario_"+id);
	item.load();
	return JSON.parse(item.content);
}

/**
 * Return all scenarios from local storage
 * 
 * @param {Boolean} returnDefaultScenario True if the default scenario should be return as well
 * @returns {Array} An array of scenarios Objects (with parsed content)
 */
function scenarioOfflineGetAll(returnDefaultScenario) {

	console.log("Demo - scenarios - Get all offline scenarios...");
	var result = [];

	var items = getItemsFromLS("scenario_");

	// For each scenario
	for (var i = 0; i < items.length; i++) {

		// Return default scenario = true or 
		// Return default scenario = false and scenario != default
		if (returnDefaultScenario ||
				(!returnDefaultScenario && items[i].name != FolderName+"_scenario_1")) {

			result.push(JSON.parse(items[i].content));
		}
	}

	console.log("Demo - scenarios - ", result.length," offline scenarios found");
	return result;
}
