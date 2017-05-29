
// Service pour l'inscription :
app.factory('Ajouter',['$http','$q',
	function($http,$q){
		var factory = {
			ajouter : function($bulle1,$bulle2,$intensite,$token){
				$intensite = 'attraction';
				var deferred = $q.defer();
				$http({
					method:'POST',
					url:'./models/ajouter.php',
					data:$.param({
						'bulle1':$bulle1,
						'bulle2':$bulle2,
						'intensite':$intensite,
						'token':$token
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data,status){
					deferred.resolve(data);
				}).error(function(data,status){
					deferred.reject('Problème lors de l\'ajout du lien !');
				});
				return deferred.promise;
			}
		}
		return factory;
	}
]);

// Controleur de l'inscription :
app.controller('AjouterCtrl',['$scope','$timeout','$location','Ajouter',
	function($scope,$timeout,$location,Ajouter){
		if(!$scope.connected){$location.path('/accueil');}
		$scope.intensite = 'attraction';
		$scope.bulle1 = '';
		$scope.bulle2 = '';
		$scope.add = false;
		$scope.already = false;
		$scope.notallowed = false;

		$scope.help = false;
		$scope.toggle_help = function(){
			$scope.help = !$scope.help;
		}

    	$scope.ajouter = function(){
    		$scope.bulle1 = document.getElementById("bulle1").value; 
    		$scope.bulle2 = document.getElementById("bulle2").value; 
    		if($scope.bulle1 != '' && $scope.bulle2 != '' & $scope.intensite != '' && $scope.token != false){
    			Ajouter.ajouter($scope.bulle1,$scope.bulle2,$scope.intensite,$scope.token)
				.then(function(res){
					if(res == 'add'){
						$scope.intensite = 'attraction';
						$scope.bulle1 = '';
						$scope.bulle2 = '';
						$scope.add = true;
						$scope.already = false;
						$scope.notallowed = false;
						$timeout(function(){
							$scope.add = false;
						},2000);
					}
					else if(res == 'already'){
						$scope.add = false;
						$scope.already = true;
						$scope.notallowed = false;
						$timeout(function(){
							$scope.already = false;
						},2000);
					}
					else if(res == 'not_allowed'){
						$scope.add = false;
						$scope.already = false;
						$scope.notallowed = true;
						$timeout(function(){
							$scope.notallowed = false;
						},2000);
					}
					else if(res == 'not_register'){
						$scope.add = false;
						$scope.already = false;
						$scope.notallowed = false;
						$location.path('/accueil');
					}
				},function(msg){
					alert(msg);
				});
			}
    	}
	}
]);
