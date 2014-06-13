<?php
require_once "../online/utils.php";

//Connected or not
$state = check_connected();

//If connected
if ($state) {
	?>
	<!DOCTYPE html>
	<html lang="en" manifest="../online/manifest.php" type="text/cache-manifest">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="description" content="Demo web app" />
		<link rel="apple-touch-icon" href="../img/apple-touch-icon.png"/>
		<title>Demo webapp</title>

		<!-- CSS -->
		<link rel="stylesheet" href="../css/bootstrap-select.min.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" href="../css/jquery.jqplot.min.css" />
		<link rel="stylesheet" href="../css/demo.css" />

		<!-- COTS -->
		<script type="text/javascript" src="../js/webapp/static/cots/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/numeral.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/en-gb.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.categoryAxisRenderer.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.canvasAxisLabelRenderer.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.canvasTextRenderer.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.pointLabels.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.enhancedLegendRenderer.min.js"></script>
		<script type="text/javascript" src="../js/webapp/static/cots/jqplot.pieRenderer.min.js"></script>

		<!-- Utils -->
		<script type="text/javascript" src="../js/webapp/static/utils/app.js"></script>
		<script type="text/javascript" src="../js/webapp/static/utils/arrays.js"></script>
		<script type="text/javascript" src="../js/webapp/static/utils/date.js"></script>
		<?php if ($devmode) { ?><script type="text/javascript" src="../js/webapp/static/browsers/manifest.js"></script><?php } ?>
		<script type="text/javascript" src="../js/webapp/static/browsers/links.js"></script>
		<script type="text/javascript" src="../js/webapp/static/browsers/browser.js"></script>
		
		<!-- Scenarios -->
		<script type="text/javascript" src="../js/webapp/static/storage/localstorage.js"></script>
		<script type="text/javascript" src="../js/webapp/static/storage/scenario.js"></script>
		<script type="text/javascript" src="../js/webapp/static/storage/scenario_online.js"></script>
		<script type="text/javascript" src="../js/webapp/static/storage/scenario_offline.js"></script>
		<script type="text/javascript" src="../js/webapp/static/storage/scenario_sync.js"></script>
	
		<!-- IHM -->
		<script type="text/javascript" src="../js/webapp/static/ihm/webactions.js"></script>
		<script type="text/javascript" src="../js/webapp/static/ihm/build.js"></script>
		<script type="text/javascript" src="../js/webapp/static/ihm/inputs.js"></script>
		<script type="text/javascript" src="../js/webapp/static/ihm/interface.js"></script>
		<script type="text/javascript" src="../js/webapp/static/ihm/pbar.js"></script>
		<script type="text/javascript" src="../js/webapp/dynamic/menu.js"></script>

		<!-- Demo -->
		<script type="text/javascript" src="../js/demo/cots/numeral.js"></script>
		<script type="text/javascript" src="../js/demo/storage/json.js"></script>
		<script type="text/javascript" src="../js/demo/storage/localstorage.js"></script>
		<script type="text/javascript" src="../js/demo/ihm/graphs.js"></script>
		<script type="text/javascript" src="../js/demo/ihm/graphs_exemple.js"></script>
		<script type="text/javascript" src="../js/demo/ihm/elements.js"></script>
		<script type="text/javascript" src="../js/demo/ihm/load.js"></script>
		<script type="text/javascript" src="../js/demo/ihm/save.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script language="javascript" type="text/javascript" src="../js/webapp/static/cots/excanvas.js"></script>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hide">

		<!--------------------------------------------------------------------------------------------------------------

			CONFIG APPLI

		--------------------------------------------------------------------------------------------------------------->

		<!-- Folder name (Essential for LocalStorage) -->
		<input type="hidden" id="FolderName" value="<?php echo $cookie_path; ?>" />

		<!--------------------------------------------------------------------------------------------------------------

			LAUNCH WEB APP

		--------------------------------------------------------------------------------------------------------------->

		<!-- Initialize Web App-->
		<script>
			console.log("-------------------------------");
			console.log("  app.php -- Access granted ");
			console.log("-------------------------------");

			$(function() {

				//On load
				$(window).load(function() {






					//Get folder name from hidden input
					//Essential for LocalStorage!
					setFolderName();

					//Log connection when appli is downloaded
					if (check_internet("../")) log_me_js("../");

					// Show web app
					$('body').removeClass('hide');

					// Menu
					createMap();

					//Load default data from LS
					loadUSERInputs();

					//Enable click on inputs
					enableApp();

					// Show start page
					showPage("webapp_presentation_fonctionnalitees");
					//showPage("exemple_graphs_resultats");


				});
			});
		</script>

		<!--------------------------------------------------------------------------------------------------------------

			LABEL & MENU & REFERENCES

		--------------------------------------------------------------------------------------------------------------->

		<?php

		//Labels
		include("labels.php");

		//References
		InfoMessage("LabelReference", "LabelReferenceContent", "LabelReferenceTitle", "Default title", "Default content");

		//Menu
		include("menu.php");
		?>
		

		<!--------------------------------------------------------------------------------------------------------------

			CONTENT WEB APP

		--------------------------------------------------------------------------------------------------------------->

		<!-- Content web app -->
		<div class="container" style="z-index:1;">


			<!-- All pages -->
			<div id="pages" class="hide">

				<!-----------------------------------------------------------------------------------

					Présentation

				------------------------------------------------------------------------------------>

				<!-- FONCTIONNALITEES -->
				<div id="webapp_presentation_fonctionnalitees" class="form" >
					
					<div class="panel panel-default">
					  <div class="panel-body">
							<ul>
								<span class="strapline_blue_big">App Hors-ligne</span>
								<p>Cette application est accessible "hors-ligne", c'est à dire qu'elle n'a plus besoin d'Internet pour fonctionner une fois qu'elle a été téléchargée.</p>
								<p>Installée sur une tablette ou sur un téléphone, elle sera toujours accessible, même si Internet n'est pas disponible lors de vos déplacements.</p>
							</ul>
							<ul>
								<span class="strapline_red_big">App Synchronisée</span>
								<p>Dans le cas de modèle mathématique ou statistique, les données peuvent être complexes et fastidieuses à saisir.
								Cette application met en oeuvre la gestion des scénarios pour vous faciliter la saisie de vos jeux de données.</p>
								<p>Ces scénarios sont synchronisés à la demande sur un serveur afin que vous les retrouviez sur l'ensemble de vos périphériques.</p>
							</ul>
							<ul>
								<span class="strapline_orange_big">App Mobile</span>
								<p>Une application "hors-ligne" et "synchronisée" se doit d'être compatible avec l'ensemble des tablettes et téléphones du marché,
								elle est donc "responsive" et s'adapte donc automatiquement à la taille de votre écran.</p>
								<p>Sur un iPad/iPhone, en ajoutant l'application sur votre écran d'accueil, vous pouvez l'utiliser en plein écran et ansi y accéder plus facilement.</p>
							</ul>
							<ul>
								<span class="strapline_green_big">App Multi-utilisateurs</span>

								<p>Vous pouvez créer autant de groupes utilisateurs que vous le souhaitez et ainsi définir des règles de gestion en fonction de vos besoins.</p>

								<p>Chaque action utilisateur est enregistrée en base de données, ce qui permet d'établir des statistiques précises. Vous connaîtrez donc parfaitement les habitudes de vos utilisateurs.</p>

							</ul>
					  </div>
					</div>

				</div>

				<!-- PHILO -->
				<div id="webapp_presentation_philo" class="form">

					<span class="strapline_green_big">Pour qui ?</span>

					<div class="alert alert-success">
							<p>Cette application  est destinée à tous ceux qui souhaitent utiliser une application web mobile "hors-ligne".</p>
					</div>

					<span class="strapline_blue_big">Comment</span>

					<div class="alert alert-info">
						<p>Cette application est une sorte de Framework clé en main ou tout simplement un exemple d'appli hors ligne.</p>
						<p>Elle vous permettra de déployer rapidement, avec un minimum de développement, votre appli métier !</p>
					</div>

					<span class="strapline_red_big">Open source</span>

					<div class="alert alert-warning">
						<p>Cette application utilise des frameworks JavaScript et CSS libre de droits (JQuery, BootStrap, JQPlot, Numeral).</p>
						<p>Grand fan de l'open source, j'ai donc décidé de la rendre accessible à tous.</p>
					</div>
				</div>


				<!-- TELECHARGEMENT -->
				<div id="webapp_presentation_telechargement" class="form">

					  <div class="panel-body">

								<span class="strapline_green_big">Téléchargement</span>

								<div class="alert alert-success">
									<?php
									$file  = "DemoWebApp.zip";
									$path="../download/";
									?>
									<p><i><strong>Nom du fichier :</strong> <a href="<?php echo $path.$file; ?>"><?php echo $file; ?></a></i></p>
									<p><i><strong>Taille :</strong> <?php echo floor(filesize($path.$file)/1024); ?> ko</i></p>
									<p><i><strong>MD5 :</strong> <?php echo md5_file($path.$file); ?></i></p>
									<p><i><strong>SHA1 :</strong> <?php echo sha1_file($path.$file); ?></i></p>
								</div>
						
					  </div>

					
						
				</div>

				<!-- PRINCIPE -->
				<div id="webapp_technique_principe" class="form">

					<span class="strapline_red_big" style="color:#777777;">Principe de fonctionnement</span>

					<div>
							<div class="table-responsive">
  							<table class="table">
								<tr class="alert alert-success">	<th>1</i></th>	<td><i>Authentification</i></td>	<td>L'utilisateur se connecte par le biais d'un login/password (Création session PHP + cookie sécurisé)</td></tr>
								<tr class="alert alert-success">	<th>2</i></th>	<td><i>Données métiers</i></td>		<td>Téléchargement de la base de données "métier" (Requêtes JSON/AJAX + LocalStorage HTML5)</td></tr>
								<tr class="alert alert-success">	<th>3</i></th>	<td><i>Mise en cache</i></td>		<td>Téléchargement des fichiers de l'application (Manifest HTML5)</td></tr>
								<tr class="alert alert-success">	<th>4</i></th>	<td><i>WebApp</i></td>				<td>Utilisation de l'application</td></tr>
								<tr class="alert alert-info">		<th>5</i></th>	<td><i>Déjà connecté</i></td>		<td>Vérification que l'utilisateur est déjà connecté (cookie sécurisé)</td></tr>
								<tr class="alert alert-info">		<th>6</i></th>	<td><i>WebApp</i></td>				<td>Utilisation de l'application</td></tr>
								<tr class="alert alert-danger">		<th>7</i></th>	<td><i>Déconnexion</i></td>			<td>Déconnexion de l'utilisateur (Suppression LocalStorage + session PHP + cookie sécurisé)</td></tr>
								<tr class="alert alert-danger">		<th>8</i></th>	<td><i>Mise en cache</i></td>		<td>Mise à jour des fichiers de l'application (Manifest HTML5) </td></tr>
								<tr class="alert alert-danger">		<th>9</i></th>	<td><i>Authentification</i></td>	<td>L'utilisateur doit à nouveau s'authentifier</td></tr>
							</table>
							</div>
					</div>

					<div class="panel panel-default">
					  <div class="panel-body">
							<img src="../img/principe.png" width="100%">
					  </div>
					</div>
				</div>


				<!-- SGBD -->
				<div id="webapp_technique_bdd" class="form">

					<span class="strapline_blue_big">La base de données</span>

					<div class="alert alert-info">
						<p>Ci-dessous le MCD de la base de données, la partie essentielle au bon fonctionnement de l'application.</p>
						<p>Elle peut, bien entendu, être complétée par une base de données "métier" si besoin.</p>
					</div>


					<div class="panel panel-default">
					  <div class="panel-body">
							<img src="../img/bdd.png" width="100%">
					  </div>
					</div>
				</div>



				<!-----------------------------------------------------------------------------------

					Exemple

				------------------------------------------------------------------------------------>

				<!-- INPUTS -->
				<div id="exemple_donnees_inputs" class="form">

					<span class="strapline_blue_big">Exemple : "Les inputs"</span>

					<div class="alert alert-info">
						<p>Afin de pouvoir vous montrer l'utilité des scénarios, voici un exemple de données qui peut être enregistré/chargé et synchronisé.</p>
						<p>Les données sont contrôlées avant d'être automatiquement enregistrées.</p>

						<p>Si vous effectué une synchronisation (depuis le menu paramètres) avec le compte demo/demo, vous aurez accès à des scénarios pré-enregistrés.</p>
						
					</div>


					<div class="table-responsive">
						<table id="" class="table table-condensed">
							<thead>
								<tr>
									<th>Année 2013</th>
									<th>Chiffre d'affaires</th>
									<th>Bénéfice</th>
								</td></tr>
							</thead>
							<tbody>

									<?php

									function mois ($i) {
										$mois = Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
										return $mois[$i];
									}


									for ($i=0;$i<12;$i++) {
									?>

										<tr>
											<td class="col-xs-6"><?php echo mois($i); ?></td>
											<td class="col-xs-3"><input class="form-control" id="<?php echo 'ca_'.($i+1); ?>" type="text" value="" /></td>
											<td class="col-xs-3"><input class="form-control" id="<?php echo 'benef_'.($i+1); ?>" type="text" value="" /></td>
										</tr>

									<?php } ?>

								
							</tbody>
						</table>
					</div>


				</div>

				<!-- GRAPHS -->
				<div id="exemple_graphs_resultats" class="form">
					<span class="strapline_blue_big">Exemple : Graphique</span>

					<div class="alert alert-info">
						<p>Ce graphique est calculé automatiquement en fonction des données rentrées sur la page "Les inputs".</p>
					</div>

					<div id="graph_exemple" class="graph"></div>
				</div>




			</div>
		</div>

	<?php 
	html_end();

//If not connected
} else {
	ForbiddenAccess("../");
}
?>
