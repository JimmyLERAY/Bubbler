
// Flag caméra bloquée ou non :
var flag_locked_cam = false;
var id_bubble_locked = '';


// Flag bulle cliquée ou non :
var flag_clicked_bubble = false;
var id_bubble_selected = null;
var array_bubbles_subselected = [];


// Quand on clique sur une bulle :
$(document).on(
	"click",
	".bubble,.bubble_titre,.bubble_mass",
	function(){
		// On vide la barre de recherche :
		var scope = angular.element($("#app_container")).scope();
		scope.$apply(function(){scope.search = "";});
		// On cache l'autocomplete :
		$('.ui-autocomplete').hide();
		// On récupère l'id du conteneur de la bulle cliquée :
		var id = $(this).parent().attr('id').substring(1);
		focus_bubble(id);
	}
);


// Quand on passe la souris sur une bulle :
$(document).on({
    mouseenter: function (){
		// On récupère l'id du conteneur de la bulle cliquée :
		var id = $(this).parent().attr('id').substring(1);
		// On affiche la bulle sélectionnée :
		$('#b'+id+' .bubble_mass,#b'+id+' .bubble_titre').show();
		// on repasse l'opacité au maximum :
		$('#b'+id+' .bubble').fadeTo(0,1);
		// et on augmente le z-index :
		$('#b'+id).css("z-index","3");

		// On cache les informations des autres bulles :
		$('.bubble_physics').hide();
		// On affiche les infos de la bulle :
		$('#bp'+id).show();
    },
    mouseleave: function (){
		// On récupère l'id du conteneur de la bulle cliquée :
		var id = $(this).parent().attr('id').substring(1);
		// si la bulle est sélectionnée :
		if(id_bubble_selected == id){
			// on repasse le z-index a 2 :
			$('#b'+id).css("z-index","2");
		// si la bulle est sous-sélectionnée :
		}else if(array_bubbles_subselected.indexOf(id) != -1){
			// on repasse le z-index a 1 :
			$('#b'+id).css("z-index","1");
		}else{
			// On affiche la bulle sélectionnée :
			$('#b'+id+' .bubble_mass,#b'+id+' .bubble_titre').hide();
			// si une bulle est sélectionnée :
			if(id_bubble_selected != null){
				// on repasse l'opacité au minimum :
				$('#b'+id+' .bubble').fadeTo(0,0.25);
			}
			// et on diminue le z-index :
			$('#b'+id).css("z-index","0");
		}

		// On cache les informations des autres bulles :
		if(flag_clicked_bubble){
			// On cache les informations des autres bulles :
			$('.bubble_physics').hide();
			// On affiche les infos de la bulle :
			$('#bp'+id_bubble_selected).show();
		}else{
			// On cache les informations des bulles :
			$('.bubble_physics').hide();
		}
    }
},".bubble,.bubble_titre,.bubble_mass");


// Fonction pour sélectionner une bulle dont on connait l'id :
function select_bubble(id){

	// Si la caméra n'est pas bloquée sur une bulle :
	if(!flag_locked_cam){

		// On cache tous les éléments :
		$('.bubble_mass,.bubble_titre,.link').hide();
		// et on baisse l'opacité des bulles :
		$('.bubble').fadeTo(0,0.25);
		// on passe tous les titres en normal :
		// et on passe son texte en gras :
		$('.bubble_titre span').css("font-weight","inherit");
		// et rediminue les z-index :
		$('.bubble_container').css("z-index","0");

		// On affiche la bulle sélectionnée :
		$('#b'+id+' .bubble_mass,#b'+id+' .bubble_titre').show();
		// on repasse l'opacité au maximum :
		$('#b'+id+' .bubble').fadeTo(0,1);
		// on passe son texte en gras :
		$('#b'+id+' .bubble_titre span').css("font-weight","bold");
		// et on augmente son z-index :
		$('#b'+id).css("z-index","2");

		// On vide le tableau des bulles sous-sélectionnées :
		array_bubbles_subselected = [];

		// On affiche les liens qui sont connectés à la bulle :
		//$('div[id^=l'+id+'-],div[id$=-'+id+']').show();
		
		// Si il y'a au moins un lien avec la bulle :
		if($('div[id^=l'+id+'-]').length!=0){

			// On parcourt l'ensemble des liens :
			for (var i = 0; i < $('div[id^=l'+id+'-]').length; i++){

				// On récupère l'id du lien :
				var link_id = $('div[id^=l'+id+'-]')[i].id;

				// On récupère l'id de la première bulle :
				var id1 = link_id.split('-')[1];

				// On affiche les bulles liées :
				$('#b'+id1+' .bubble_titre,#b'+id1+' .bubble_mass').show();
				// et on repasse l'opacité au maximum :
				$('#b'+id1+' .bubble').fadeTo(0,1);
				// et on augmente son z-index :
				$('#b'+id1).css("z-index","1");
				// On ajoute la bulle au tableau :
				array_bubbles_subselected.push(id1);
			};
		}
		// Si il y'a au moins un lien avec la bulle :
		if($('div[id$=-'+id+']').length!=0){

			// On parcourt l'ensemble des liens :
			for (var i = 0; i < $('div[id$=-'+id+']').length; i++){

				// On récupère l'id du lien :
				var link_id = $('div[id$=-'+id+']')[i].id;

				// On récupère l'id de la deuxième bulle :
				var id2 = link_id.split('-')[0].substring(1);

				// On affiche les bulles liées :
				$('#b'+id2+' .bubble_titre,#b'+id2+' .bubble_mass').show();
				// et on repasse l'opacité au maximum :
				$('#b'+id2+' .bubble').fadeTo(0,1);
				// et on augmente son z-index :
				$('#b'+id2).css("z-index","1");
				// On ajoute la bulle au tableau :
				array_bubbles_subselected.push(id2);
			};
		}

		// On précise qu'une bulle est bien sélectionnée :
		flag_clicked_bubble = true;
		id_bubble_selected = id;

		// On cache les informations des autres bulles :
		$('.bubble_physics').hide();
		// On affiche les infos de la bulle :
		$('#bp'+id).show();
	}
}


// Fonction pour zoomer sur l'entourage d'une bulle précise :
function zoom_bubble(id,all){

	// Si la caméra n'est pas bloquée sur une bulle :
	if(!flag_locked_cam){

		// On initialise un tableau vide pour lister les bulles :
		var bulles = [];

		// On ajoute au tableau la bulle principale :
		bulles.push($('#b'+id));

		// Si on ne souhaite pas toutes les sélectionner :
		if(!all){
			// Si il y'a au moins un lien avec la bulle :
			if($('div[id^=l'+id+'-]').length!=0){

				// On parcourt l'ensemble des liens :
				for (var i = 0; i < $('div[id^=l'+id+'-]').length; i++){

					// On récupère l'id du lien :
					var link_id = $('div[id^=l'+id+'-]')[i].id;

					// On récupère l'id de la première bulle :
					var id1 = link_id.split('-')[1];

					// On ajoute au tableau les bulles liées :
					bulles.push($('#b'+id1));
				};
			}
			// Si il y'a au moins un lien avec la bulle :
			if($('div[id$=-'+id+']').length!=0){

				// On parcourt l'ensemble des liens :
				for (var i = 0; i < $('div[id$=-'+id+']').length; i++){

					// On récupère l'id du lien :
					var link_id = $('div[id$=-'+id+']')[i].id;

					// On récupère l'id de la deuxième bulle :
					var id2 = link_id.split('-')[0].substring(1);

					// On ajoute au tableau les bulles liées :
					bulles.push($('#b'+id2));
				};
			}
		}else{
			// Sinon on ajoute toutes les bulles :
			for (var i = 0; i < $('.bubble_container').length; i++){
				var id = $('.bubble_container')[i].id.substring(1);
				bulles.push($('#b'+id));
			}
		}

		// Si il y'a au moins une bulle liée :
		if(bulles.length > 1){

			// On initialise les bornes :
			var min_left = 100000; var max_left = -100000;
			var min_bottom = 100000; var max_bottom = -100000;

			// On boucle sur les bulles pour chercher le min et le max :
			for (var i = 0; i < bulles.length; i++){
				var left = bulles[i].css('left');
				var bottom = bulles[i].css('bottom');

				left = left.substring(0,left.length-2);
				bottom = bottom.substring(0,bottom.length-2);

				min_left = Math.min(left,min_left);
				max_left = Math.max(left,max_left);
				min_bottom = Math.min(bottom,min_bottom);
				max_bottom = Math.max(bottom,max_bottom);
			};

			// On récupère la position de la bulle principale :
			var main_left = bulles[0].css('left');
			var main_bottom = bulles[0].css('bottom');

			main_left = main_left.substring(0,main_left.length-2);
			main_bottom = main_bottom.substring(0,main_bottom.length-2);

			// On calcule les écarts entre les bornes et la principale :
			var top_margin = Math.abs(max_bottom - main_bottom);
			var bottom_margin = Math.abs(main_bottom - min_bottom);
			var left_margin = Math.abs(main_left - min_left);
			var right_margin = Math.abs(max_left - main_left);

			// On récupère la largeur et la hauteur de la fenetre :
			var client_width = $('#app_container').width();
			var client_height = $('#app_container').height();

			// On calcule la taille disponible pour l'affichage :
			var margin_plus = 75;
			client_height -= 2*margin_plus;
			client_width -= 2*margin_plus;

			// On sélectionne les marges pertinentes :
			var vertical_margin = Math.max(top_margin,bottom_margin);
			var horizontal_margin = Math.max(left_margin,right_margin);

			// On calcule le niveau de zoom adapté :
			var zoom_vertical = client_height / (2*vertical_margin);
			var zoom_horizontal = client_width / (2*horizontal_margin);
			var zoom_main = Math.min(zoom_vertical,zoom_horizontal);
			zoom_main = Math.floor(zoom_main*100)/100;

		}else{zoom_main = 1;}

		// On effectue finalement le zoom :
		changeZoom(zoom_main,false);
	}
}


// Fonction pour mettre le focus sur une bulle :
function focus_bubble(id){
	select_bubble(id);
	zoom_bubble(id,false);
	map_focus_on_bubble(id);
}


// Quand on double-clique sur la carte :
$(document).on(
	"dblclick",
	"#app_container",
	function(){
		// Si une bulle est sélectionnée :
		if(flag_clicked_bubble){
			// On la déselectionne :
			unselect_bubble();
		}else if($("#menu_search").val() != ""){
			// Si une recherche était en cours on la supprime :
			var scope = angular.element($("#app_container")).scope();
		    scope.$apply(function(){scope.search = "";});
		}else{
			// Sinon on dézoome en recentrant la carte :
			map_focus(0,0);
			zoom_bubble(72,true);
		}
	}
);


// Fonction pour désélectionner les bulles :
function unselect_bubble(){
	// Si une bulle est sélectionnée et que la caméra n'est pas bloquée :
	if(flag_clicked_bubble && !flag_locked_cam){

		// On vide le tableau des bulles sous-sélectionnées :
		array_bubbles_subselected = [];

		// On enlève tous les éléments :
		$('.link').fadeOut(1000);
		$('.bubble_mass,.bubble_titre').fadeOut(1000);

		// On repasse tous les titres en normal :
		$('.bubble_titre span').css("font-weight","inherit");
		// et rediminue les z-index :
		$('.bubble_container').css("z-index","0");

		// Puis on réaffiche juste les bulles et le fond :
		$('.bubble').fadeTo(1000,1);

		// On précise qu'aucune n'est alors sélectionnée :
		flag_clicked_bubble = false;
		id_bubble_selected = null;

		// On cache les informations des bulles :
		$('.bubble_physics').hide();
	}
}


// Fonction pour mettre à jour la position des bulles et des liens :
function update(){

	$.ajax({url: "./json/bubbles.json", 
		success: function(result){
			var bubbles = JSON.parse(result);
			for(i in bubbles){
				$("#b"+bubbles[i].id).css('left',bubbles[i].x + 'px').css('bottom',bubbles[i].y + 'px');
				$("#bp"+bubbles[i].id+" span").html("Position : <b>( "+Math.round(bubbles[i].x)+" ; "+Math.round(bubbles[i].y)+" )</b><br>
				Vitesse : <b>( "+Math.round(bubbles[i].vx*100)/100+" ; "+Math.round(bubbles[i].vy*100)/100+" )</b>");
			}
		}
	});

	$.ajax({url: "./json/links.json", 
		success: function(result){
			var links = JSON.parse(result);
			for(i in links){
				$("#l"+links[i].id).css('left',links[i].x + 'px').css('bottom',links[i].y + 'px').css('width',links[i].l + 'px');
				$("#l"+links[i].id).rotate(links[i].angle_deg);
			}
		}
	});

	// la fonction se relance elle-même toutes les 60 secondes :
	setTimeout(update,60000);
}


// Fonction ajoutée à jquery pour effectuer une rotation en CSS :
jQuery.fn.rotate = function(angle){
    $(this).css({'-webkit-transform' : 'rotate('+ angle +'deg)',
                 '-moz-transform' : 'rotate('+ angle +'deg)',
                 '-ms-transform' : 'rotate('+ angle +'deg)',
                 'transform' : 'rotate('+ angle +'deg)'});
    return $(this);
};


// Fonction ajoutée à jquery pour effectuer une translation en CSS :
jQuery.fn.translate = function(dx,dy){
    $(this).css({'-webkit-transform' : 'translate('+ dx +'px,'+ dy +'px)',
                 '-moz-transform' : 'translate('+ dx +'px,'+ dy +'px)',
                 '-ms-transform' : 'translate('+ dx +'px,'+ dy +'px)',
                 'transform' : 'translate('+ dx +'px,'+ dy +'px)'});
    return $(this);
};


// Fonction ajoutée à jquery pour effectuer une homotetie en CSS :
jQuery.fn.scale = function(dx,dy){
    $(this).css({'-webkit-transform' : 'scale('+ dx +','+ dy +')',
                 '-moz-transform' : 'scale('+ dx +','+ dy +')',
                 '-ms-transform' : 'scale('+ dx +','+ dy +')',
                 'transform' : 'scale('+ dx +','+ dy +')'});
    return $(this);
};
