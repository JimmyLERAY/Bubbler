<div id="page_container" data-ng-controller="ActivationCtrl">
	<div class="container">
		<div id="loginbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
			<div class="panel panel-info">

				<div class="panel-heading">
					<div class="panel-title">Activation</div>
					<span class="pull-right clickable glyphicon glyphicon-remove" data-ng-click="close_window()"></span>
				</div>     

				<div style="padding-top:20px" class="panel-body" >

					<form id="activateform" class="form-horizontal" name="activateform" role="form" novalidate>

						<div class="alert alert-success col-sm-12">
							Un <b>email</b> vient d'être envoyé sur votre messagerie contenant une <b>clé pour activer</b> votre compte. Pensez éventuellement à vérifier vos spams si vous n'avez rien reçu.
						</div>

						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="activatetoken" type="text" class="form-control" name="activatetoken" data-ng-model="activatetoken" placeholder="Clé de sécurité" required>
						</div>

						<div style="margin-top:20px;margin-bottom:5px;" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
								<div class="ui-group-buttons">
									<input type="submit" class="btn btn-info" value="Activer mon compte" data-ng-click="activate()" data-ng-disabled="activatetoken == '' || wrong_key || already_activated">
								</div>
							</div>
						</div>

						<div id="login-alert" class="alert alert-danger col-sm-12" data-ng-show="wrong_key || already_activated" style="margin-top:15px;margin-bottom:0px;">
							<ul>
								<li data-ng-show="wrong_key">
									Clé de sécurité incorrecte
								</li>
								<li data-ng-show="already_activated">
									Ce compte est déjà actif
								</li>
							</ul>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
