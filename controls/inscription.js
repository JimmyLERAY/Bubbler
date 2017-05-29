
// Service pour l'inscription :
app.factory('Inscription',['$http','$q',
	function($http,$q){
		var factory = {
			subscribe : function($pseudo,$email,$pass,$sexe){
				var deferred = $q.defer();
				$http({
					method:'POST',
					url:'./models/subscribe.php',
					data:$.param({
						'pseudo':$pseudo,
						'email':$email,
						'pass':$pass,
						'sexe':$sexe
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data,status){
					deferred.resolve(data);
				}).error(function(data,status){
					deferred.reject('Problème lors de l\'inscription !');
				});
				return deferred.promise;
			}
		}
		return factory;
	}
]);

// Controleur de l'inscription :
app.controller('InscriptionCtrl',['$scope','$timeout','$location','Inscription',
	function($scope,$timeout,$location,Inscription){

		$scope.password = '';
		$scope.passwordbis = '';

		$scope.email = '';
		$scope.emailbis = '';

		$scope.pseudo = '';
		$scope.sexe = 'masculin';
		
		$scope.wrong_pseudo = false;
		$scope.wrong_email = false;

    	$scope.inscription = function(){
    		if($scope.pseudo != '' && $scope.email != '' && $scope.password !='' && $scope.sexe !=''){
    			if($scope.email == $scope.emailbis && $scope.password == $scope.passwordbis){
	    			Inscription.subscribe($scope.pseudo,$scope.email,$scope.password,$scope.sexe)
					.then(function(res){
						if(res == 'wrong_pseudo'){
							$scope.wrong_pseudo = true;
							$scope.wrong_email = false;
							$timeout(function(){
								$scope.wrong_pseudo = false;
							},2000);
						}
						else if(res == 'wrong_email'){
							$scope.wrong_email = true;
							$scope.wrong_pseudo = false;
							$timeout(function(){
								$scope.wrong_email = false;
							},2000);
						}
						else if(res == 'subscribed' || res == 'unactive'){
							$scope.wrong_pseudo = false;
							$scope.wrong_email = false;
							$location.path('/activation');
						}
					},function(msg){
						alert(msg);
					});
				}
			}
    	}
	}
]);
