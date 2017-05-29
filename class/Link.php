<?php

class Link{

	private $id;
	private $b1;
	private $b2;
	private $l;
	private $l_inter;
	private $x;
	private $y;
	private $dx;
	private $dy;
	private $angle_rad;
	private $angle_deg;
	private $intensite;


	// Constructeur :
	public function __construct($b1,$b2){
		$this->b1 = $b1;
		$this->b2 = $b2;

		$this->id = $b1->get_id().'-'.$b2->get_id();

		$this->l = round(Bubble::distance($this->b1,$this->b2),3);
		$this->l_inter = Bubble::distance_inter($this->b1,$this->b2);

		$this->x = round($this->b1->get_x(),3);
		$this->y = round($this->b1->get_y(),3);

		$this->dx = $this->b2->get_x() - $this->b1->get_x();
		$this->dy = $this->b2->get_y() - $this->b1->get_y();


		if($this->b2->get_y() < $this->b1->get_y()){
			$this->angle_rad = round(acos($this->dx/$this->l),3);
		}else{
			$this->angle_rad = round(-acos($this->dx/$this->l),3);
		}
		$this->angle_deg = round($this->angle_rad*180/pi(),3);

		$links_1 = MySQL::select_data('liens',array('intensite'),'id_bubble_1="'.$this->b1->get_id().'" AND id_bubble_2="'.$this->b2->get_id().'"');
		$links_2 = MySQL::select_data('liens',array('intensite'),'id_bubble_1="'.$this->b2->get_id().'" AND id_bubble_2="'.$this->b1->get_id().'"');
	
		$nb_link = 0;
		$somme_intensite = 0;
		foreach ($links_1 as $link){
			$somme_intensite += $link['intensite'];
			$nb_link++;
		}
		foreach ($links_2 as $link){
			$somme_intensite += $link['intensite'];
			$nb_link++;
		}

		$this->intensite = $somme_intensite/$nb_link;
	}


	// Rend le code html pour dessiner un lien :
	public function render(){
		echo '<div id="l'.$this->id.'" class="links" data="'.$this->intensite.'" ';
		echo 'style="';
		if($this->intensite<0){echo 'border-style:dashed;';}
		echo'left:'.$this->x.'px; bottom:'.$this->y.'px; width:'.$this->l.'px; -ms-transform: rotate('.$this->angle_deg.'deg); -webkit-transform: rotate('.$this->angle_deg.'deg); transform: rotate('.$this->angle_deg.'deg);"></div>';
	}

	// Rend les données de l'objet sous format JSON :
	public function get_JSON(){
		$text = '{';
		$text .= '"id":"'.$this->id.'",';
		$text .= '"b1":"'.$this->b1->get_id().'",';
		$text .= '"b2":"'.$this->b2->get_id().'",';
		$text .= '"l":"'.$this->l.'",';
		$text .= '"x":"'.$this->x.'",';
		$text .= '"y":"'.$this->y.'",';
		$text .= '"dx":"'.$this->dx.'",';
		$text .= '"dy":"'.$this->dy.'",';
		$text .= '"angle_rad":"'.$this->angle_rad.'",';
		$text .= '"angle_deg":"'.$this->angle_deg.'",';
		$text .= '"intensite":'.$this->intensite.',';

		// On supprime la virgule en trop et on ferme l'objet :
		$text = substr($text,0,-1);
		$text .= '}';

		return $text;
	}


	// Rend la valeur de x :
	public function get_x(){
		return $this->x;
	}


	// Rend la valeur de y :
	public function get_y(){
		return $this->y;
	}


	// Rend la valeur de l :
	public function get_l(){
		return $this->l;
	}


	// Rend la valeur de angle_deg :
	public function get_angle_deg(){
		return $this->angle_deg;
	}

}