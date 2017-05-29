<?php

// Chargement de la classe MySQL
require '../class/MySQL.php';
MySQL::init();

//-----------------------------------------------------------//
// Traitement et récupération du nombre de visiteurs actuels //
//-----------------------------------------------------------//

// On supprime les ip qui n'ont pas été mise à jour récemment :
$timestamp_10s = time()-10;
MySQL::delete_data('visiteurs','timestamp < '.$timestamp_10s);


// Insertion de l'ip du visiteur et on met à jour son timestamp :
if(MySQL::count_data('visiteurs','ip=\''.$_SERVER['REMOTE_ADDR'].'\'')==0){
	MySQL::insert_data('visiteurs',array('ip','timestamp'),array($_SERVER['REMOTE_ADDR'],time()));
}
else{
	MySQL::update_data('visiteurs',array('timestamp'),array(time()),'ip=\''.$_SERVER['REMOTE_ADDR'].'\'');
}

// On renvoit le nombre de connectés actuels :
$nombre = MySQL::count_data('visiteurs','');

// Envoit des données à l'utilisateur :
echo $nombre.' ';