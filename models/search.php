<?php

// Chargement des prérequis à toute requête :
require '../models/required.php';

// Recherche de l'id correspondant au titre recherché :
$search = $_GET['s'];

if(MySQL::count_data('bubbles','titre="'.$search.'"')!=0){
	$bubbles = MySQL::select_data('bubbles',array('id'),'titre="'.$search.'"');
	$id = $bubbles[0]['id'];
	echo $id;
}else{
	if(MySQL::count_data('users','pseudo="'.$search.'"')!=0){
		$humains = MySQL::select_data('users',array('id'),'pseudo="'.$search.'"');
		$bubbles = MySQL::select_data('bubbles',array('id'),'titre="u-'.$humains[0]['id'].'"');
		$id = $bubbles[0]['id'];
		echo $id;
	}else{
		echo 'none';
	}
}
