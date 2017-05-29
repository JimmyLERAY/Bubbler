<?php

// Chargement automatique des classes PHP :
require '../class/Autoloader.php';
Autoloader::start();

// Initialisation de la classe MySQL
MySQL::init();

// Chargement des fonctions :
require '../models/functions.php';

// On met à jour la bdd si le serveur est coupé depuis longtemps :
$timestamp_60s = time()-60*5;
MySQL::update_data('serveur',array('statut'),array(0),'timestamp < '.$timestamp_60s);

// On regarde si le serveur est déjà lancé :
$serveur = MySQL::select_data('serveur',array('statut'),'');

// Si le serveur n'est pas lancé :
if(!$serveur[0]['statut']){

	// On le lance :
	MySQL::update_data('serveur',array('statut'),array(1),'id="serveur"');

	while(true){

		// On vérifie que le serveur est toujours allumé :
		$statut = MySQL::select_data('serveur',array('statut'),'');

		if($statut[0]['statut']){

			// On lance le chronomètre :
			$delay_start = round(microtime(true)*1000);

			// On update le timer :
			MySQL::update_data('serveur',array('timestamp'),array(time()),'id="serveur"');


			//-------------------------------------------------//
			// Mise à jour des masses et des rayons des bulles //
			//-------------------------------------------------//

			$r_min = 12; // rayon minimum des bulles

			for ($id=1; $id <= nb_bubbles(); $id++){ 
				if(!isset(${'B'.$id})){${'B'.$id} = new Bubble($id);}
				$nb_links = MySQL::count_data('liens','id_bubble_1="'.$id.'" OR id_bubble_2="'.$id.'"');
				$links = MySQL::select_data('liens',array('id_bubble_1','id_bubble_2'),'id_bubble_1="'.$id.'" OR id_bubble_2="'.$id.'"');
				$mass = 0;
				for ($n=0; $n < $nb_links; $n++){ 
					$id1 = $links[$n]['id_bubble_1'];
					$id2 = $links[$n]['id_bubble_2'];
					if($id1 == $id){
						if(!isset(${'Ls'.$id1.'-'.$id2})){
							if(!isset(${'B'.$id1})){${'B'.$id1} = new Bubble($id1);}
							if(!isset(${'B'.$id2})){${'B'.$id2} = new Bubble($id2);}
							${'Ls'.$id1.'-'.$id2} = new Link(${'B'.$id1},${'B'.$id2});
							$mass += 1;
						}
					}elseif($id2 == $id){
						if(!isset(${'Ls'.$id2.'-'.$id1})){
							if(!isset(${'B'.$id1})){${'B'.$id1} = new Bubble($id1);}
							if(!isset(${'B'.$id2})){${'B'.$id2} = new Bubble($id2);}
							${'Ls'.$id2.'-'.$id1} = new Link(${'B'.$id2},${'B'.$id1});
							$mass += 1;
						}
					}
				}
				if($mass == 0){$mass = 1;} // Sécurité et pour les nouveaux comptes
				$r = $r_min*(1+log10(1+log10($mass)));
				MySQL::update_data('bubbles',array("mass","r"),array($mass,$r),'id="'.$id.'"');
			}
			require 'physics.php';

			// Suppresion des instances crées :
			for ($id=1; $id <= nb_bubbles(); $id++){ 
				unset(${'B'.$id});
				for ($idbis=1; $idbis <= nb_bubbles(); $idbis++){ 
					if(isset(${'Ls'.$id.'-'.$idbis})){unset(${'Ls'.$id.'-'.$idbis});}
					if(isset(${'Ls'.$idbis.'-'.$id})){unset(${'Ls'.$idbis.'-'.$id});}
				}
			}

			// On arrete le chronomètre :
			$delay_end = round(microtime(true)*1000);
			$delay = $delay_end - $delay_start;
			echo $delay;

			// On update le chronometre :
			MySQL::update_data('serveur',array('delay'),array($delay),'id="serveur"');
		}
		else{return false;} // Sinon on l'interrompt
	}
}
else{return false;} // Sinon on laisse tourner celui qui est déjà allumé