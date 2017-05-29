<?php

class Bubble{

	private $id;
	private $titre;
	private $pseudo;
	private $type;
	private $x;
	private $y;
	private $view_x;
	private $view_y;
	private $vx;
	private $vy;
	private $ax;
	private $ay;
	private $fx;
	private $fy;
	private $mass;
	private $r;
	private $color;
	private $parenthese;
	private $icon;
	private $icon_opacity;
	private $border = 1;
	private $nom;
	private $prenom;
	private $sexe;
	private $facebook;
	private $twitter;
	private $youtube;

	// On initialise les valeurs nécessaires pour le calcul des mouvements :
	public function __construct($id){

		$res = MySQL::select_data('bubbles',array('x','y','vx','vy','mass','r'),'id=\''.$id.'\'');
		
		$this->id = $id;
		$this->x = $res[0]['x'];
		$this->y = $res[0]['y'];
		$this->r = $res[0]['r'];
		$this->mass = $res[0]['mass'];
		$this->vx = $res[0]['vx'];
		$this->vy = $res[0]['vy'];
		$this->ax = 0;
		$this->ay = 0;
		$this->fx = 0;
		$this->fy = 0;
	}

	// On initialise des données supplémentaires utiles pour l'affichage :
	public function init_plus(){

		$res = MySQL::select_data('bubbles',array('titre','type'),'id=\''.$this->id.'\'');

		$this->titre = $res[0]['titre'];
		$this->type = $res[0]['type'];

		if($this->type=='humain-homme' OR $this->type == 'humain-femme'){
			$this->titre = str_replace('u-','',$this->titre);
		}

		$this->view_x = $this->x - $this->r - $this->border;
		$this->view_y = $this->y + $this->r + $this->border;

		$this->icon = str_replace(' ', '-', $this->titre);
		$this->icon = str_replace('.', '', $this->icon);
		$this->icon = replace_accents($this->icon);
		$this->icon = strtolower($this->icon);

		if($this->type == 'pays' OR $this->type == 'activite' OR $this->type == 'astre'){}
		else{$this->icon = $this->type;}

		if($this->type == 'pays' OR $this->type == 'astre'){
			$this->icon_opacity = 0.4;
		}
		else{
			$this->icon_opacity = 0.2;
		}


		if($this->type=='humain-homme' OR $this->type == 'humain-femme'){
			
			$humain = MySQL::select_data('users',array('pseudo','nom','prenom','sexe','facebook','twitter','youtube'),'id=\''.$this->titre.'\'');
			
			$this->pseudo = $humain[0]['pseudo'];
			$this->nom = $humain[0]['nom'];
			$this->prenom = $humain[0]['prenom'];
			$this->sexe = $humain[0]['sexe'];
			$this->facebook = $humain[0]['facebook'];
			$this->twitter = $humain[0]['twitter'];
			$this->youtube = $humain[0]['youtube'];
		}

		$type = MySQL::select_data('types',array('titre','color'),'name="'.$this->type.'"');
		$this->color = substr($type[0]['color'],1);


		if($type[0]['titre']!=''){
			$this->parenthese = $type[0]['titre'];
		}else{$this->parenthese = '';}


		if($this->type == 'humain-homme' OR $this->type == 'humain-femme'){
			$this->titre = ucfirst(strtolower($this->prenom)).' '.ucfirst(strtolower($this->nom));
		}else{
			$this->titre = ucfirst($this->titre);
		}
	}


	// Rend les données de l'objet sous format JSON :
	public function get_JSON(){
		$text = '{';
		$text .= '"id":"'.$this->id.'",';
		$text .= '"titre":"'.$this->titre.'",';
		$text .= '"type":"'.$this->type.'",';
		$text .= '"x":"'.$this->x.'",';
		$text .= '"y":"'.$this->y.'",';
		$text .= '"r":"'.$this->r.'",';
		$text .= '"view_x":"'.$this->view_x.'",';
		$text .= '"view_y":"'.$this->view_y.'",';
		$text .= '"vx":"'.$this->vx.'",';
		$text .= '"vy":"'.$this->vy.'",';
		$text .= '"mass":'.$this->mass.',';
		$text .= '"color":"'.$this->color.'",';
		$text .= '"icon":"'.$this->icon.'",';
		$text .= '"icon_opacity":"'.$this->icon_opacity.'",';
		$text .= '"parenthese":"'.$this->parenthese.'",';

		if($this->type=='humain-homme' OR $this->type == 'humain-femme'){
			$text .= '"pseudo":"'.$this->pseudo.'",';
			$text .= '"nom":"'.$this->nom.'",';
			$text .= '"prenom":"'.$this->prenom.'",';
			$text .= '"sexe":"'.$this->sexe.'",';
		}

		// On supprime la virgule en trop et on ferme l'objet :
		$text = substr($text,0,-1);
		$text .= '}';

		return $text;
	}


	// Rend le code html pour dessiner une bulle :
	public function render(){

		if($this->type == 'humain-homme' OR $this->type == 'humain-femme'){
			$titre = ucfirst(strtolower($this->prenom)).' '.ucfirst(strtolower($this->nom));
		}else{
			if($this->parenthese != ''){
				$titre = ucfirst($this->titre.' ('.$this->parenthese.')');
			}else{
				$titre = ucfirst($this->titre);
			}
		}

		$image_url = $this->icon;

		$diam = 2*$this->r;
		$diam_bubble = $diam+2*$this->border;
		$diam_bubble_demi = $diam_bubble*0.5;
		$diam_bubble_demi_plus = $diam_bubble_demi + 4;

		echo '<div id="b'.$this->id.'" class="bubbles_wrap';
		if($this->titre == Auth::user_id()){echo ' ma_bulle';}
		echo '" style="left:'.$this->view_x.'px;bottom:'.$this->view_y.'px;">';

		echo '<div class="bubbles" style="height:'.$diam_bubble.'px;width:'.$diam_bubble.'px;background-color:#'.$this->color.';';
		if($this->type == 'pays' OR $this->type == 'astre'){echo 'border-style:solid;border-color:rgba(100,100,100,1);';}
		echo '">';

		if($this->type == 'pays'){
			echo '<div class="'.strtolower($image_url).'" style="width:'.$diam.'px;height:'.$diam.'px;background-size: '.$diam.'px '.$diam.'px;opacity:0.5;filter:alpha(opacity=50);"></div>';
		}
		elseif($this->type == 'activite'){
			echo '<div class="'.strtolower($image_url).'" style="width:'.$diam.'px;height:'.$diam.'px;background-size: '.$diam.'px '.$diam.'px;"></div>';
		}
		elseif($this->type == 'astre'){
			if(file_exists('./images/avatar/astre/'.strtolower($image_url).'.png')){
				echo '<img src="./images/avatar/astre/'.strtolower($image_url).'.png" width="'.$diam.'" height="'.$diam.'" style="opacity:0.5;filter:alpha(opacity=50);"/>';
			}
		}
		else{
			echo '<div class="'.$this->type.'" style="width:'.$diam.'px;height:'.$diam.'px;background-size: '.$diam.'px '.$diam.'px;"></div>';
		}
		
		echo '</div>';

		/*echo '<div class="info"><div class="titre">'.$titre.'</div>';
		if(file_exists('./images/bubbles/'.$image_url.'.jpg')){ 
			echo '<div class="image"><img src="./images/bubbles/'.$image_url.'.jpg" width="100"/></div>';}
		if(($this->type == 'humain-homme' OR $this->type == 'humain-femme') && ($this->facebook!='' OR $this->twitter!='' OR $this->youtube!='')){		
			echo '<div class="liens">Mes liens : ';
			
			if($this->facebook!=''){ 
				echo '<a target="_blank" href="https://www.facebook.com/'.$this->facebook.'"><img width="16" height="16" src="./images/f_icon.png"></img></a>';
			}

			if($this->twitter!=''){ 
				echo '<a target="_blank" href="https://twitter.com/'.$this->twitter.'"><img width="16" height="16" src="./images/t_icon.png"></img></a>';
			}

			if($this->youtube!=''){
				echo'<a target="_blank" href="https://www.youtube.com/channel/'.$this->youtube.'"><img width="16" height="16" src="./images/y_icon.png"></img></a>';
			}

			echo '</div>';
		}
		echo 	'<div class="info_close">';
		echo		'<ul>';
		echo			'<li>';
		echo				'<a class="btn btn-lock" title="Bloquer la caméra sur cette bulle">';
		echo  					'<span class="glyphicon glyphicon-lock"></span>';
		echo				'</a>';
		echo			'</li>';
		echo			'<li>';
		echo				'<a class="btn btn-center" title="Centre la caméra sur cette bulle">';
		echo  					'<span class="glyphicon glyphicon-eye-open"></span>';
		echo				'</a>';
		echo			'</li>';
		if($this->type != 'humain-homme' && $this->type != 'humain-femme' && $this->type != 'web' && url_exists('http://fr.wikipedia.org/wiki/'.$this->titre)){
			echo		'<li>';	
			echo			'<a class="btn btn-wiki" title="Lien Wikipédia" target="_blank" href="http://fr.wikipedia.org/wiki/'.$this->titre.'">';
		  	echo				'<span class="glyphicon glyphicon-info-sign"></span>';
			echo			'</a>';
			echo		'</li>';
		}
		// Pour rajouter un lien vers le site cité :
		if(false && $this->type == 'web' && url_exists('http://'.$this->titre)){
			echo		'<li>';	
			echo			'<a class="btn btn-wiki" title="Lien vers le site" target="_blank" href="http://'.$this->titre.'">';
		  	echo				'<span class="glyphicon glyphicon-info-sign"></span>';
			echo			'</a>';
			echo		'</li>';
		}
		echo		'<li>';
		echo			'<a class="btn btn-close" title="Fermer">';
	  	echo				'<span class="glyphicon glyphicon-remove"></span>';
		echo			'</a>';
		echo		'</li>';
		echo	'</ul>';
		echo '</div>';*/

		echo 	'<div class="info_bulle" style="background-color:'.$this->color.';bottom:-'.$diam_bubble.'px;left:'.$diam_bubble_demi.'px;padding-left:'.$diam_bubble_demi_plus.'px;">'.$titre;
		if($this->type != 'humain-homme' && $this->type != 'humain-femme'){
			if(url_exists('http://fr.wikipedia.org/wiki/'.$this->titre)){
				echo 	'<a title="Lien Wikipédia" target="_blank" href="http://fr.wikipedia.org/wiki/'.$this->titre.'">';
				echo 		'<span class="glyphicon glyphicon-info-sign"></span>';
				echo 	'</a>';
			}
			
			if(Auth::is_connected()){
				echo 	'<a title="Signaler cette bulle" href="javascript:void(0)" onclick="signalement('.$this->id.');">';
				echo 		'<span class="glyphicon glyphicon-exclamation-sign"></span>';
				echo 	'</a>';
			}
		}
	
		echo 	'</div>';
		echo '</div>';
	}

	// Rend le code html pour dessiner la partie d'informations sur les bulles :
	public function render_info(){
		echo 	'<div id="info'.$this->id.'" class="info_physics">';
  		echo		'<span>';
  		echo			'Position : '.round($this->x,0).' , '.round($this->y,0).'<br>';
  		echo			'Vitesse : '.round($this->vx,1).' , '.round($this->vy,1);
  		echo		'</span>';
		echo	'</div>';
	}

	// Rend la distance entre deux bulles :
	public static function distance(Bubble $b1,Bubble $b2){
		return sqrt(pow($b1->get_x()-$b2->get_x(),2)+pow($b1->get_y()-$b2->get_y(),2));
	}


	// Rend la distance entre deux bulles moins leurs rayons :
	public static function distance_inter(Bubble $b1,Bubble $b2){
		return self::distance($b1,$b2)-($b1->get_r())-($b2->get_r());
	}


	// Rend la couleur de l'ombre représentant la température :
	public static function get_shadow_color(){
		return $shadow_color = min(round($this->get_Ec()),255);
	}

	// Rend l'opacité' de l'ombre représentant la température :
	public static function get_shadow_opacity(){
		return $shadow_opacity = min(round($this->get_Ec()/500,2),1);
	}


	// Rend l'intensité de -100 à 100 d'une liaison entre deux bulles :
	public static function lien_intensite(Bubble $b1,Bubble $b2){
		$id1 = $b1->get_id();
		$id2 = $b2->get_id();
		$liens_1 = MySQL::select_data('liens',array('intensite'),'id_bubble_1="'.$id1.'" AND id_bubble_2="'.$id2.'"');
		$liens_2 = MySQL::select_data('liens',array('intensite'),'id_bubble_1="'.$id2.'" AND id_bubble_2="'.$id1.'"');

		// Initialisation :
		$compteur = 0;
		$intensite = 0;

		// Boucles pour faire la moyenne de l'intensité des liens :
		foreach ($liens_1 as $lien_1) {
			$intensite += $lien_1['intensite'];
			$compteur++;
		}
		foreach ($liens_2 as $lien_2) {
			$intensite += $lien_2['intensite'];
			$compteur++;
		}

		return $intensite/$compteur;
	}


	// Rend la valeur de x :
	public function get_x(){
		return $this->x;
	}


	// Rend la valeur de y :
	public function get_y(){
		return $this->y;
	}


	// Rend la valeur de position :
	public function get_pos(){
		return array($this->x,$this->y);
	}


	// Rend la valeur de view_x :
	public function get_view_x(){
		return $this->view_x;
	}


	// Rend la valeur de view_y :
	public function get_view_y(){
		return $this->view_y;
	}


	// Rend la valeur de r :
	public function get_r(){
		return $this->r;
	}


	// Rend la valeur de mass :
	public function get_mass(){
		return $this->mass;
	}


	// Rend la valeur de l'énergie cinétique de la bulle :
	public function get_Ec(){
		return 0.5*sqrt(pow($this->vx,2)+pow($this->vy,2))*$this->mass;
	}


	// Rend la valeur de vx :
	public function get_vx(){
		return $this->vx;
	}


	// Rend la valeur de vy :
	public function get_vy(){
		return $this->vy;
	}


	// Rend la valeur de v :
	public function get_v(){
		return array($this->vx,$this->vy);
	}


	// Rend la valeur de ax :
	public function get_ax(){
		return $this->ax;
	}


	// Rend la valeur de ay :
	public function get_ay(){
		return $this->ay;
	}


	// Rend la valeur de a :
	public function get_a(){
		return array($this->ax,$this->ay);
	}


	// Rend la valeur de fx :
	public function get_fx(){
		return $this->fx;
	}


	// Rend la valeur de fy :
	public function get_fy(){
		return $this->fy;
	}


	// Rend la valeur de f :
	public function get_f(){
		return array($this->fx,$this->fy);
	}


	// Rend la valeur de id :
	public function get_id(){
		return $this->id;
	}


		// Rend la valeur de x :
	public function set_x($x){
		$this->x = $x;
		MySQL::update_data('bubbles',array('x'),array($x),'id='.$this->get_id());
	}


	// Rend la valeur de y :
	public function set_y($y){
		$this->y = $y;
		MySQL::update_data('bubbles',array('y'),array($y),'id='.$this->get_id());
	}


	// Rend la valeur de position :
	public function set_pos($x,$y){
		$this->x = $x;
		$this->y = $y;
		MySQL::update_data('bubbles',array('x','y'),array($x,$y),'id='.$this->get_id());
	}


	// Rend la valeur de r :
	public function set_r($r){
		$this->r = $r;
	}


	// Rend la valeur de mass :
	public function set_mass($mass){
		$this->mass = $mass;
	}


	// Rend la valeur de vx :
	public function set_vx($vx){
		$this->vx = $vx;
		MySQL::update_data('bubbles',array('vx'),array($vx),'id='.$this->get_id());
	}


	// Rend la valeur de vy :
	public function set_vy($vy){
		$this->vy = $vy;
		MySQL::update_data('bubbles',array('vy'),array($vy),'id='.$this->get_id());
	}

	// Rend la valeur de v :
	public function set_v($vx,$vy){
		$this->vx = $vx;
		$this->vy = $vy;
		MySQL::update_data('bubbles',array('vx','vy'),array($vx,$vy),'id='.$this->get_id());
	}


	// Rend la valeur de ax :
	public function set_ax($ax){
		$this->ax = $ax;
	}


	// Rend la valeur de ay :
	public function set_ay($ay){
		$this->ay = $ay;
	}

	// Rend la valeur de a :
	public function set_a($ax,$ay){
		$this->ax = $ax;
		$this->ay = $ay;
	}


	// Rend la valeur de fx :
	public function set_fx($fx){
		$this->fx = $fx;
	}


	// Rend la valeur de fy :
	public function set_fy($fy){
		$this->fy = $fy;
	}


	// Rend la valeur de f :
	public function set_f($fx,$fy){
		$this->fx = $fx;
		$this->fy = $fy;
	}

}