<div id="bubbles_super_wrap" data-ng-controller="BubblesCtrl">

	<!-- Conteneur des bulles -->
	<div id="bubbles_wrap" class="ui-draggable" data-ng-hide="loading">
		<div id="bubbles_container">
			<!-- Div très large pour permettre de déplacer la carte -->
			<div id="dragger"></div>

			<!-- Liste des liens -->
			<div id="links_container" data-ng-controller="LinksCtrl">
				<div id="l{{link.id}}" class="link" data-ng-repeat="link in links" data-link-intensite="{{link.intensite}}" style="left:{{link.x}}px; bottom:{{link.y}}px; width:{{link.l}}px; -ms-transform: rotate({{link.angle_deg}}deg); -webkit-transform: rotate({{link.angle_deg}}deg); transform: rotate({{link.angle_deg}}deg);">
					<!--<div class="link_intensite" title="{{link.intensite}}" style="background-color:{{link.intensite < 0 && '#fa623f' || '#77cc51'}};border-color:{{link.intensite < 0 && '#fa5a35' || '#59ad33'}}">+</div>-->
				</div>
			</div>
			<!-- Fin de la liste des liens -->

			<!-- Liste des bulles -->
			<div id="b{{bubble.id}}" class="bubble_container" data-ng-repeat="bubble in bubbles | orderBy:'+mass' | filter:search" data-x="{{bubble.x}}" data-y="{{bubble.y}}" data-r="{{bubble.r}}" data-c="#{{bubble.color}}" data-img="{{bubble.icon}}" style="left:{{bubble.x}}px;bottom:{{bubble.y}}px;-webkit-transform: scale({{zoom}},{{zoom}});transform:scale({{zoom}},{{zoom}});">

				<div class="bubble_titre" style="top:{{-bubble.r}}px;height:{{2*bubble.r}}px;line-height:{{2*bubble.r-4}}px;">	

					<span style="padding-left:{{8+1*bubble.r}}px;background-color:#{{bubble.color}};" data-ng-hide="bubble.type == 'humain-homme' || bubble.type == 'humain-femme'">
						{{bubble.titre}}
					</span>
					<span style="padding-left:{{8+1*bubble.r}}px;background-color:#{{bubble.color}};" data-ng-show="bubble.type == 'humain-homme' || bubble.type == 'humain-femme'">
						{{bubble.pseudo}}
					</span>
				</div>

 				<div class="bubble" style="height:{{2*bubble.r}}px;width:{{2*bubble.r}}px;background-color:#{{bubble.color}};">
					<div class="icon {{bubble.icon}}" style="opacity:{{bubble.icon_opacity}};filter:alpha(opacity={{100*bubble.icon_opacity}});"></div>
				</div>

				<div class="bubble_mass" style="left:{{bubble.r}}px;">
					{{bubble.mass}}
				</div>
				
			</div>
			<!-- Fin de la liste des bulles -->
		</div>
	</div>
	<!-- Fin du conteneur des bulles -->

	<!-- Conteneur des informations physiques des bulles -->
	<div id="bubbles_physics">
		<div id="bp{{bubble.id}}" class="bubble_physics" data-ng-repeat="bubble in bubbles">
			<span>
				Position : <b>( {{Math.round(bubble.x)}} ; {{Math.round(bubble.y)}} )</b><br>
				Vitesse : <b>( {{Math.round(bubble.vx*100)/100}} ; {{Math.round(bubble.vy*100)/100}} )</b>
			</span>
		</div>
	</div>
	<!-- Fin du conteneur des informations physiques -->

</div>
