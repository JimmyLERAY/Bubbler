<?php

// Chargement des prérequis à toute requête :
require '../models/required.php';

if(isset($_POST) && !empty($_POST['email']) && !empty($_POST['pass'])){
  extract($_POST);
  $pass = sha1($pass);
  if(MySQL::count_data('users','email="'.$email.'" AND pass="'.$pass.'" AND activated="1"')==1){
    // Dans ce cas on connecte l'utilisateur, en envoyant le token de l'utilisateur :
    $res = MySQL::select_data('users',array('token,pseudo,id'),'email="'.$email.'" AND pass="'.$pass.'"');
    $temp = MySQL::select_data('bubbles',array('id'),'titre="u-'.$res[0]['id'].'"');
    echo $res[0]['token'].'/'.$res[0]['pseudo'].'/'.$temp[0]['id'];
  }elseif(MySQL::count_data('users','email="'.$email.'" AND pass="'.$pass.'"')==1){
    // le compte n'est pas encore activé :
    echo 'unactive';
  }else{
    // mauvais identifiants :
    echo 'wrong';
  }
}
