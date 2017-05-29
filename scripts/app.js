
// Fonction lancée quand le DOM est chargé :
$(window).load(function(){

	// Quand le DOM est chargé on affiche l'application :
	$('#app_container').show();

	// Affiche les fenetres avec la bonne hauteur max :
	max_height_window();

	// Appel de la fonction pour mettre à jour les bulles et liens :
	setTimeout(update,10000);
});


// Fonction pour centrer la carte au lancement :
function focus_init(){
	map_focus(0,0);
	zoom_bubble(72,true);
}


// Fonction pour charger dynamiquement les icones des bulles :
function load_icon(){
	$('head').append('<link rel="stylesheet" type="text/css" href="./css/icon.css">');
};


// Fonction appelée quand la fenêtre est redimensionnée :
$(window).on('resize', function(){
	// Affiche les fenetres avec la bonne hauteur max :
	max_height_window();
});

// Fonction pour afficher les fenetres avec la bonne hauteur max :
function max_height_window(){
	var pageHeight = $(window).height();
	var navHeight = pageHeight - 150;
	$('.panel-body').css({"max-height":navHeight + 'px'});
};

// Fonction pour cibler un point précis de la carte :
function map_focus(left,bottom)
{
	var left_offset = 0.5*$(window).width();
	var bottom_offset = 0.5*$(window).height()+25;
	
	$("#bubbles_wrap").css("left",Number(left_offset - left*zoomMap) + 'px');
	$("#bubbles_wrap").css("top",Number(bottom_offset + bottom*zoomMap) + 'px');
}

// Fonction pour cibler une bulle dont on connait l'id :
function map_focus_on_bubble(id){
	
	// On récupère la bulle dont on a l'id :
	var bulle = $('#b'+id+' .bubble');

	// On sauvegarde sa position en x et y :
	var x = bulle.parent().css('left');
	x = x.substring(0, x.length-2);
	var y = bulle.parent().css('bottom');
	y = y.substring(0, y.length-2);

	// Puis on centre la carte sur cette position :
	map_focus(x,y);
}

// Fonction pour faire une recherche :
$("#search_form").submit(function(event){

	// On prévient le comportement par défaut :
	event.preventDefault();

	search();
});

function search(){

	// On prépare l'url d'une requete de recherche en ajax :
	var search = $("#menu_search").val();
    // On prépare l'url de la recherche :
	var url_search = "./models/search.php?s=" + search;

	// On effectue la requete en ajax pour obtenir l'id de la bulle :
	$.ajax({url: url_search,
		success: function(result){
			// On remet la recherche à zéro :
			var scope = angular.element($("#app_container")).scope();
		    scope.$apply(function(){scope.search = "";});
		    
			if(!isNaN(result)){focus_bubble(result);}
			else if(result = 'none'){
				$("#menu_search").attr('placeholder','Aucun résultat');
				setTimeout(function(){
					$("#menu_search").attr('placeholder','Rechercher une bulle ...');
				},1000);
			}
		}
	});
}
