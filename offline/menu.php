	
<!--------------------------------------------------------------------------------------------------------------

	MENU TOP

--------------------------------------------------------------------------------------------------------------->

<!-- Logo -->
<a href="#" onClick="showPage('webapp_presentation_fonctionnalitees');">
	<span class="logoAppText">Dem<span class="glyphicon glyphicon-dashboard logoAppIcon"></span></span>
</a>


<!-- Menu TOP -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="z-index:10;">

	<!-- Menu header -->
	<div class="navbar-header">

		<!-- Small responsive menu -->
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MenuAppli">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		 <a class="navbar-brand" href=""></a>

	</div>

	<!-- Menu -->
	<div class="collapse navbar-collapse" id="MenuAppli">
		<ul class="nav navbar-nav">

			<li class="dropdown" id="menu_webapp">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<b class="glyphicon glyphicon-record"></b> WebApp <b class="caret"></b></a>
				<ul class="dropdown-menu">

					<li>
						<span class="glyphicon glyphicon-pushpin"></span>
						<strong>Présentation</strong>
					</li>
					<li><a href="#" onClick="showPage('webapp_presentation_fonctionnalitees');">Fonctionnalités</a></li>
					<li><a href="#" onClick="showPage('webapp_presentation_philo');">Ma philosophie</a></li>
					<li><a href="#" onClick="showPage('webapp_presentation_telechargement');">Téléchargement</a></li>

					<li class="divider"></li>
					<li>
						<span class="glyphicon glyphicon-wrench"></span>
						<strong>Technique</strong>
					</li>
					<li><a href="#" onClick="showPage('webapp_technique_principe');">Principe de fonctionnement</a></li>
					<li><a href="#" onClick="showPage('webapp_technique_bdd');">La base de données</a></li>

				</ul>
			</li>

			<li class="dropdown" id="menu_exemple">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<b class="glyphicon glyphicon-list"></b> Exemple <b class="caret"></b></a>
				<ul class="dropdown-menu">

					<li>
						<span class="glyphicon glyphicon-list-alt"></span>
						<strong>Données</strong>
					</li>
					<li><a href="#" onClick="showPage('exemple_donnees_inputs');">Les "inputs"</a></li>

					<li class="divider"></li>
					<li>
						<span class="glyphicon glyphicon-stats"></span>
						<strong>Graphiques</strong>
					</li>
					<li><a href="#" onClick="showPage('exemple_graphs_resultats');">Les résultats</a></li>

			
				</ul>
			</li>
		</ul>

		<ul class="nav navbar-nav navbar-right">

			<!-- Scenario option -->
			<?php if (checkOptions("scenario")) { ?>

				<li><a href="#" onClick="BuildScenarioSave();" style="padding-right:0px;" title="Enregistrer un scénario">
				<b style="font-size:15px;padding:0px;" class="glyphicon glyphicon-floppy-disk"></b></a></li>

				<li><a href="#" onClick="BuildScenarioLoad('../');" title="Ouvrir un scénario">
				<b style="font-size:15px;padding:0px;" class="glyphicon glyphicon-folder-open"></b></a></li>

			<?php } ?>

			<!-- Settings -->
			<li class="dropdown" id="menu_more">

				<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Options">
				<b style="font-size:15px;padding:0px;" b class="glyphicon glyphicon-cog"></b></a>

				<ul class="dropdown-menu">



					<li><strong>Utilisateur - <?php echo $_SESSION["user"]["login"]; ?></strong></li>

					<?php if (checkOptions("password") || checkOptions("scenario") || checkOptions("reload")) { ?>
						<li><a href="#" data-toggle="modal" data-target="#LabelSettings" onClick="BuildSettings();"><span class="glyphicon glyphicon-cog"></span> Paramètres</a></li>
					<?php } ?>

					<li><a href="#" data-toggle="modal" data-target="#LabelLogout" onClick="BuildSignOut();"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
				</ul>
			</li>

			<!-- Admin menu-->
			<?php if (checkRoot()) { ?>
				<li class="dropdown" id="menu_more">

					<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Administration"><b
						style="font-size:15px;padding:0px;" class="glyphicon glyphicon-asterisk"></b></a>

					<ul class="dropdown-menu">

						<?php if (checkRoot()) { ?>
							<li><strong>Administration</strong></li>
							<!--<li><a href="../online/admin/stats.php"><span class="glyphicon glyphicon-stats"></span> Stats</a></li>
							<li><a href="../online/admin/logs.php"><span class="glyphicon glyphicon-eye-open"></span> Logs</a></li>-->
							<li><a href="#" data-toggle="modal" data-target="#LabelReload" onClick="BuildReload();"><span class="glyphicon glyphicon-refresh"></span> Re-télécharger</a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>

		</ul>
	</div>
</nav>

<!--------------------------------------------------------------------------------------------------------------

	MENU BOTTOM

--------------------------------------------------------------------------------------------------------------->

<!-- Menu BOTTOM -->
<div id="MenuBottom" class="hidden-xs navbar navbar-default navbar-fixed-bottom" style="z-index:9;">
	<div id="MenuBottomLeft"></div>
	<div id="MenuBottomMiddle"></div>
	<div id="MenuBottomRight"></div>
</div>


<!--------------------------------------------------------------------------------------------------------------

	WIDGETS

--------------------------------------------------------------------------------------------------------------->

<!-- Animation Bar -->
<img id="animation" class="hide" src="../img/pixel.png" height="1" width="1" style="position:fixed; top:50px; z-index:11;">

