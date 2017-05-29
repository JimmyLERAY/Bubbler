
app.directive('ngMenu',function(){
	return{
		restrict : 'E',
		templateUrl : 'partials/menu.php',
		link: function(scope,element,attrs){
			autocomplete_init('menu_search');
		}
	}
});
