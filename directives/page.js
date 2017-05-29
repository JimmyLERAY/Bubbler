
app.directive('ngPage',function(){
	return{
		restrict : 'E',
		link: function(scope,element,attrs){
			autocomplete_init('bulle1');
			autocomplete_init('bulle2');
		}
	}
});
