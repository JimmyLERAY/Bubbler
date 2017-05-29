<?php

// Chargement des prérequis à toute requête :
require '../models/required.php';

//---------------------------------------------------------------//
// Ajout d'un nouveau lien et éventuellement de nouvelles bulles //
//---------------------------------------------------------------//

if(isset($_POST) && isset($_POST['bulle1']) && isset($_POST['bulle2']) && isset($_POST['intensite']) && isset($_POST['token'])){

	$token = $_POST['token'];

	// On vérifie si l'utilisateur existe bien :
	if(MySQL::count_data('users','token="'.$token.'"') == 1){

		// On récupère l'id de l'utilisateur à partir de son token :
		$res = MySQL::select_data('users',array('id'),'token=\''.$token.'\'');
		$user = $res[0]['id'];

		// On récupère le titre des bulles à relier :
		$bubble1 = mb_ucfirst($_POST['bulle1'],"UTF-8");
		$bubble2 = mb_ucfirst($_POST['bulle2'],"UTF-8");

		// On vérifie si les bulles existent déjà ou non :
		if(MySQL::count_data('bubbles','titre=\''.$bubble1.'\'')==0 && MySQL::count_data('users','pseudo=\''.$bubble1.'\'')==0){
			// Si la bulle n'existe pas on la crée :
			MySQL::insert_data('bubbles',array('titre','type','x','y','vx','vy'),array($bubble1,'concept',rand_position(),rand_position(),0,0));
			$type1 = 'concept';
		}else{
			// Sinon on récupère le type de la bulle qui existe déjà :
			if(MySQL::count_data('bubbles','titre=\''.$bubble1.'\'')==0){
				$res1 = MySQL::select_data('users',array('sexe'),'pseudo=\''.$bubble1.'\'');
				$sexe = $res1[0]['sexe'];
				if($sexe == 'masculin'){$type1 = 'humain-homme';}
				else{$type1 = 'humain-femme';}
			}else{
				$res1 = MySQL::select_data('bubbles',array('type'),'titre=\''.$bubble1.'\'');
				$type1 = $res1[0]['type'];
			}
		}

		if(MySQL::count_data('bubbles','titre=\''.$bubble2.'\'')==0 && MySQL::count_data('users','pseudo=\''.$bubble2.'\'')==0){
			// Si la bulle n'existe pas on la crée :
			MySQL::insert_data('bubbles',array('titre','type','x','y','vx','vy'),array($bubble2,'concept',rand_position(),rand_position(),0,0));
			$type2 = 'concept';
		}else{
			// Sinon on récupère le type de la bulle qui existe déjà :
			if(MySQL::count_data('bubbles','titre=\''.$bubble2.'\'')==0){
				$res2 = MySQL::select_data('users',array('sexe'),'pseudo=\''.$bubble2.'\'');
				$sexe = $res2[0]['sexe'];
				if($sexe == 'masculin'){$type2 = 'humain-homme';}
				else{$type2 = 'humain-femme';}
			}else{
				$res2 = MySQL::select_data('bubbles',array('type'),'titre=\''.$bubble2.'\'');
				$type2 = $res2[0]['type'];
			}
		}


		// On récupère l'id des bulles :
		if($type1!='humain-homme' && $type1!='humain-femme'){
			$res1 = MySQL::select_data('bubbles',array('id'),'titre=\''.$bubble1.'\'');
			$id1 = $res1[0]['id'];
		}else{
			// Si il s'agit d'une personne on vérifie qu'il s'agit de l'utilisateur :
			$res = MySQL::select_data('users',array('pseudo'),'token=\''.$token.'\'');
			$pseudo = $res[0]['pseudo'];

			if($pseudo == $bubble1){
				// la personne est bien l'utilisateur on fait donc le lien :
				$res1 = MySQL::select_data('bubbles',array('id'),'titre=\'u-'.$user.'\'');
				$id1 = $res1[0]['id'];
			}else{
				// la personne n'est pas l'utilisateur, on arrête et alerte :
				echo 'not_allowed';
				exit();
			}
		}

		if($type2!='humain-homme' && $type2!='humain-femme'){
			$res2 = MySQL::select_data('bubbles',array('id'),'titre=\''.$bubble2.'\'');
			$id2 = $res2[0]['id'];
		}else{
			// Si il s'agit d'une personne on vérifie qu'il s'agit de l'utilisateur :
			$res = MySQL::select_data('users',array('pseudo'),'token=\''.$token.'\'');
			$pseudo = $res[0]['pseudo'];

			if($pseudo == $bubble2){
				// la personne est bien l'utilisateur on fait donc le lien :
				$res2 = MySQL::select_data('bubbles',array('id'),'titre=\'u-'.$user.'\'');
				$id2 = $res2[0]['id'];
			}else{
				// la personne n'est pas l'utilisateur, on arrête et alerte :
				echo 'not_allowed';
				exit();
			}
		}

		// On crée le lien entre les deux bulles si il n'existe pas :
		if($bubble1 != $bubble2){
			if(MySQL::count_data('liens','id_user="'.$user.'" AND id_bubble_1="'.$id1.'" AND id_bubble_2="'.$id2.'"') == 0 && MySQL::count_data('liens','id_user="'.$user.'" AND id_bubble_1="'.$id2.'" AND id_bubble_2="'.$id1.'"') == 0){
			  
			  $intensite = $_POST['intensite'];
			  if($intensite == 'attraction'){$intensite = 100;}
			  else if($intensite == 'repulsion'){$intensite = -100;}
			  else{exit();}

			  MySQL::insert_data('liens',array('id_user','id_bubble_1','id_bubble_2','intensite'),array($user,$id1,$id2,$intensite));
			  echo 'add';
			}else{
			  echo 'already';
			}
		}
	}else{
		echo 'not_register';
	}
}