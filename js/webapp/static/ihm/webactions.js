/*******************************************************************************


							All functions to do :
							- Ajax queries
							- Goto web page


*******************************************************************************/


/* -----------------------------------------------------------------------------
 *
 * Check internet connection (Ajax)
 *
 -----------------------------------------------------------------------------*/
function check_internet(path) {

	//Init
	var url = path+"online/internet.php";
	var onLine = false;

	//Ajax request
	var xhr = new XMLHttpRequest();
	xhr.open('HEAD', url, false);

	//Online
	try {
		xhr.send();
		onLine = true;
		console.log("Demo - Check Internet - Online");

	//Offline
	} catch (e) {
		onLine = false;
		console.log("Demo - Check Internet - Offline");
	}

	return onLine;
}


/* -----------------------------------------------------------------------------
 *
 * Reload web app (Ajax)
 *
 -----------------------------------------------------------------------------*/
function reloadWebApp(path) {

	console.log("Demo - Reload");

	// Modify timestamp in cache/<cookie_ok> folder
	$.get(
		path+"online/ajax/updateuserfile.php",
		"",
		function () {

			//Update OK
			console.log("Demo - User file cache updated");

			console.log("Demo - Delete localStorage");
			// Delete all items from local storage
			deleteItemsFromLS(""); 		// All
			//deleteItemsFromLS("USER_");	//Only USER_

			// Download database
			console.log("Demo - Download database");
			setFolderName();
			loadDatabase(path);

			// Create Default scenario
			scenarioSave(true);

			// Reload app
			console.log("Demo - Reload web app...");
			window.location.reload();
		}
	);
}

/* -----------------------------------------------------------------------------
 *
 * Logout web app
 *
 -----------------------------------------------------------------------------*/
function SignOutWebApp(path) {
	window.location.href = path+"online/signout.php";
}


/* -----------------------------------------------------------------------------
 *
 * Log client connection when webapp is downloaded (Ajax)
 *
 -----------------------------------------------------------------------------*/
function log_me_js(path) {

	var state=false;

	var log = $.get(
		path+"online/ajax/log.php",
		"",
		function (data) {
			if (data == "False") {
				console.log("Demo - Log - Ko");
			} else {
				console.log("Demo - Log - Ok");
				state = true;
			}
		}
	);

	return state;
}
