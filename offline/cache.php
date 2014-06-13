<?php
require_once "../online/utils.php";


//---------------------------------------------------------------------------
//
// Update manifest --- Start
//
//---------------------------------------------------------------------------

//Signin or signout
$sign = checkInput("get", "sign", "/^in|out$/");

if ($sign != false) {

	//Destination
	if ($sign == "in") {
		$title = "Sign in";
		$goto = "app.php";
	} else {
		$title = "Sign out";
		$goto = "../index.php";
	}

//Error
} else {
	echo "Bad parameter!";
	exit();
}


function redirection() {
	global $goto;
	?>
	window.setTimeout("window.location.href = \"<?php echo $goto; ?>\"", 500);
	<?php
}


?>
<!DOCTYPE html>
<html lang="en" manifest="../online/manifest.php" type="text/cache-manifest">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="description" content="Demo web app" />
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/demo.css" />
	<title>Demo webapp</title>

	<!-- Webapp JS -->
	<script type="text/javascript" src="../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="../js/webapp/static/cots/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/webapp/static/ihm/interface.js"></script>

	<script>

		console.log("-------------------------------");
		console.log("            cache.php");
		console.log("-------------------------------");

		$(function() {

			//On load
			$(document).ready(function() {
				$('#Loading').center();
			});
		});

		//Manage cache-----------------------------------------------------------

		window.applicationCache.addEventListener('error', function () {
			console.log("Demo - Manifest - Error");
			window.location.reload();
		}, false);

		window.applicationCache.addEventListener('cached', function () {
			console.log("Demo - Manifest - First cached");
			window.location.reload();
		}, false);

		window.applicationCache.addEventListener('updateready', function () {
			console.log("Demo - Manifest - Update ready");
			window.applicationCache.update();
			window.applicationCache.swapCache();
			window.location.reload();
		}, false);

		window.applicationCache.addEventListener('noupdate', function () {
			console.log("Demo - Manifest - No update");
			<?php redirection(); ?>
		}, false);

		//-----------------------------------------------------------------------

	</script>

</head>
<body>
	<img id="Loading" alt="Loading" width="20" height="20" src="../img/loading.gif" />
<?php
html_end();
?>
