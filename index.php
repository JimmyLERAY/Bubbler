<!DOCTYPE html>

<html>
	<head>
		<title>Bubbler</title>

		<!-- Meta-balises -->
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>

		<!-- Icone du site -->
		<link rel="icon" href="./images/icon.png"/>
		
		<!-- Styles CSS -->
		<link type="text/css" rel="stylesheet" href="styles.php"/>
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	</head>

	<body>

		<div id="app_container" data-ng-app="app" data-ng-controller="AppCtrl" style="display:none;">

			<!-- Conteneur des bulles -->
			<ng-bubbles data-ng-show="!loading"></ng-bubbles>

			<!-- Conteneur du menu principal -->
			<ng-menu data-ng-show="!loading"></ng-menu>

			<!-- Conteneur de la vue de Angular JS -->
			<ng-page data-ng-view data-ng-show="!loading"></ng-page>

			<!-- Conteneur de la partie sécurité -->
			<div id="token" class="hidden">{{token}}</div>

			<!-- Ecran de chargement -->
			<div class="loading" data-ng-show="loading">
				<div class="spinner">
					<div class="ball"></div><p>CHARGEMENT</p>
				</div>
			</div>

		</div>

		<!-- Scripts javascript -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
		<script src="https://code.createjs.com/easeljs-0.8.1.min.js"></script>
		<script src="scripts.php"></script>
	</body>
</html>