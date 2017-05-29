<div id="page_container" data-ng-controller="ConnexionCtrl">
	<div class="container">
		<div id="loginbox" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
			<div class="panel panel-info">

				<div class="panel-heading">
					<div class="panel-title">Connexion</div>
					<div style="display:none;float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Mot de passe oublié ?</a></div>
					<span class="pull-right clickable glyphicon glyphicon-remove" data-ng-click="close_window()"></span>
				</div>     

				<div style="padding-top:20px" class="panel-body" >

					<form id="loginform" class="form-horizontal" name="loginform" role="form" novalidate>

						<div style="margin-bottom:5px;" class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input id="login-email" type="email" class="form-control" name="email" data-ng-model="email" placeholder="Adresse mail" required>                                        
						</div>

						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
							<input id="login-password" type="password" class="form-control" name="password" data-ng-model="password" placeholder="Mot de passe" required>
						</div>

						<div class="input-group" style="display:none;">
							<div class="checkbox">
								<label>
									<input id="login-remember" type="checkbox" name="remember" value="1"> Se souvenir de moi
								</label>
							</div>
						</div>

						<div style="margin-top:15px" class="form-group">
							<!-- Button -->
							<div class="col-sm-12 controls">
								<div class="ui-group-buttons" style="float:right;">
									<input type="submit" class="btn btn-info" value="Se connecter" data-ng-click="connexion()" data-ng-disabled="(loginform.password.$dirty && loginform.password.$invalid) || (loginform.email.$dirty && loginform.email.$invalid)">
									<!--<div class="or"></div>
									<input type="submit" class="btn btn-primary disabled" value="avec Facebook">
									-->
								</div>
							</div>
						</div>

						<div id="login-danger" class="alert alert-danger col-sm-12" data-ng-show="wrong">
							<ul>
								<li>
									Mauvais identifiants
								</li>
							</ul>
						</div>

						<div id="login-warning" class="alert alert-warning col-sm-12" data-ng-show="(loginform.email.$dirty && loginform.email.$invalid) || (loginform.password.$dirty && loginform.password.$invalid)">
							<ul data-ng-show="loginform.email.$dirty && loginform.email.$invalid">
								<li data-ng-show="loginform.email.$error.required">
									Adresse mail requise
								</li>
								<li data-ng-show="loginform.email.$error.email">
									Adresse mail invalide
								</li>
							</ul>
							<ul data-ng-show="loginform.password.$dirty && loginform.password.$invalid">
								<li data-ng-show="loginform.password.$error.required">
									Mot de passe requis
								</li>
							</ul>
						</div>

						<div class="form-group" style="margin-bottom:0px;">
							<div class="col-md-12 control">
								<div style="font-size:85%" >
									Vous n'avez pas de compte ? 
									<a href="#/inscription">
									<b>Inscrivez-vous en 30s !</b>
									</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
