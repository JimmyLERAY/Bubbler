
// Service pour l'activation :
app.factory('Activation',['$http','$q',
	function($http,$q){
		var factory = {
			activateUser : function($activatetoken){
				var deferred = $q.defer();
				$http({
					method:'POST',
					url:'./models/activate.php',
					data:$.param({
						'activatetoken':$activatetoken,
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data,status){
					deferred.resolve(data);
				}).error(function(data,status){
					deferred.reject('Impossible de procéder à l\'activation !');
				});
				return deferred.promise;
			}
		}
		return factory;
	}
]);

// Controleur de la connexion :
app.controller('ActivationCtrl',['$scope','$timeout','$location','Activation',
	function($scope,$timeout,$location,Activation){
		$scope.activatetoken = '';
    	$scope.wrong_key = false;
    	$scope.already_activated = false;

    	$scope.activate = function(){
    		if($scope.activatetoken != ''){
    			Activation.activateUser($scope.activatetoken)
				.then(function(res){
					if(res == 'wrong_key'){
						$scope.wrong_key = true;
						$scope.already_activated = false;
						$timeout(function(){
							$scope.wrong_key = false;
						},2000);
					}
					else if(res == 'already_activated'){
						$scope.wrong_key = false;
						$scope.already_activated = true;
						$timeout(function(){
							$scope.already_activated = false;
						},2000);
					}
					else if(res == 'success'){
						$scope.wrong_key = false;
						$scope.already_activated = false;
						$location.path('/accueil');
					}
				},function(msg){
					alert(msg);
				});
			}	
    	}
	}
]);
