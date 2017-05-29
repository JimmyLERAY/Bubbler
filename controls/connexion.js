
// Service pour la connexion :
app.factory('Connexion',['$http','$q',
	function($http,$q){
		var factory = {
			getToken : function($email,$pass){
				var deferred = $q.defer();
				$http({
					method:'POST',
					url:'./models/token.php',
					data:$.param({
						'email':$email,
						'pass':$pass
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data,status){
					deferred.resolve(data);
				}).error(function(data,status){
					deferred.reject('Impossible de se connecter !');
				});
				return deferred.promise;
			}
		}
		return factory;
	}
]);

// Controleur de la connexion :
app.controller('ConnexionCtrl',['$scope','$timeout','Connexion',
	function($scope,$timeout,Connexion){
		$scope.password = '';
    	$scope.email = '';
    	$scope.wrong = false;

    	$scope.connexion = function(){
    		if($scope.email != '' && $scope.password !=''){
    			Connexion.getToken($scope.email,$scope.password)
				.then(function(token){
					if(token == 'wrong'){
						$scope.wrong = true;
						$timeout(function(){
							$scope.wrong = false;
						},2000);
					}
					else if(token == 'unactive'){
						$scope.wrong = false;
						$location.path('/activation');
					}
					else{
						$scope.wrong = false;
						var temp = token.split('/');
						$scope.login(temp[0],temp[1],temp[2]);
					}
				},function(msg){
					alert(msg);
				});
			}	
    	}
	}
]);
