<?php

class Force{


	// Ajoute une force gravitationelle vers l'origine à une bulle :
	public static function gravite($bulle){
		$alpha = 0.05; // constante gravitationelle

		$bulle->set_f($bulle->get_fx() - $alpha*$bulle->get_x(),
					$bulle->get_fy() - $alpha*$bulle->get_y());
	}


	// Ajoute une force de frottement fluide :
	public static function frottement($bulle){
		$beta = 2; // constante de frottements
		$bulle->set_f($bulle->get_fx() - $beta*$bulle->get_vx(),
					$bulle->get_fy() - $beta*$bulle->get_vy());
	}


	// Ajoute une force de répulsion entre deux bulles :
	public static function repulsion($b1,$b2){
		$phi = 10000; // constante de répulsion

		$distance = Bubble::distance($b1,$b2);

		// Protection pour éviter la division par 0 :
		if($distance == 0){$distance = 100; $dx = lcg_value()-0.5;	$dy = lcg_value()-0.5;}
		else{
			$dx = ($b2->get_x() - $b1->get_x())/$distance;
			$dy = ($b2->get_y() - $b1->get_y())/$distance;
		}

		$b1->set_f($b1->get_fx() - 0.5*$dx*$phi/$distance,
					$b1->get_fy() - 0.5*$dy*$phi/$distance);

		$b2->set_f($b2->get_fx() + 0.5*$dx*$phi/$distance,
					$b2->get_fy() + 0.5*$dy*$phi/$distance);
	}


	// Ajoute une force de répulsion entre deux bulles :
	public static function attraction($b1,$b2){
		$tetaA = 2; // constante d'attraction
		$tetaR = 500; // constante de répulsion

		$distance = Bubble::distance($b1,$b2);
		$intensite = Bubble::lien_intensite($b1,$b2)/100;

		// Protection pour éviter la division par 0 :
		if($distance == 0){$distance = 100; $dx = lcg_value()-0.5;	$dy = lcg_value()-0.5;}
		else{
			$dx = ($b2->get_x() - $b1->get_x())/$distance;
			$dy = ($b2->get_y() - $b1->get_y())/$distance;
		}

		// Différente fonction suivant le type de lien :
		if($intensite>=0){
			$b1->set_f($b1->get_fx() + 0.5*$intensite*$dx*$tetaA*$distance,
					$b1->get_fy() + 0.5*$intensite*$dy*$tetaA*$distance);

			$b2->set_f($b2->get_fx() - 0.5*$intensite*$dx*$tetaA*$distance,
					$b2->get_fy() - 0.5*$intensite*$dy*$tetaA*$distance);
		}elseif($intensite<0){
			$b1->set_f($b1->get_fx() + 0.5*$intensite*$dx*$tetaR/sqrt($distance),
					$b1->get_fy() + 0.5*$intensite*$dy*$tetaR/sqrt($distance));

			$b2->set_f($b2->get_fx() - 0.5*$intensite*$dx*$tetaR/sqrt($distance),
					$b2->get_fy() - 0.5*$intensite*$dy*$tetaR/sqrt($distance));
		}

	}

}