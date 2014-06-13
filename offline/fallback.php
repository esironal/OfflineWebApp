<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" href="../css/demo.css" />

	<title>Offline</title>

	<script type="text/javascript" src="../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="../js/webapp/static/cots/bootstrap.min.js"></script>

</head>
<body>

	<!-- Initialize Web App-->
	<script>
		//Start
		console.log("-------------------------------");
		console.log("            gohome.php");
		console.log("-------------------------------");

		$(function() {

			//On load
			$(window).load(function() {

				//Show message
				$('#LabelDisconnect').modal('show');

				//Goto web app
				window.setTimeout("window.location.href = \"../offline/app.php\"", 3000);

			});

		});
	</script>

	<!-- Unable to sign out -->
	<div class="modal fade dialog" id="LabelDisconnect" data-keyboard="false" data-backdrop="static">
		<div class="col-xs-offset-2 col-xs-8
					col-sm-offset-2 col-sm-8
					col-md-offset-3 col-md-6
					col-lg-offset-4 col-lg-4 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<img src="../img/icons/wifi.png" height="100"/>
			</div>
			<div class="col-xs-12 col-sm-8">
				<h1>Need Internet access!</h1>
				<p id="status" class="list-unstyled small">
					<p>Please connect to the Internet to access this page.</p>
				</p>
			</div>

		</div>
	</div>

</body>
</html>
