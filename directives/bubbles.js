
app.directive('ngBubbles',function(){
	return{
		restrict : 'E',
		templateUrl : 'partials/bubbles.php',
		link: function(scope,element,attrs){
			// Fonction pour rendre draggable la classe associée :
			$('.ui-draggable').draggable({cursor:"move"});
		}
	}
});
