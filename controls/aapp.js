
// Declaration de l'application Angular JS :
var app = angular.module('app',['ngRoute']);

// Routeur de l'application :
app.config(['$routeProvider',
	function($routeProvider){
		$routeProvider
			.when('/accueil',{templateUrl :'./pages/home.php'})
			.when('/actus',{templateUrl :'./pages/actus.php'})
			.when('/profil',{templateUrl :'./pages/profil.php'})
			.when('/messages',{templateUrl :'./pages/messages.php'})
			.when('/notifs',{templateUrl :'./pages/notifs.php'})
			.when('/ajouter',{templateUrl :'./pages/ajouter.php'})
			.when('/report',{templateUrl :'./pages/report.php'})
			.when('/connexion',{templateUrl :'./pages/connexion.php'})
			.when('/activation',{templateUrl :'./pages/activation.php'})
			.when('/inscription',{templateUrl :'./pages/inscription.php'})
			.otherwise({redirectTo : '/accueil'});

		// Affiche les fenetres avec la bonne hauteur max :
		max_height_window();
	}
]);


// Controleur de l'application :
app.controller('AppCtrl',['$scope','$location','$route','$timeout',
	function($scope,$location,$route,$timeout){
		$scope.token = false;
		$scope.pseudo = 'Menu';
		$scope.search = '';

		$scope.connected = false;
		$scope.login = function(token,pseudo,id){
			$scope.token = token;
			$scope.pseudo = pseudo;
			$scope.connected = true;
			$location.path('/accueil');
			$timeout(function(){
				focus_bubble(id);
        	})
		};
		$scope.logout = function(){
			$scope.token = false;
			$scope.connected = false;
			$location.path('/accueil');
			$scope.pseudo = 'Menu';
			$timeout(function(){
				zoom_bubble(72,true);
				map_focus_on_bubble(72);
				unselect_bubble();
        	})
		};

		$scope.close_window = function(){
			$location.path('/accueil');
		};

		$scope.loading = true;
		$scope.loadingOn = function(){$scope.loading = true;};
		$scope.loadingOff = function(){$scope.loading = false;};
	}
]);
