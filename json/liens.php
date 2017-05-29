<?php

// Chargement des prérequis à toute requête JSON :
require 'required.php';

// On récupère les id de toutes les bulles :
$links = MySQL::select_data('liens',array('id'),'');

// Initialisation de la réponse :
$reponse = '[';

$bubbles = MySQL::select_data('bubbles',array('id','type','titre'),'');

foreach ($bubbles as $bubble){
	$id = $bubble['id'];
	$links = MySQL::select_data('liens',array('id_bubble_1','id_bubble_2'),'id_bubble_1="'.$id.'" OR id_bubble_2="'.$id.'"');
	
	foreach ($links as $link){
		$id1 = $link['id_bubble_1'];
		$id2 = $link['id_bubble_2'];
		if(!isset(${'L'.$id1.'-'.$id2}) && !isset(${'L'.$id2.'-'.$id1})){
			if(!isset(${'B'.$id1})){${'B'.$id1} = new Bubble($id1);}
			if(!isset(${'B'.$id2})){${'B'.$id2} = new Bubble($id2);}
			${'L'.$id1.'-'.$id2} = new Link(${'B'.$id1},${'B'.$id2});
			$reponse .= ${'L'.$id1.'-'.$id2}->get_JSON().',';
		}
	}
}

// On supprime la dernière virgule en trop et on ferme le crochet:
$reponse = substr($reponse,0,-1);
$reponse .= ']';

// On ouvre le fichier pour enregistrer les données :
$file = fopen('links.json', 'w');

// On écrit dans le fichier :
fwrite($file,$reponse);

// On ferme le fichier :
fclose($file);