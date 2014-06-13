/*******************************************************************************
 * 
 * 	All functions to manage database
 * 
 *******************************************************************************/

/**
 * Load LocalStorage from JSON
 * 
 * @param path '../' or ''
 */
function loadDatabase(path) {

	// Load the database
	console.log("Demo - localStorage - Updating from JSON...");

	setLSFromDatabase(path, 1, 		true);
	setLSFromDatabase(path, 2,		true);
	setLSFromDatabase(path, 3, 		true);
	setLSFromDatabase(path, 4, 		true);
	setLSFromDatabase(path, 5, 		true);
	setLSFromDatabase(path, 6, 		true);
	setLSFromDatabase(path, 7, 		true);
	setLSFromDatabase(path, 8, 		true);
	setLSFromDatabase(path, 9, 		true);
	setLSFromDatabase(path, 10, 	true);
	setLSFromDatabase(path, 11,		true);
	setLSFromDatabase(path, 12, 	true);


	console.log("Demo - localStorage - Update done.");
}
