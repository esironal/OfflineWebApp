<!--------------------------------------------------------------------------------------------------------------

	LABELS
	
	LabelMsg
	LabelSignout		=> SignOutWebApp('../')
	LabelReload			=> reloadWebApp('../')
	LabelSettings		=> window.location.href='../online/options/password.php'
						=> $('#LabelSettings').modal('hide');BuildScenarioOnlineRemove('../')
						=> $('#LabelSettings').modal('hide');BuildScenarioOfflineRemove('../')
						=> $('#LabelSettings').modal('hide');BuildScenarioSynchro('../')
	LabelSave			=> scenarioSave(false)
	LabelLoad			=> scenarioLoad()
	LabelOfflineRemove	=> $('#LabelOfflineRemove').modal('hide');BuildSettings()
						=> scenarioOfflineRemove()
	LabelOnlineRemove	=> $('#LabelOnlineRemove').modal('hide');BuildSettings()
						=> scenarioOnlineRemove('../')
	LabelWait

--------------------------------------------------------------------------------------------------------------->
<!-- Message -->
<div class="modal fade dialog" id="LabelMsg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

		<div class="hidden-xs col-sm-4 text-center">
			<span id="MsgImg"></span>
		</div>

		<div class="col-xs-12 col-sm-8">
			<h1 id="MsgTitle">Title</h1>
			<p id="MsgContent" >Content</p>
			<p class="pull-right">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
			</p>
		</div>
	</div>
</div>

<!-- Sign out -->
<div class="modal fade dialog" id="LabelSignout" tabindex="-1" data-keyboard="false" data-backdrop="static">

	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

		<div class="hidden-xs col-sm-4 text-center">
			<span class="glyphicon glyphicon-log-out"></span>
		</div>

		<div class="col-xs-12 col-sm-8">
			<h1>Déconnexion</h1>
			<p>
				<p>Etes-vous sur de vouloir vous déconnecter ?</p>
				<p>Vous ne pourrez plus utiliser l'application hors-ligne !</p>
			</p>
			<p id="signout_status" class="inputError2 hide">Merci de vous connecter à Internet pour continuer !</p>
			<p class="pull-right">
				<button id="signout_button_cancel" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				<button id="signout_button_signout" type="button" class="btn btn-danger" data-dismiss="modal" onClick="SignOutWebApp('../');">Déconnexion</button>
			</p>
		</div>
	</div>
</div>

<?php if (checkOptions("reload")) { ?>
	<!-- Reload -->
	<div class="modal fade dialog" id="LabelReload" tabindex="-1" data-keyboard="false" data-backdrop="static">

	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span class="glyphicon glyphicon-refresh"></span>
			</div>

			<div class="col-xs-12 col-sm-8">
				<h1>Re-télécharger</h1>
				<p>Etes-vous sur de vouloir re-télécharger l'application</p>
				<p id="reload_status" class="inputError2 hide">Merci de vous connecter à Internet pour continuer !</p>
				<p class="pull-right">
					<button id="reload_button_cancel" type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					<button id="reload_button_reload" type="button" class="btn btn-danger" data-dismiss="modal" onClick="reloadWebApp('../');">Re-télécharger</button>
				</p>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Settings -->
<?php if (checkOptions("password") || checkOptions("scenario")) { ?>
<div class="modal fade dialog" id="LabelSettings" tabindex="-1" data-keyboard="false" data-backdrop="static">

	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

		<div class="hidden-xs col-sm-4 text-center">
			<span class="glyphicon glyphicon-cog"></span>
		</div>

		<div class="col-xs-12 col-sm-8">
			<h1>Paramètres</h1>
	
				<?php if (checkOptions("password")) { ?>
					<button id="settings_button_password" type="button" class="btn btn-default btn-md btn-block" onClick="window.location.href='../online/options/password.php';">Modification du mot de passe</button>
				<?php } ?>

				<?php if (checkOptions("scenario")) { ?>
					<button id="settings_button_scenarios_online_remove" type="button" class="btn btn-default btn-md btn-block" onClick="$('#LabelSettings').modal('hide');BuildScenarioOnlineRemove('../');">Supprimer des scénarios "en-ligne"</button>
					<button id="settings_button_scenarios_offline_remove" type="button" class="btn btn-default btn-md btn-block" onClick="$('#LabelSettings').modal('hide');BuildScenarioOfflineRemove('../');">Supprimer des scénarios "hors-ligne"</button>
					<button id="settings_button_scenarios_synchro" type="button" class="btn btn-default btn-md btn-block" onClick="$('#LabelSettings').modal('hide');BuildScenarioSynchro('../');">Synchroniser les scénarios</button>
				<?php } ?>

			<p id="settings_status" class="inputError2 hide">Certaines fonctionnalitées ont besoin d'Internet pour continuer!</p>
			<p class="pull-right">
				<button id="settings_button_close" type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
			</p>
		</div>
	</div>
</div>
<?php } ?>

<?php if (checkOptions("scenario")) { ?>

	<!-- scenario : Save -->
	<div class="modal fade dialog" id="LabelSave" tabindex="-1" data-keyboard="false" data-backdrop="static">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span class="glyphicon glyphicon-floppy-disk"></span>
			</div>

			<div class="col-xs-12 col-sm-8">

				<h1>Créer un scénario</h1>							
				<h2>Nom du scénario :</h2>
				<input type="text" class="form-control" id="scenario_save_name" placeholder="Nom du scénario" value="">
				<p id="scenario_save_status" class="inputError2 hide">
					Ce scénario existe déja.</br>
					Merci de choisir un nouveau nom ou d'écraser un scénario existant.
				</p>

				<h1>Ecraser un scénario existant</h1>
				<h2>Sélectionner un scénario :</h2>
				<select id="scenario_save_id" class="form-control"></select>

				<p class="pull-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					<button id="scenario_save_button_save" type="button" class="btn btn-md btn-danger" onClick="scenarioSave(false);">Enregistrer</button>
				</p>
			</div>
		</div>
	</div>

	<!-- scenario : Load -->
	<div class="modal fade dialog" id="LabelLoad" tabindex="-1" data-keyboard="false" data-backdrop="static">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span class="glyphicon glyphicon-folder-open"></span>
			</div>

			<div class="col-xs-12 col-sm-8">
				<h1>Ouvrir un scénario</h1>
				<h2>Sélectionner un scénario :</h2>
				<select id="scenario_load_id" class="form-control"></select>

				<p id="scenario_load_status" class="inputError2 hide">
					Seul les scénarios "hors-ligne" sont disponibles !<br />
					Merci de vous connecter à Internet pour synchroniser les scénarios.
				</p>

				<p class="pull-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					<button id="scenario_load_button_load" type="button" class="btn btn-md btn-danger" data-dismiss="modal" onClick="scenarioLoad();">Ouvrir</button>
				</p>
			</div>
		</div>
	</div>

	<!-- scenario online : Remove -->
	<div class="modal fade dialog" id="LabelOnlineRemove" tabindex="-1" data-keyboard="false" data-backdrop="static">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span class="glyphicon glyphicon-trash"></span>
			</div>

			<div class="col-xs-12 col-sm-8">
				<h1>Suppression des scénarios "en-ligne"</h1>
				<h2>Sélectionner un scénario :</h2>
				<select id="scenario_online_remove_id" class="form-control"></select>

				<p id="scenario_online_remove_status" class="inputError2 hide">
					Merci de vous connecter à Internet pour supprimer les scénarios.
				</p>

				<p class="pull-right">
					<button id="scenario_online_remove_button_cancel" type="button" class="btn btn-default" onClick="$('#LabelOnlineRemove').modal('hide');BuildSettings();">Annuler</button>
					<button id="scenario_online_remove_button_remove" type="button" class="btn btn-md btn-danger" data-dismiss="modal" onClick="scenarioOnlineRemove('../');">Supprimer</button>
				</p>
			</div>
		</div>
	</div>

	<!-- scenario offline : Remove -->
	<div class="modal fade dialog" id="LabelOfflineRemove" tabindex="-1" data-keyboard="false" data-backdrop="static">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span class="glyphicon glyphicon-trash"></span>
			</div>

			<div class="col-xs-12 col-sm-8">
				<h1>Suppression des scénarios "hors-ligne"</h1>
				<h2>Sélectionner un scénario :</h2>
				<select id="scenario_offline_remove_id" class="form-control"></select>

				<p class="pull-right">
					<button type="button" class="btn btn-default" onClick="$('#LabelOfflineRemove').modal('hide');BuildSettings();">Annuler</button>
					<button id="scenario_offline_remove_button_remove" type="button" class="btn btn-md btn-danger" data-dismiss="modal" onClick="scenarioOfflineRemove();">Supprimer</button>
				</p>
			</div>
		</div>
	</div>

	<!-- Progress bar -->
	<div class="modal fade dialog" id="LabelWait" tabindex="-1" data-keyboard="false" data-backdrop="static">
	<div class="col-xs-offset-2 col-xs-8
				col-sm-offset-2 col-sm-8
				col-md-offset-3 col-md-6
				col-lg-offset-3 col-lg-6 panel panel-default">

			<div class="hidden-xs col-sm-4 text-center">
				<span id="progBar_img"></span>
			</div>

			<div id="progBar_right" class="col-xs-12 col-sm-8">
				<div id="progBar_title">
					<h1><span id="progBar_title_value">Title</span></h1>
				</div>

				<div id="progBar_percent" class="progress progress-striped active">
					<div id="progBar_percent_value" class="progress-bar progress-bar-danger"
							role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
						<span class="sr-only"></span>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php } ?>
