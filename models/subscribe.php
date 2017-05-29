<?php

// Chargement des prérequis à toute requête :
require '../models/required.php';

if(isset($_POST) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['sexe'])){
  extract($_POST);
  $pass = sha1($pass);

  if(MySQL::count_data('users','pseudo="'.$pseudo.'" AND email="'.$email.'" AND pass="'.$pass.'" AND activated="0"')==1){
    // Ce compte existe mais n'est pas activé :
    echo 'unactive';
  }
  else if(MySQL::count_data('users','email="'.$email.'"')==1){
    // Si il y'a déjà un utilisateur avec cet email :
    echo 'wrong_email';
  }else if(MySQL::count_data('users','pseudo="'.$pseudo.'"')==1){
    // Si il y'a déjà un utilisateur avec ce pseudo :
    echo 'wrong_pseudo';
  }else{
    // Sinon on inscrit l'utilisateur sans l'activer :
    $token = sha1(uniqid()); // génération de la clé d'activation
    MySQL::insert_data('users',array('pseudo','token','email','pass','sexe'),array($pseudo,$token,$email,$pass,$sexe));
    // On envoit un mail pour signifier l'inscription avec la clé :
    require '../mails/inscription.php';
    echo 'subscribed';
  }
}