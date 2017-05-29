
// Service pour l'inscription :
app.factory('Report',['$http','$q',
	function($http,$q){
		var factory = {
			report : function($report){
				var deferred = $q.defer();
				$http({
					method:'POST',
					url:'./models/report.php',
					data:$.param({
						'report':$report
					}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded'}
				}).success(function(data,status){
					deferred.resolve(data);
				}).error(function(data,status){
					deferred.reject('Problème lors de l\'envoi du rapport !');
				});
				return deferred.promise;
			}
		}
		return factory;
	}
]);

// Controleur de l'inscription :
app.controller('ReportCtrl',['$scope','$timeout','$location','Report',
	function($scope,$timeout,$location,Report){
		$scope.reportbug = '';
		$scope.send = false;
		
		$scope.help = false;
		$scope.toggle_help = function(){
			$scope.help = !$scope.help;
		}

    	$scope.report = function(){
    		if($scope.reportbug != ''){
    			Report.report($scope.reportbug)
				.then(function(res){
					if(res == 'send'){
						$scope.reportbug = '';
						$scope.send = true;
						$timeout(function(){
							$scope.send = false;
							$location.path('/accueil');
						},2000);
					}
				},function(msg){
					alert(msg);
				});
			}
    	}
	}
]);
