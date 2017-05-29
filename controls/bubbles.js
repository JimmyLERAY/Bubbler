
// Service pour les bulles :
app.factory('Bubbles',['$http','$q',function($http,$q){
	var factory = {
		bubbles : false,
		getBubbles : function(){
			var deferred = $q.defer();
			$http.get('./json/bubbles.json')
			.success(function(data,status){
				factory.bubbles = data;
				deferred.resolve(factory.bubbles);
			}).error(function(data,status){
				deferred.reject('Impossible de recuperer les donnees !');
			});
			return deferred.promise;
		}
	}
	return factory;
}]);

// Controleur des bulles :
app.controller('BubblesCtrl',['$scope','$timeout','Bubbles',
	function($scope,$timeout,Bubbles){
		$scope.Math = window.Math;
		$scope.zoom = 1;

		$scope.bubbles_fct = Bubbles.getBubbles()
		.then(function(bubbles){
			$scope.bubbles = bubbles;
			$timeout(function(){
				// Centre la caméra et règle le zoom :
				focus_init();
				// Charge les icones :
				load_icon();
				// Enlève l'écran de chargement :
				$timeout(function(){
					$scope.loadingOff();
				},200);
			},400);
		},function(msg){
			alert(msg);
		});
	}
]);
