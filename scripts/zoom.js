// Niveau zoom :
var zoomMap = 1;

// Fonction pour ajouter proprement un event :
// Exemple d'appel : addEvent(document.getElementById('bouton_click'),'click',onclick_page);
function addEvent(obj,event,fct)
{
	if(obj.attachEvent)
		obj.attachEvent('on' + event,fct);
	else
	obj.addEventListener(event,fct,true);
}

// Appel des fonctions pour suivre les mouvements de la souris et arrêter le drag&drop :
addEvent(document,'mousewheel',mouseScroll);
addEvent(document,'DOMMouseScroll',mouseScroll);

// Fonction effectuée lorsque l'utilisateur utilise la roulette de sa souris :
function mouseScroll(event)
{
	// On zoom que si la caméra n'est pas bloquée :
	if(id_bubble_locked == ''){
		var event = window.event || event;

		// permet de savoir si la souris est sur une div content ou non :
		var windows = false
		var target = event.target;
		while(true){
			if(target.className == 'content'){
				windows = true;
				break;
			}else{
				if(target.offsetParent != null){
					target = target.offsetParent;
				}else{
					break;
				}
			}
		}

		// si la souris n'est pas dans une fenetre :
		if(!windows){
			var delta = 0.02*Math.max(-1,Math.min(1,(event.wheelDelta || -event.detail)));
			zoomMap += delta;
			changeZoom(zoomMap,false);
		}
	}
	return false;
}

// Fonction pour changer le niveau de zoom :
function changeZoom(zoom,slide){

	// On vérifie qu'on ne dépasse pas les limites du zoom :
	if(zoom < 0.04){zoomMap = 0.04;}
	else if(zoom > 1.4){zoomMap = 1.4;}
	else{zoomMap = zoom;}

	// On effectue le zoom :
	$('#bubbles_container').scale(zoomMap,zoomMap);
	$('.link .link_intensite').scale(1/zoomMap,1/zoomMap);

	// On change le niveau de zoom dans le scope des bulles :
	var scope = angular.element($("#bubbles_super_wrap")).scope();
    scope.$apply(function(){scope.zoom = 1/zoomMap;});

	// Si on n'utilise pas le slide on le met à jour :
	//if(!slide){
	//	var value = zoomMap*100;
	//	$("#slider_zoom").slider("option", "value", value);
	//}
}

// Fonction ajoutée à jquery pour effectuer une homotetie en CSS :
jQuery.fn.scale = function(dx,dy){
    $(this).css({'-webkit-transform' : 'scale('+ dx +','+ dy +')',
                 '-moz-transform' : 'scale('+ dx +','+ dy +')',
                 '-ms-transform' : 'scale('+ dx +','+ dy +')',
                 'transform' : 'scale('+ dx +','+ dy +')'});
    return $(this);
};
