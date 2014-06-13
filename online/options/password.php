<?php
require_once "../utils.php";


//Connected or not
$state = check_connected();

//If connected
if ($state) {

	//If user have buy option
	if (checkOptions("password")) {

		//If validation of the form
		if (isset($_POST["password_old"])) {

			//Inputs
			$current = checkInput("post", "password_old", "/^.+$/");
			$new1 = checkInput("post", "password_new1", "/^.+$/");
			$new2 = checkInput("post", "password_new2", "/^.+$/");

			//If inputs are ok
			if ($current != false && $new1 != false && $new2 != false) {

				//Check current password
				$db = connectDataBase();
				$sql = "SELECT `user_id` FROM `webapp_users`
						WHERE `user_login` = '".$_SESSION["user"]["login"]."'
						AND `user_pass` = SHA1('$current') LIMIT 1;";
				$query = $db->query($sql);

				//Ok if one result
				if ($query->rowCount() == 1) {

					//If new passwords are equal
					if ($new1 == $new2) {

						//Set new password in database
						$sql = "UPDATE `webapp_users` SET `user_pass` = SHA1('".$new1."') WHERE `webapp_users`.`user_id` = ".$_SESSION["user"]["id"].";";
						if ($db->query($sql)) {

						//---------------------------------------------------------------------------
						//
						// Password changed --- Start
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
							<link rel="stylesheet" href="../../css/bootstrap.min.css" />
							<link rel="stylesheet" href="../../css/demo.css" />
							<title>Demo webapp</title>
							<script type="text/javascript" src="../../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
							<script type="text/javascript" src="../../js/webapp/static/cots/bootstrap.min.js"></script>
							<script>
								console.log("-------------------------------");
								console.log("     password.php -- ok");
								console.log("-------------------------------");
								$(window).load(function() {
									$('#ModalPasswordOK').modal('show');
									window.setTimeout("window.location.href = \"../../offline/app.php\"", 500);
								});
							</script>

						</head>
						<body>

							<?php
							StaticMessage("ModalPasswordOK", "working", "Mot de passe changé", "Merci de patienter...", "../../", "");

						html_end();
						exit();
						//---------------------------------------------------------------------------
						//
						// Password changed --- End
						//
						//---------------------------------------------------------------------------


						} else { $error = "Erreur !"; }

					//Error
					} else { $error = "Les mots de passe ne correspondent pas !"; }

				//Error
				} else { $error = "Mot de passe courant erroné !"; }
			}
		}
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
			<link rel="stylesheet" href="../../css/bootstrap.min.css" />
			<link rel="stylesheet" href="../../css/demo.css" />
			<title>Demo - Parameters</title>
			<script type="text/javascript" src="../../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
			<script type="text/javascript" src="../../js/webapp/static/cots/bootstrap.min.js"></script>
			<script type="text/javascript" src="../../js/webapp/static/ihm/interface.js"></script>

			<style type="text/css">
				label {
					font-weight: normal;
				}
			</style>

		</head>
		<body>

			<!-- Initialize Web App-->
			<script>

				console.log("-------------------------------");
				console.log("   password.php  --> Form");
				console.log("-------------------------------");

				$(function() {

					$(window).load(function() {
						$('#LabelParameters').modal('show');
					});				

					$('#formGo').on('submit', function() {

						//Button
						$('#go').prop('disabled', true);
						$('#go').val('Checking...');

						//Values
						var old = $('#password_old');
						var new1 = $('#password_new1');
						var new2 = $('#password_new2');

						//Labels
						var label_old = $('#label_password_old');
						var label_new1 = $('#label_password_new1');
						var label_new2 = $('#label_password_new2');

						//All is ok
						var status_old=1;
						var status_new=1;

						//Empty
						if (old.val()  == "") { label_old.addClass("inputError2");  status_old=0; } else { label_old.removeClass("inputError2"); }
						if (new1.val() == "") { label_new1.addClass("inputError2"); status_new=0; } else { label_new1.removeClass("inputError2"); }
						if (new2.val() == "") { label_new2.addClass("inputError2"); status_new=0; } else { label_new2.removeClass("inputError2"); }
						if (status_old == 0 || status_new == 0) { $('#Status').html("All fields are required!"); }

						//New passwords doesn't match
						if ((new1.val() != new2.val()) || (status_new == 0)) {
							status_new=0;
							label_new1.addClass("inputError2");
							label_new2.addClass("inputError2");
							$('#Status').html("La confirmation du mot de passe ne correspond pas!");
						} else {
							label_new1.removeClass("inputError2");
							label_new2.removeClass("inputError2");
						}

						//Current password
						if (status_old == 0) { $('#Status').html("Le mot de passe courant est obligatoire !"); }

						//All is ok
						if (status_old == 1 && status_new == 1) {
							$('#go').val('Saving...');
							$('#Status').html("");
							$('#formGo').submit();
						} else {
							$('#go').prop('disabled', false);
							$('#go').val('Save');
							return false;
						}

					});
				});
			</script>

			<!-- Parameters -->
			<div class="modal fade dialog" id="LabelParameters" data-keyboard="false" data-backdrop="static">

			<div class="col-xs-offset-2 col-xs-8
						col-sm-offset-2 col-sm-8
						col-md-offset-3 col-md-6
						col-lg-offset-3 col-lg-6 panel panel-default">

					<div class="hidden-xs col-sm-4 text-center">
						<span class="glyphicon glyphicon-lock"></span>
					</div>

					<div class="col-xs-12 col-sm-8">
						<h1>Modification du mot de passe</h1>

						<p><strong id="Status" class="inputError2"><?php if (isset($error)) echo $error; ?></strong></p>

						<form id="formGo" method="post" role="form" action="password.php">
							<div class="form-group">
								<label for="password_old" id="label_password_old">Mot de passe courant</label>
								<input type="password" class="form-control" id="password_old" name="password_old" value="">
							</div>
							<div class="form-group">
								<label for="password_new1" id="label_password_new1">Nouveau mot de passe</label>
								<input type="password" class="form-control" id="password_new1" name="password_new1" value="">
							</div>
							<div class="form-group">
								<label for="password_new2" id="label_password_new2">Confirmer nouveau mot de passe</label>
								<input type="password" class="form-control" id="password_new2" name="password_new2" value="">
							</div>

							<p class="pull-right">
								<button type="button" class="btn btn-default" onClick="window.location.href='../../offline/app.php';">Annuler</button>
								<input type="submit" id="go" class="btn btn-danger" value="Enregistrer">
							</p>
						</form>
					</div>
				</div>
			</div>

			<?php
			html_end();
	//Need option
	} else { NeedOption(); }

//If not connected
} else { ForbiddenAccess(); }
?>
