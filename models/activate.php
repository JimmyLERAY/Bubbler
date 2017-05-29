<?php

// Chargement des prérequis à toute requête :
require '../models/required.php';

if(isset($_POST) && !empty($_POST['activatetoken'])){
  extract($_POST);
  $token = $activatetoken;

  // On vérifie dans la bdd si un utilisateur avec cette clé existe :
  if(MySQL::count_data('users','token="'.$token.'"')==1){

    // On vérifie si le compte est déjà activé ou non :
    $res = MySQL::select_data('users',array('activated','email','id','sexe'),'token="'.$token.'"');

    $activated = $res[0]['activated'];
    $email = $res[0]['email'];
    $id = 'u-'.$res[0]['id'];
    $sexe = $res[0]['sexe'];

    if($activated){
      // Si le compte est déja activé :
      echo 'already_activated';
    }else{
      // Sinon on l'active :
      MySQL::update_data('users',array('activated'),array('1'),'token="'.$token.'"');
      // Puis on crée la bulle correspondant au compte courant :
      if($sexe == 'masculin'){
        MySQL::insert_data('bubbles',array('type','titre','x','y'),array('humain-homme',$id,rand_position(),rand_position()));
      }elseif($sexe == 'feminin'){
        MySQL::insert_data('bubbles',array('type','titre','x','y'),array('humain-femme',$id,rand_position(),rand_position()));
      }
      // On envoit le mail précisant que le compte est bien activé :
      require '../mails/activation.php';
      echo 'success';
    }
  }else{
    // Si le compte n'existe pas c'est que la clé est mauvaise :
    echo 'wrong_key';
  }
}
