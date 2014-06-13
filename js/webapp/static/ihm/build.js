/*******************************************************************************
 * 
 * 	All functions to build html modal windows
 * 
 *******************************************************************************/


// Time between two checks (ms)
// For all build pages needing Internet
var intervalTime = 500;

/**
 * Show Settings dialog window
 */
function BuildSettings() {

	console.log("Demo - BuildSettings");

	$('#LabelSettings').modal('show');

	function ihm() {
		if ( check_internet("../") ) {
			$("#settings_button_password").prop('disabled', false);
			$("#settings_button_scenarios_online_remove").prop('disabled', false);
			$("#settings_button_scenarios_synchro").prop('disabled', false);			
			$("#settings_status").addClass("hide");
		} else {
			$("#settings_button_password").prop('disabled', true);
			$("#settings_button_scenarios_online_remove").prop('disabled', true);
			$("#settings_button_scenarios_synchro").prop('disabled', true);
			$("#settings_status").removeClass("hide");
		}
	}

	// Detect client browser	
	var nav = jsDetectBrowser();

	// Interval for all browsers except Firefox & Iceweasel
	if (nav["name"] != "Firefox" && nav["name"] != "Iceweasel") {

		console.log("Demo - Check Internet - Launch interval("+ intervalTime +"ms)");

		// Check Internet connection with interval
		var interval = setInterval(function() {
			ihm();
		}, intervalTime);

		// Clear interval on exit
		$("#settings_button_password, #settings_button_scenarios_online_remove, #settings_button_scenarios_offline_remove," +
				"#settings_button_scenarios_synchro, #settings_button_close").click(function() {
			console.log("Demo - Check Internet - clearInterval()");
			clearInterval(interval);
		});

	// Firefox & Iceweasel
	} else {
		ihm();
	}
}

/**
 * Show Sign out dialog window
 */
function BuildSignOut() {

	console.log("Demo - BuildSignOut");
	$('#LabelSignout').modal('show');

	function ihm() {
		if ( check_internet("../") ) {
			$("#signout_button_signout").prop('disabled', false);
			$("#signout_status").addClass("hide");
		} else {
			$("#signout_button_signout").prop('disabled', true);
			$("#signout_status").removeClass("hide");
		}
	}

	var nav = jsDetectBrowser();

	if (nav["name"] != "Firefox" && nav["name"] != "Iceweasel" ) {

		console.log("Demo - Check Internet - Launch interval("+intervalTime+"ms)");

		// Check Internet connection with interval
		var interval = setInterval(function() {
			ihm();
		}, intervalTime);

		// Clear interval on exit
		$("#signout_button_cancel, #signout_button_signout").click(function() {
			console.log("Demo - Check Internet - clearInterval()");
			clearInterval(interval);
		});

	} else {
		ihm();
	}
}

/**
 * Show Reload dialog window
 */
function BuildReload() {

	console.log("Demo - BuildReload");
	$('#LabelReload').modal('show');

	function ihm() {
		if ( check_internet("../") ) {
			$("#reload_button_reload").prop('disabled', false);
			$("#reload_status").addClass("hide");
		} else {
			$("#reload_button_reload").prop('disabled', true);
			$("#reload_status").removeClass("hide");
		}
	}

	var nav = jsDetectBrowser();

	if (nav["name"] != "Firefox" && nav["name"] != "Iceweasel") {

		console.log("Demo - Check Internet - Launch interval("+intervalTime+"ms)");

		// Check Internet connection with interval
		var interval = setInterval(function() {
			ihm();
		}, intervalTime);

		// Clear interval on exit
		$("#reload_button_cancel, #reload_button_reload").click(function() {
			console.log("Demo - Check Internet - clearInterval()");
			clearInterval(interval);
		});

	} else {
		ihm();
	}
}

/**
 * Show Save scenario dialog window
 */
function BuildScenarioSave() {

	console.log("Demo - BuildScenarioSave");
	$('#LabelSave').modal('show');

	// Default
	$("#scenario_save_name").val("");
	$('#scenario_save_name').prop('disabled', false);
	$('#scenario_save_name').focus();
	$('#scenario_save_button_save').prop('disabled', true);
	$("#scenario_save_status").addClass("hide");

	/************** Actions if a new scenario name is entered or if an existing scenario is selected in the list *****************/

	// If text in new scenario name
    $("#scenario_save_name").keyup( function() {

		if ( $("#scenario_save_name").val() == "" ) {
			$('#scenario_save_button_save').prop('disabled', true);
			$('#scenario_save_id').prop('disabled', false);
			$("#scenario_save_status").addClass("hide");
		} else {
			$('#scenario_save_button_save').prop('disabled', false);
			$('#scenario_save_id').prop('disabled', true);
		}
    });

	// If the list of existing scenarios is selected
    $("#scenario_save_id").change( function(index, element) {

		if ($("option:selected", this).val() == "") {
			$('#scenario_save_button_save').prop('disabled', true);
			$('#scenario_save_name').prop('disabled', false);
			$("#scenario_save_name").focus();
		} else {
			$('#scenario_save_button_save').prop('disabled', false);
			$('#scenario_save_name').prop('disabled', true);
		}
	});

    /************** Load the list of scenarios that can be overwritten *****************/

	var findAtLeastOneScenario = false;
	var option = "";

	// Scenario items in local storage
	var items = getItemsFromLS("scenario_");

	// For each scenario
	for (var i = 0; i < items.length; i++) {

		// Parse scenario
		var scenario = JSON.parse(items[i].content);

		// Create list
		if (scenario.name != "Scénario par défaut") {
			option += "<option value=\""+scenario.id+"\">"+scenario.name +" ("+ scenario.datetime +")</option>";
			findAtLeastOneScenario = true;
		}
	}

	// No scenario in localStorage
	if (findAtLeastOneScenario == false) {
		console.log("Demo - scenario - No scenario!");
		$('#scenario_save_id').html("<option value=\"\">Pas de scénario disponible</option>");
		$('#scenario_save_id').prop('disabled', true);
	} else {
		option = "<option value=\"\">-</option>" + option;
		$('#scenario_save_id').html(option);
		$('#scenario_save_id').prop('disabled', false);
	}
}

/**
 * Show the progress bar during the synchronization of scenarios
 *  
 * @param path
 */
function BuildScenarioSynchro(path) {

	console.log("Demo - BuildScenarioSynchro");

	// Init the progress bar
	ProgressBarImg("glyphicon glyphicon-cloud");
	ProgressBarTitle("Synchronisation");
	ProgressBarShow();

	// Start synchronization
	window.setTimeout(function() { 
		scenarioSynchro(path);
	}, 500);
}

/**
 * Show Load scenario dialog window
 * 
 * @param path
 */
function BuildScenarioLoad(path) {

	console.log("Demo - BuildScenarioLoad");
	$('#LabelLoad').modal('show');

	// Show message if not connected to the Internet
	if (!check_internet(path)) {
		$("#scenario_load_status").removeClass("hide");
	} else {
		$("#scenario_load_status").addClass("hide");
	}

	/************** Load the list of scenarios that can be loaded *****************/

	var findAtLeastOneScenario = false;
	var option = "";

	// Scenario items in local storage
	var items = getItemsFromLS("scenario_");

	// For each scenario
	for (var i = 0; i < items.length; i++) {

		// Parse scenario
		var scenario = JSON.parse(items[i].content);

		findAtLeastOneScenario = true;

		// Create list
		if (scenario.name == "Scénario par défaut")
			option += "<option value=\""+scenario.id+"\">"+ scenario.name +"</option>";
		else
			option += "<option value=\""+scenario.id+"\">"+scenario.name +" ("+ scenario.datetime +")</option>";
	}


	//TODO: change: always at least the default scenario?
	// No scenario in localStorage
	if (findAtLeastOneScenario == false) {
		console.log("Demo - scenario - No scenario!");
		$('#scenario_load_id').html("<option value=\"\">Pas de scénario disponible</option>");
		$('#scenario_load_id').prop('disabled', true);
		$('#scenario_load_button_load').prop('disabled', true);
	} else {
		//option = "<option value=\"\">-</option>" + option;
		$('#scenario_load_id').html(option);
		$('#scenario_load_id').prop('disabled', false);
		$('#scenario_load_button_load').prop('disabled', false);
	}
	
	/************** Action if a scenario is selected in the list *****************/

	//TODO: remove not needed?
	// If a new scenario is selected in the list
    $("#scenario_load_id").change( function(index, element) {

		// Selected item
		var val = $("option:selected", this).val();

		// Activate the Load button is a scenario is selected
		if ( val == "" ) 	$('#scenario_load_button_load').prop('disabled', true);
		else 				$('#scenario_load_button_load').prop('disabled', false);
	});
}

/**
 * Show the Remove offline scenarios dialog window
 */
function BuildScenarioOfflineRemove(path) {

	console.log("Demo - BuildScenarioOfflineRemove");
	$('#LabelOfflineRemove').modal('show');

	// Default
	$('#scenario_offline_remove_button_remove').prop('disabled', true);

	/************** Load the list of scenarios that can be removed *****************/

	var findAtLeastOneScenario = false;
	var option = "";

	// Scenario items in local storage
	var items = getItemsFromLS("scenario_");

	// For each scenario
	for (var i = 0; i < items.length; i++) {

		// Parse scenario
		var scenario = JSON.parse(items[i].content);

		// Create list
		if (scenario.name != "Scénario par défaut") {
			option += "<option value=\""+scenario.id+"\">"+scenario.name +" ("+ scenario.datetime +")</option>";
			findAtLeastOneScenario = true;
		}
	}

	// No scenario that can be removed from localStorage
	if (findAtLeastOneScenario == false) {
		console.log("Demo - scenario offline - Remove - No scenario!");
		$('#scenario_offline_remove_id').html("<option value=\"\">Pas de scénario disponible</option>");
	} else {
		option = "<option value=\"\">-</option>" + option;
		$('#scenario_offline_remove_id').html(option);
	}

	/************** Action if a scenario is selected in the list *****************/

    $("#scenario_offline_remove_id").change( function(index, element) {

		// Selected item
		var val = $("option:selected", this).val();

		// Activate the Remove button is a scenario is selected
		if ( val == "" ) {
			console.log("No offline scenario to remove selected");
			$('#scenario_offline_remove_button_remove').prop('disabled', true);
		}
		else $('#scenario_offline_remove_button_remove').prop('disabled', false);
	});

}

/**
 * Show the Remove online scenarios dialog window
 */
function BuildScenarioOnlineRemove(path) {

	console.log("Demo - BuildScenarioOnlineRemove");
	$('#LabelOnlineRemove').modal('show');

	/************** Check the Internet connection *****************/

	// Show message if not connected to the Internet
	if (!check_internet(path)) {
		$("#scenario_online_remove_status").removeClass("hide");
		$('#scenario_online_remove_id').prop('disabled', true);
		$("#scenario_online_remove_button_remove").prop('disabled', true);
		
	} else {
		$("#scenario_online_remove_status").addClass("hide");
		$('#scenario_online_remove_id').prop('disabled', false);
		$("#scenario_online_remove_button_remove").prop('disabled', false);
	}

	function ihm() {
		if ( check_internet(path) ) {
			$("#settings_button_password").prop('disabled', false);
			$("#settings_button_scenarios_online_remove").prop('disabled', false);
			$("#settings_button_scenarios_synchro").prop('disabled', false);			
			$("#settings_status").addClass("hide");
		} else {
			$("#settings_button_password").prop('disabled', true);
			$("#settings_button_scenarios_online_remove").prop('disabled', true);
			$("#settings_button_scenarios_synchro").prop('disabled', true);
			$("#settings_status").removeClass("hide");
		}
	}

	// Detect client browser	
	var nav = jsDetectBrowser();

	// Interval for all browsers except Firefox & Iceweasel
	if (nav["name"] != "Firefox" && nav["name"] != "Iceweasel") {

		console.log("Demo - Check Internet - Launch interval("+ intervalTime +"ms)");

		// Check Internet connection with interval
		var interval = setInterval(function() {
			ihm();
		}, intervalTime);

		// Clear interval on exit
		$("#scenario_online_remove_button_cancel, #settings_button_scenarios_online_remove").click(function() {
			console.log("Demo - Check Internet - clearInterval()");
			clearInterval(interval);
		});

	// Firefox & Iceweasel
	} else {
		ihm();
	}

	/************** Load the list of scenarios that can be removed *****************/

	var findAtLeastOneScenario = false;
	var option = "";

	// Scenario items online
	var scenarios_online = scenarioOnlineGetAll(path, 0);

	// For each scenario
	for (var s = 0; s < scenarios_online.length; s++) {

		// Create list
		option += "<option value=\""+scenarios_online[s].id+"\">"+scenarios_online[s].name +" ("+ scenarios_online[s].datetime +")</option>";

		findAtLeastOneScenario = true;
	}

	// No online scenario
	if (findAtLeastOneScenario == false) {
		console.log("Demo - scenario online - Remove - No scenario!");
		$('#scenario_online_remove_id').html("<option value=\"\">Pas de scénario disponible</option>");
		$('#scenario_online_remove_button_remove').prop('disabled', true);
	} else {
		option = "<option value=\"\">-</option>" + option;
		$('#scenario_online_remove_id').html(option);
		$('#scenario_online_remove_button_remove').prop('disabled', false);
	}

	/************** Action if a scenario is selected in the list *****************/

    $("#scenario_online_remove_id").change( function(index, element) {

		// Selected item
		var val = $("option:selected", this).val();

		// Activate the Remove button is a scenario is selected
		if ( val == "" ) 	$('#scenario_online_remove_button_remove').prop('disabled', true);
		else 				$('#scenario_online_remove_button_remove').prop('disabled', false);
	});
}

/**
 * Show an alert message
 * 
 * @param type Bootstrap icon name
 * @param title Title of the dialog window
 * @param msg Content of the dialog window
 */
function BuildMsg(type, title, msg) {

	$('#MsgTitle').html(title);

	$('#MsgContent').html(msg);

	$('#MsgImg').removeClass();
	$('#MsgImg').addClass("glyphicon glyphicon-"+type);

	console.log("Demo - BuildMsg");
	$('#LabelMsg').modal('show');
}
