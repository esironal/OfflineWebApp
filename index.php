<?php
require_once "online/utils.php";

//Detect browser
$outdated = false;
$browser = detectBrowser();

if ($browser != false) {
	if (checkBrowser($browser) == false) {
		$outdated = true;
	}
} else {
	$outdated = true;
}

//Outdated browser
if ($outdated) {
	echo "<meta http-equiv=\"Refresh\" content=\"0; URL=offline/outdated.php\">";
	exit();
}

//Connected or not
$state = check_connected();

//If not connected
if (!$state) {

	/*
	 * User connection
	 *
	 */

	//If validation of the Sign in form
	if (isset($_POST["go"])) {


		//Login & pass from form
		$login = strtolower(checkInput("post", "login", "/^[a-zA-Z0-9]{1,}$/"));
		$password = checkInput("post", "password", "/.*/");
		$id_country = checkInput("post", "id_country", "/^[1-4]$/");

		//If inputs are ok
		if ($login != false && $password != false && $id_country != false) {

			//Check user
			$db = connectDataBase();
			$sql = "SELECT `user_login`, `group_name` FROM `webapp_users`
					WHERE `user_login` = '$login'
					AND `user_pass` = SHA1('$password')
					LIMIT 1;";
			$query = $db->query($sql);

			//Ok if one result
			if ($query->rowCount() == 1) {

				//Save user information in session
				$_SESSION["user"] = getInfosFromLogin($login);

				//If account is correctly configured
				if ($_SESSION["user"] != false) {

					//Create cookies
					$hash = hash("sha512", "$cookie_password $login");
					setcookie("ok", $hash , $cookie_time_to_live, "/".$cookie_path."/");
					setcookie("id_country", $id_country, $cookie_time_to_live, "/".$cookie_path."/");

					//Create user file cache
					createFile("", $hash);

					//Ok in session
					$_SESSION["ok"] = $hash;

					//---------------------------------------------------------------------------
					//
					// Install database --- Start
					//
					//---------------------------------------------------------------------------
					?>
					<!DOCTYPE html>
					<html lang="en">
					<head>
						<meta charset="utf-8" />
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<meta name="apple-mobile-web-app-capable" content="yes" />
						<meta name="description" content="Demo web app" />
						<link rel="stylesheet" href="css/bootstrap.min.css" />
						<link rel="stylesheet" href="css/demo.css" />
						<title>Demo webapp</title>
						<script type="text/javascript" src="js/webapp/static/cots/jquery-2.0.3.min.js"></script>
						<script type="text/javascript" src="js/webapp/static/cots/bootstrap.min.js"></script>
						<script type="text/javascript" src="js/webapp/static/utils/app.js"></script>
						<script type="text/javascript" src="js/webapp/static/utils/date.js"></script>
						<script type="text/javascript" src="js/webapp/static/ihm/interface.js"></script>
						<script type="text/javascript" src="js/webapp/static/ihm/build.js"></script>
						<script type="text/javascript" src="js/webapp/static/ihm/webactions.js"></script>
						<script type="text/javascript" src="js/webapp/static/storage/localstorage.js"></script>
						<script type="text/javascript" src="js/webapp/static/storage/scenario.js"></script>
						<script type="text/javascript" src="js/webapp/static/storage/scenario_online.js"></script>
						<script type="text/javascript" src="js/webapp/static/storage/scenario_offline.js"></script>
						<script type="text/javascript" src="js/webapp/static/storage/scenario_sync.js"></script>
						<script type="text/javascript" src="js/demo/storage/json.js"></script>

						<script>

							console.log("-------------------------------");
							console.log("     index.php -- database");
							console.log("-------------------------------");

							//On load
							$(document).ready(function() {

								//Center Image
								$('#Loading').center();

								//Waiting the loading of the progress image
								window.setTimeout(function() { 

									//Get folder name from hidden input
									//(Essential for LocalStorage!)
									console.log("Demo - JSON - Get folder name");
									setFolderName();

									//Loading database from JSON
									loadDatabase("");

									//Create Default scenario
									scenarioSave(true);

									//Goto web app
									window.location.href = "offline/cache.php?sign=in";

								 },500);

							});

						</script>

					</head>
					<body>
						<!-- Folder name (Essential for LocalStorage) -->
						<input type="hidden" id="FolderName" value="<?php echo $cookie_path; ?>" />
						<img id="Loading" alt="Loading" width="20" height="20" src="img/loading.gif" />
						<?php

					html_end();
					exit();
					//---------------------------------------------------------------------------
					//
					// Install database --- End
					//
					//---------------------------------------------------------------------------



				//Bad settings
				} else { $msg = "Ce compte utilisateur n'est pas configuré correctement !"; }

			//Bad login or password
			} else { $msg = "Le login/password est incorrect !"; }

		//Bad input value
		} else { $msg = "Merci de saisir un nom d'utilisateur et un mot de passe !"; }

	}



	//---------------------------------------------------------------------------
	//
	// Signin page --- Start
	//
	//---------------------------------------------------------------------------
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="description" content="Demo web app" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png"/>
		<link rel="stylesheet" href="css/bootstrap-select.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/demo.css" />
		<title>Demo webapp</title>
		<script type="text/javascript" src="js/webapp/static/cots/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/webapp/static/cots/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="js/webapp/static/cots/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/webapp/static/browsers/browser.js"></script>
		<script>
			console.log("-------------------------------");
			console.log("     index.php -- signin");
			console.log("-------------------------------");

			$(function() {

				//On load
				//$(document).ready(function() {
				$(window).load(function() {

					<?php
					//STANDALONE MODE FOR iOS
					if ($browser["browser"]["name"] == "Safari" && $browser["os"]["name"] == "iOS") {
						?>
						if(("standalone" in window.navigator) && (!window.navigator.standalone)) {
							console.log ("Demo - iOS detected but not in Standalone mode");
							$('#MsgAddToHomeScreen').modal('show');
						} else { console.log ("Demo - iOS Standalone mode detected"); }
						<?php
					}
					?>

					$('.selectpicker').selectpicker();

					console.log ("Demo - Signin to continue");

				});
			});

			//Submit button
			function validateForm() {
					$('#go').prop('disabled', true);
					$('#go').val('Connexion...');
					$('#formGo').submit();
			}
		</script>

	</head>
	<body>

	<?php
	// Add to home screen -->
	//STANDALONE MODE FOR iOS
	if ($browser["browser"]["name"] == "Safari" && $browser["os"]["name"] == "iOS") {
	?>
		<div class="modal fade dialog" id="MsgAddToHomeScreen" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="col-xs-offset-2 col-xs-8
						col-sm-offset-2 col-sm-8
						col-md-offset-3 col-md-6
						col-lg-offset-4 col-lg-4  panel panel-default">
				<div class="hidden-xs col-sm-4 text-center">
					<img src="img/icons/ios.png" height="100"/>
				</div>
				<div class="col-xs-12 col-sm-8">
					<h1>Ajoutez à l'écran d'accueil!</h1>
					<p id="status">
						<p>Installez cette WebApp sur votre <?php echo $browser["os"]["hardware"]; ?>.</p>
						<p>Cliquez sur 'Ajoutez à l'écran d'accueil' depuis Safari.</p>
					</p>
					<p class="pull-right">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Masquer</button>
					</p>
				</div>
			</div>
		</div>

	<?php
	}
	?>

	<!-- Sign in page -->
	<div class="container">

		<!-- Logo-->
		<div class="row">
			<div style="text-align:center; padding-bottom:20px;" class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
				
				<span class="logoSignInText">Dem<span class="glyphicon glyphicon-dashboard logoSignInIcon"></span></span>
			</div>
		</div>

		<!-- Sign in form-->
		<div class="row">
			<?php //Error message if needed
			if (isset($msg)) {
			?>
				<!-- Error message-->
				<div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Error!</strong>
					<?php echo $msg; ?>

				</div>
			<?php } ?>

			<!-- Password-->
			<div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6 alert alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<p><strong>Information pour la démonstration</strong></p>
				<p><i><u>Utilisateur sans droit</u> :</i> user/user</p>
				<p><i><u>Utilisateur avec droits</u> :</i> demo/demo</p>		
				<p><i><u>Administrateur</u> :</i> admin/admin</p>		
			</div>

			<div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
				<div class="row">
					<div class="col-xs-12 panel panel-default">
						<h3>Connectez-vous pour continuer</h3>
						<form id="formGo" role="form" method="post" action="">
						
							<input type="hidden" name="go" value="1">

							<div class="form-group">
								<input type="text" class="form-control" name="login" placeholder="Username" value="<?php if (isset($login)) echo $login; ?>">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" name="password" placeholder="Password">
							</div>
							<input id="go" type="submit" class="btn btn-danger btn-lg btn-block" data-loading-text="Chargement..." value="Sign in" onClick="validateForm();">
							<p></p>
							<input type="hidden" name="id_country" value="1">
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
	
	<?php
	//debug();
	html_end();
	exit();
	//---------------------------------------------------------------------------
	//
	// Signin page --- End
	//
	//---------------------------------------------------------------------------


//If connected
} else {


	//---------------------------------------------------------------------------
	//
	// Goto --- Start
	//
	//---------------------------------------------------------------------------
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="description" content="Demo web app" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png"/>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/demo.css" />
		<title>Demo webapp</title>
		<script type="text/javascript" src="js/webapp/static/cots/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/webapp/static/cots/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/webapp/static/ihm/interface.js"></script>
		<script>
			console.log("-------------------------------");
			console.log("   index.php --> goto webapp");
			console.log("-------------------------------");
			$(function() {
				$(document).ready(function() {
					$('#SplashScreen').center();
					window.setTimeout("window.location.href = \"offline/app.php\"", 1000);

				});
			});
		</script>
	</head>
	<body>
	<img id="SplashScreen" width="120" height="120" src="img/apple-touch-icon.png" />
	<?php
	html_end();
	exit();
	//---------------------------------------------------------------------------
	//
	// Goto --- End
	//
	//---------------------------------------------------------------------------
}
?>
