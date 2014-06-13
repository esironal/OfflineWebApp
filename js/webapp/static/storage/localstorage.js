/*******************************************************************************
 * 
 * 	All functions to manage the local storage
 * 
 *******************************************************************************/


function LocalStorageItem(name, content) {
	this.name = name;
	this.content = content;

	// Save object
	this.save = function () {
		localStorage.setItem(this.name, this.content);
	};

	// Load object
	this.load = function () {
		this.content = localStorage.getItem(this.name);
	};

	//TODO: add delete function?
}

/**
 * Return all prefixed items from local storage
 * 
 * @param prefix "scenario_" or "USER_"
 * @returns An array of LocalStorageItem (with content not parsed)
 */
function getItemsFromLS(prefix) {

	var results = [];

	// For each item
	for (var i = localStorage.length-1; i >= 0; i--) {

		var item = new LocalStorageItem(localStorage.key(i));

		// If item matches with prefix
		var regex = new RegExp("^"+ FolderName + "_" +prefix +".+$");

		if (item.name.match(regex, item.name)) {

			// Get content value
			item.load();

			// Add item to results
			results.push(item);
		}
	}

	return results;
}

/**
 * Delete all LocalStorageItem with prefix
 * 
 * @param prefix "scenario_" or "USER_" or "scenario_"+ scenario_id to delete one scenario
 * @returns {Boolean} Return true if at least one item has been deleted
 */
function deleteItemsFromLS(prefix) {

	var deleteOk = false;

	// Loop backwards!
	for (var i = localStorage.length-1; i >= 0; i--) {

		var item = localStorage.key(i);
		var regex = new RegExp("^"+FolderName+"_"+prefix+".*$");

		if (item.match(regex, item)) {
			console.log("Demo - localStorage - deleteItemsFromLS - "+item);
			localStorage.removeItem(item);
			deleteOk = true;
		}
	}
	return deleteOk;
}

/**
 * Store JSON strings from the database in local storage
 * 
 * @param path '../' or ''
 * @param data Name of the local storage item (= name of the table in the database) 
 * @param userModifiable True if a 'USER_' item needs to be created
 */
function setLSFromDatabase(path, data, userModifiable) {

    // Load JSON-encoded data from the server using a GET HTTP request
    // and returns a JavaScript object
    $.getJSON(path+'online/ajax/database.php?mois='+data, function (jsObject) {

		console.log("Demo - localStorage("+FolderName+") - "+data+" updated.");

		// DB item
		var item = new LocalStorageItem(FolderName+'_DB_'+data, JSON.stringify(jsObject));
		item.save();

		// USER item
		if (userModifiable) {
			item.name = FolderName+'_USER_'+data;
			item.save();
		}
    });
}
