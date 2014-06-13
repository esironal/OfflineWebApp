/*******************************************************************************


					All functions to manage manifest
						 used in dev mode only


 *******************************************************************************/

//Error
window.applicationCache.addEventListener('error', function () {
	console.log("Demo - Manifest - Error");
}, false);

//First cached
window.applicationCache.addEventListener('cached', function () {
	console.log("Demo - Manifest - First cached");
	window.location.reload();
}, false);

//update ready
window.applicationCache.addEventListener('updateready', function () {
	console.log("Demo - Manifest - Update ready");
	window.applicationCache.update();
	window.applicationCache.swapCache();
	window.location.reload();
}, false);

//No update
window.applicationCache.addEventListener('noupdate', function () {
	console.log("Demo - Manifest - No update");
}, false);
