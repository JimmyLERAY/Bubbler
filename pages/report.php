<div id="page_container" data-ng-controller="ReportCtrl">
	<div class="container">
		<div id="loginbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
			<div class="panel panel-info">

				<div class="panel-heading">
					<div class="panel-title">Rapport de bug</div>
					<span class="pull-right clickable glyphicon glyphicon-remove" data-ng-click="close_window()"></span>
				</div>

				<div style="padding-top:20px" class="panel-body" >

					<form id="reportform" class="form-horizontal" name="reportform" role="form" novalidate>

						<div class="alert alert-success col-sm-12" data-ng-hide="help" data-ng-click="toggle_help()" style="cursor:pointer;">
							<b><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Besoin d'aide ou de conseils ?</b>
						</div>
						<div class="alert alert-success col-sm-12" data-ng-show="help" data-ng-click="toggle_help()" style="cursor:pointer;">
							N'hésitez pas à bien décrire les <b>actions qui ont précédé le bug</b>. Plus vous apporterez de détails, plus il sera facile pour l'équipe technique de <b>résoudre le problème</b>. Merci pour votre aide dans le <b>développement de Bubbler.fr</b> !
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<textarea id="reportbug" class="form-control" rows="8" name="reportbug" data-ng-model="reportbug" placeholder="Description du bug" style="max-width:100%;" required></textarea>
							</div>
						</div>

						<div style="margin-top:20px;margin-bottom:5px;" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
								<div class="ui-group-buttons">
									<input type="submit" class="btn btn-info" value="Envoyer le rapport" data-ng-click="report()" data-ng-disabled="reportbug == ''">
								</div>
							</div>
						</div>

						<div id="report-success" class="alert alert-success col-sm-12" data-ng-show="send" style="margin-top:10px;margin-bottom:0px;">
							<ul>
								<li>
									Votre message a bien été reçu !
								</li>
							</ul>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
