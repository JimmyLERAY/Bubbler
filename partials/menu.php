
<!-- Conteneur du menu principal -->
<nav id="navbar-header" class="navbar-inverse navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#/accueil"><b>Bubbler</b> &#946;</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<ul class="nav navbar-nav">
				<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret" style="border-right:8px solid transparent;border-left:8px solid transparent;border-top:8px dashed;"></span> {{pseudo}}</a>
					<ul class="dropdown-menu">
						<li><a href="#/actus">Actualités</a></li>
						<li data-ng-show="connected"><a href="#/votes">Mes votes</a></li>
						<li data-ng-show="connected"><a href="#/messages">Mes messages</a></li>
						<li data-ng-show="connected"><a href="#/notifs">Mes notifications</a></li>
						<li data-ng-show="connected"><a href="#/profil">Mon compte</a></li>
						<li data-ng-show="connected"><a href="#/accueil" data-ng-click="logout()">Déconnexion</a></li>
					</ul>
				</li>
			</ul>

			<div class="nav navbar-nav navbar-left navbar-form">
				<a href="#/connexion" class="btn btn-success" data-ng-show="!connected" style="color:black;"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a>
				<a href="#/ajouter" class="btn btn-success" data-ng-show="connected" style="color:black;"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
			</div>

			<form id="search_form"  class="nav navbar-nav navbar-left navbar-form" onsubmit="search()" role="search">
				<div class="form-group form-search">
					<div class="input-group">
						<input id="menu_search" type="text" class="form-control" data-ng-model="search" placeholder="Rechercher ou filtrer ...">
						<span class="input-group-btn">
							<button class="btn btn-primary" onclick="search()" type="button">
								<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							</button>
						</span>
					</div>
				</div>
			</form>

			<div class="nav navbar-nav navbar-right navbar-form">
				<a href="#/report" class="btn btn-warning" style="color:black;"><span class="fa fa-send"></span> Signaler un bug</a>
			</div>

		</div>
	</div>
</nav>
<!-- Fin du menu principal -->
