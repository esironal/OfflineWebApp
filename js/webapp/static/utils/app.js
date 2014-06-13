/*******************************************************************************


					  All functions to manage webapp


*******************************************************************************/

// Configure AJAX en mode synchrone
$.ajaxSetup( { async: false } );

//Name folder
var FolderName;

function setFolderName() {
	if ($('#FolderName').val() != "") {
		FolderName = $('#FolderName').val();
		console.log("Demo - FolderName - "+FolderName);
	} else {
		console.log("Demo - Error - FolderName not defined!");
		exit();
	}
}
