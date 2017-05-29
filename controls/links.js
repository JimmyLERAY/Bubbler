
// Declaration de l'application Angular JS :
//var app = angular.module('app',[]);

// Service pour les bulles :
app.factory('Links',['$http','$q',function($http,$q){
	var factory = {
		links : false,
		getLinks : function(){
			var deferred = $q.defer();
			$http.get('./json/links.json')
			.success(function(data,status){
				factory.links = data;
				deferred.resolve(factory.links);
			}).error(function(data,status){
				deferred.reject('Impossible de recuperer les donnees !');
			});
			return deferred.promise;
		}
	}
	return factory;
}]);

// Controleur des liens :
app.controller('LinksCtrl',['$scope','Links',
	function($scope,Links){
		$scope.Math = window.Math;
		$scope.loading = true;
		$scope.links = Links.getLinks()
		.then(function(links){
			$scope.links = links;
		},function(msg){
			alert(msg);
		});
	}
]);
