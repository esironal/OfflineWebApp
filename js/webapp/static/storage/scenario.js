/*******************************************************************************
 * 
 * 	All functions to manage online and offline scenarios
 * 		called y a click in a scenario dialog window
 * 
 * - scenarioSave
 * - scenarioLoad
 * - scenarioOfflineRemove
 * - scenarioOnlineRemove
 * - scenarioSynchro
 * 
 *******************************************************************************/

/**
 * Save a scenario into local storage
 * 
 * @param saveDefaultscenario Boolean = true to save the default scenario
 * @returns {Boolean} True if a new scenario has been created; otherwise false
 */
function scenarioSave(saveDefaultscenario) {

	console.log("Demo - scenario");

	var scenario_name = "";
	var scenario_datetime;
	var scenario_id;
	var name_ok = true;

	$("#settings_status").addClass("hide");
	
	if (!saveDefaultscenario) {
		
		scenario_name = $('#scenario_save_name').val();

		if (scenario_name == "" || 
				(checkAvailableOfflineScenarioName(scenario_name) && !scenarioOnlineCheckName("../", scenario_name))) {
			
			// TODO need to change the message if already exists offline (=> overwrite) or online (=>synchronize) 

			$('#LabelSave').modal('hide');	// Hide form
		} else {
			$("#scenario_save_status").removeClass("hide"); // Show message		
			name_ok = false;
		}

	} else {
		scenario_name = "Scénario par défaut";
	}
	
	if (name_ok) {
		
		// Create new scenario
		if (scenario_name != "") {
	
			console.log("Demo - scenario - New - "+ scenario_name);
	
			scenario_datetime = new Date();
			scenario_datetime = ISODateString(scenario_datetime);
	
			scenario_id = scenarioOfflineGetAvailableId();
	
		// Overwrite existing scenario
		} else {
	
			scenario_id = parseInt($('#scenario_save_id').val());
			console.log("Demo - scenario - Overwrite - "+ scenario_name +" (id "+ scenario_id+")");
	
			var old_scenario = scenarioOfflineGetOne(scenario_id);
			scenario_name = old_scenario.name;
	
			scenario_datetime = new Date();
			scenario_datetime = ISODateString(scenario_datetime);
	
			// Delete previous content
			console.log("Demo - scenario - Overwrite - "+ scenario_name +" - Deleting");
			deleteItemsFromLS("scenario_"+ scenario_id);
		}
	
	
		// New scenario object
		var scenario = new ScenarioObject(scenario_id, scenario_name, scenario_datetime);
	
		// User items in local storage
		var useritems = getItemsFromLS("USER_");
	
		if (useritems.length > 0) {
	
			// Add USER items in scenario object
			for (var i = 0; i < useritems.length; i++) {
	
				useritems[i].content = JSON.parse(useritems[i].content);
				scenario.add(useritems[i]);
			}
	
			// Save scenario object in local storage
			var scenarioItem = new LocalStorageItem(FolderName+'_scenario_'+scenario.id, JSON.stringify(scenario));
			scenarioItem.save();
	
		// Error
		} else {
			console.log("Demo - scenario - Save - No USER_ item in local storage!");
			BuildMsg("exclamation-sign", "Scénario enregistré", "Erreur, aucun USER_ item dans le local storage");
		}

		BuildMsg('ok', 'Scénario enregistré', "Le scénario '"+ scenario_name +"' a été enregistré.");
	}
}

/**
 * Load a scenario into USER items in local storage.
 * (Delete previous USER items and save new ones)
 * 
 * Reset STATUS items to false.
 * 
 * When finished load the home page of the application.
 */
function scenarioLoad() {

	console.log("Demo - scenario - Loading...");

	// Get scenario object
	var id = parseInt($('#scenario_load_id').val());
	var scenario = scenarioOfflineGetOne(id);

	if (scenario) {
		console.log("Demo - scenario - Load - "+scenario.name+" (id "+id+")");

		// Delete all USER_ items from local storage
		deleteItemsFromLS("USER_");

		// Reset STATUS_ items to false
		//deleteItemsFromLS("STATUS_");
		//setStatusLSItems();

		// Save USER items in local storage
		for (useritem in scenario.content) {
			var item = new LocalStorageItem(scenario.content[useritem].name, JSON.stringify(scenario.content[useritem].content));
			item.save();
			console.log("Demo - scenario - Load - "+item.name);
		}

		loadUSERInputs();

		console.log("Demo - scenario - Loading done");
		BuildMsg("ok", "Chargement d'un scénario", "Le scénario '"+ scenario.name +"' a été chargé.");

		// Go to home page (needed to reload data on other pages)
		showPage('exemple_graphs_resultats');
	} else {
		console.log("Demo - scenario - Load - Error");
	}
}


/**
 * Remove a scenario from local storage
 */
function scenarioOfflineRemove() {

	console.log("Demo - scenario - Remove offline - Start...");

	var scenario_id = parseInt($('#scenario_offline_remove_id').val());

	if (scenario_id != "") {

		console.log("Demo - scenario - Remove - Offline scenario selected");	

		if ( scenarioOfflineDeleteOne(scenario_id) ) {
			console.log("Demo - scenario - Remove - Offline scenario id ", scenario_id ," deleted");

			BuildMsg("ok", "Suppression d'un scénario", "Le scénario \"hors-ligne\" a été supprimé.");

		} else {
			console.log("Demo - scenario - Remove - Offline scenario id ", scenario_id, " not found");
		}

	} else {

		console.log("Demo - scenario - Remove - No offline scenario selected");
	}
}

/**
 * Remove a scenario from server
 * 
 * @param path Path to online/ajax ('../')
 */
function scenarioOnlineRemove(path) {

	console.log("Demo - scenario online - Remove - Start...");

	var scenario_id = parseInt($('#scenario_online_remove_id').val());

	if ( scenario_id != "") {
		
		console.log("Demo - scenario - Remove - Online scenario selected");
		
		if ( scenarioOnlineDeleteOne(path, scenario_id) == "True" ) {
			console.log("Demo - scenario - Remove - Online scenario id ", scenario_id ," deleted");

			BuildMsg("ok", "Suppression d'un scénario", "Le scénario \"en-ligne\" a été supprimé.");

		} else {
			console.log("Demo - scenario - Remove - Online scenario ", scenario_id, " not found");
		}

	} else {
		console.log("Demo - scenario - Remove - No online scenario selected");
	}
}

/**
 * Synchronize all scenarios:
 *  
 *  Init 10%
 *  1 - Get online scenarios 30%
 *  2 - Get offline scenarios 40%
 *  3 - Get online/offline scenarios to delete + online/offline scenarios to save 50%
 *  4 - Delete online and offline scenarios 60%
 *  5 - Upload offline scenarios to server 70%
 *  6 - Download online scenarios in local storage 80%
 *  
 * @param path Path to online/ajax ('../')
 */
function scenarioSynchro(path) {

	//--------------------------------------------
	//
	//	1 - Start
	//
	//--------------------------------------------
	console.log("Demo - Synchro - Start");

	var scenarios_online = [];
	var scenarios_offline = [];

	var toDelete_online = [];
	var toDelete_offline = [];
	var toDownload = [];
	var toUpload = [];

	// Time to refresh progress bar
	var pause = 150;

	ProgressPercent(10);
	window.setTimeout(function() { one(); }, pause);

	//--------------------------------------------
	//
	//	2 - Get online and offline scenarios
	//
	//--------------------------------------------

	// All scenarios from server
	function one() {
		scenarios_online = scenarioOnlineGetAll(path, pause);
		ProgressPercent(30);
		window.setTimeout(function() { two(); }, pause);
	}
	
	
	// All scenarios from local storage except the default scenario
	function two() {
		scenarios_offline = scenarioOfflineGetAll(false);
		ProgressPercent(40);
		window.setTimeout(function() { three(); }, pause);
	}

	//--------------------------------------------
	//
	//	3 - Get State
	//
	//--------------------------------------------

	// Detect similar scenarios (same name)
	// Get most recent scenarios
	function three () {

		scenarioSynchroDebug("scenarios_online", scenarios_online);
		scenarioSynchroDebug("scenarios_offline", scenarios_offline);
		console.log("*****************************************************");

		// Check scenarios with the same names (online compared to offline)
		// 	=> Online scenarios to delete
		//  => Offline scenarios to upload
		scenarioSynchroGetDuplicate(toDelete_online, toUpload, scenarios_online, scenarios_offline);
		scenarioSynchroDebug("toDelete_online", toDelete_online);
		scenarioSynchroDebug("toUpload more recent", toUpload);

		// Check scenarios with the same names (offline compared to online)
		//  => Offline scenarios to delete
		//  => Online scenarios to download
		scenarioSynchroGetDuplicate(toDelete_offline, toDownload, scenarios_offline, scenarios_online);
		scenarioSynchroDebug("toDelete_offline", toDelete_offline);
		scenarioSynchroDebug("toDownload more recent", toDownload);

		// Check new scenarios online
		//  => Online scenarios to download
		scenarioSynchroGetSingle(toDownload, scenarios_online, scenarios_offline);
		scenarioSynchroDebug("toDownload recent + new", toDownload);

		// Check new scenarios offline
		//  => Offline scenarios to upload
		scenarioSynchroGetSingle(toUpload, scenarios_offline, scenarios_online);
		scenarioSynchroDebug("toUpload more recent + new", toUpload);

		console.log("*****************************************************");

		ProgressPercent(50);
		window.setTimeout(function() { four(); },pause);
	}

	//--------------------------------------------
	//
	//	4 - Delete online and offline scenarios
	//
	//--------------------------------------------

	function four () {

		// Delete online scenarios
		if (toDelete_online.length > 0) {
			for (var i = 0; i < toDelete_online.length; i++) {
				if (scenarioOnlineDeleteOne(path, toDelete_online[i].id) == "True") {
					console.log("Demo - Synchro - The scenario '"+toDelete_online[i].name+"' has been deleted on server.");
				} else {
					console.log("Demo - Synchro - Error while deleting scenario '"+toDelete_online[i].name+"' on server!");
				}
			}
		} else { console.log("Demo - Synchro - Nothing to delete online"); }

		// Delete offline scenarios
		if (toDelete_offline.length > 0) {
			for (var i = 0; i < toDelete_offline.length; i++) {
				if (scenarioOfflineDeleteOne(toDelete_offline[i].id)) {
					console.log("Demo - Synchro - The scenario '"+toDelete_offline[i].name+"' has been deleted on server.");
				} else {
					console.log("Demo - Synchro - Error while deleting scenario '"+toDelete_offline[i].name+"' on local storage!");
				}
			}
		} else { console.log("Demo - Synchro - Nothing to delete offline"); }

		ProgressPercent(60);
		window.setTimeout(function() { five(); },pause);
	}

	//--------------------------------------------
	//
	//	5 - Upload offline scenarios to server
	//
	//--------------------------------------------

	function five () {

		if (toUpload.length > 0) {
			for (var i = 0; i < toUpload.length; i++) {
				if (scenarioOnlineSendOne(path, JSON.stringify(toUpload[i])) == "True") {
					console.log("Demo - Synchro - The scenario '"+toUpload[i].name+"' has been uploaded to the server");
				} else {
					console.log("Demo - Synchro - Error while uploading scenario '"+ toUpload[i].name +"' to the server!");
				}
			}
		} else {
			console.log("Demo - Synchro - Nothing to upload");
		}

		ProgressPercent(70);
		window.setTimeout(function() { six(); },pause);
	}

	//--------------------------------------------
	//
	//	6 - Download online scenarios to local storage
	//
	//--------------------------------------------
	function six () {

		if (toDownload.length > 0) {
			for (var i = 0; i < toDownload.length; i++) {
				// New id
				var id = scenarioOfflineGetAvailableId();
				toDownload[i].id = id;

				// Save scenario in local storage
				var scenarioItem = new LocalStorageItem(FolderName+'_scenario_'+id, JSON.stringify(toDownload[i]));
				scenarioItem.save();

				console.log("Demo - Synchro - The scenario '"+toDownload[i].name+"' has been downloaded to local storage");
			}
		} else {
			console.log("Demo - Synchro - Nothing to download");
		}

		ProgressPercent(80);
		window.setTimeout(function() {seven(); },pause);
	}

	//--------------------------------------------
	//
	//	7 - End
	//
	//--------------------------------------------

	function seven () {
		ProgressPercent(100);
		window.setTimeout(function() {

			ProgressBarHide();

			console.log("Demo - Synchro - Done");
			BuildMsg("ok", "Synchronisation terminée", "Tous les scénarios ont été synchronisés.");

		},pause);
	}
}
