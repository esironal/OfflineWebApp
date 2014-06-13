<?php

/******************************************************************************
 *
 * HTML design for webapp
 *
 *****************************************************************************/


//HTML footer code with possibility to log
function html_end($log=true) {
	echo "</body></html>";
	if ($log) log_me();
}


//Need option page with redirection to index
function NeedOption() {
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
			console.log("          Need option");
			console.log("-------------------------------");
			$(function() {
				$(window).load(function() {
					$('#ModalOption').modal('show');
					window.setTimeout("window.location.href = \"../../offline/app.php\"", 3000);
				});
			});
		</script>
	</head>
	<body>
	<?php
	StaticMessage("ModalOption", "danger", "Need option", "<p>You need to subscribe an option to access this page!</p>", "../../", "");
	html_end();
	exit();
}



//Forbidden access page with redirection to index
function ForbiddenAccess($path="../../") {

	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="description" content="Demo web app" />
		<link rel="stylesheet" href="<?php echo $path; ?>css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $path; ?>css/demo.css" />
		<title>Demo webapp</title>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/ihm/interface.js"></script>
		<script>
			console.log("-------------------------------");
			console.log("        Forbidden access");
			console.log("-------------------------------");
			$(function() {
				$(window).load(function() {
					$('#SplashScreen').center();
					window.setTimeout("window.location.href = \"<?php echo $path; ?>index.php\"", 3000);
				});
			});
		</script>
	</head>
	<body>
	<img id="SplashScreen" alt="Optum" width="171" height="73" src="<?php echo $path; ?>img/optum_logo.png" />
	<?php
	html_end();
	exit();
}


//Static message
function StaticMessage($id, $icon,  $title, $msg, $path="", $goto) {
	?>
	<div class="modal fade dialog" id="<?php echo $id; ?>" data-keyboard="false" data-backdrop="static">
		<div class="col-xs-offset-2 col-xs-8
					col-sm-offset-2 col-sm-8 
					col-md-offset-3 col-md-6
					col-lg-offset-4 col-lg-4  panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<img src="<?php echo $path; ?>img/icons/<?php echo $icon; ?>.png" height="100"/>
			</div>
			<div class="col-xs-12 col-sm-8">
				<h1><?php echo $title; ?></h1>
				<p id="status" style="margin: 20px 0px 0px 0px;"><?php echo $msg; ?></p>
			</div>
		</div>
	</div>
	<?php
}

// Info message
function InfoMessage($id, $id_content, $id_title, $title, $content) {
	?>
	<div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="<?php echo $id_title; ?>"><?php echo $title; ?></h4>
				</div>
				<div class="modal-body" id="<?php echo $id_content; ?>"><?php echo $content; ?></div>
			</div>
		</div>
	</div>
	<?php
}


/******************************************************************************
 *
 * HTML design for admin
 *
 *****************************************************************************/

//HTML header code
function html_start($title, $path="../") {

	//Save page name in session
	$_SESSION["pageName"] = $title;

	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="description" content="Demo web app" />
		<link rel="stylesheet" href="<?php echo $path; ?>css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $path; ?>css/demo.css" />
		<link rel="stylesheet" href="<?php echo $path; ?>css/jquery.jqplot.min.css" />

		<title><?php if (isset($_SESSION["webAppName"])) { echo $_SESSION["webAppName"] ." - "; }
		echo $title; ?></title>

		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/tablesorter.min.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/browsers/manifest.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/browsers/links.js"></script>
		<script type="text/javascript" src="<?php echo $path; ?>js/webapp/static/ihm/interface.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script language="javascript" type="text/javascript" src="<?php echo $path; ?>js/webapp/static/cots/excanvas.js"></script>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>
	<?php
}


//Menu
function html_menu($path="") {

	if (checkRoot()) {
	?>

	<!-- Logo -->
	<a href="<?php echo $path; ?>offline/app.php">
		<span class="logoAppText">Dem<span class="glyphicon glyphicon-dashboard logoAppIcon"></span></span>
	</a>

	<!-- Menu TOP -->
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="z-index:10;">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MenuAppli">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=""></a>
		</div>
		<div class="collapse navbar-collapse" id="MenuAppli">
			
				<ul id="menuAppli" class="nav navbar-nav">
					<li<?php if (linkMenuActive("stats.php")) echo " class=\"active\"";
					?>><a href="stats.php"><span class="glyphicon glyphicon-stats"> Stats</span></a></li>
					<li<?php if (linkMenuActive("logs.php")) echo " class=\"active\"";
					?>><a href="logs.php"><span class="glyphicon glyphicon-list"> Logs</span></a></li>
				</ul>
			
		</div>
	</nav>
	
	<!-- Menu BOTTOM -->
	<nav class="navbar navbar-default navbar-fixed-bottom hidden-xs" role="navigation">
		<div class="collapse navbar-collapse" id="MenuAppli">
		</div>
	</nav>

	<?php
	}	
}

//Return true if running page is equal to input parameter
function linkMenuActive ($link) {

	//Running page
	$page = preg_replace("/^.*\/([^\/]+)$/", "$1", $_SERVER["PHP_SELF"]);

	//Return
	if ($link == $page) return true; else return false;
}


//Show all variables
function debug() {

	global $cookie_path;

	echo "<pre><strong>TIMESTAMP</strong><p>";
	echo time();
	echo "</p></pre>";

	echo "<pre><strong>\$cookie_path</strong><p>";
	echo $cookie_path;
	echo "</p></pre>";
	echo "<pre><strong>\$_SERVER</strong><p>";
	print_r($_SERVER);
	echo "</p></pre>";

	echo "<pre><strong>\$_SESSION</strong><p>";
	print_r($_SESSION);
	echo "</p></pre>";

	echo "<pre><strong>\$_COOKIE</strong><p>";
	print_r($_COOKIE);
	echo "</p></pre>";
}
?>
