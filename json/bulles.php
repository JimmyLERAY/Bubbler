<?php

// Chargement des prérequis à toute requête JSON :
require 'required.php';

// On récupère les id de toutes les bulles :
$bubbles = MySQL::select_data('bubbles',array('id'),'');

// Initialisation de la réponse :
$reponse = '[';

foreach ($bubbles as $bubble) {
	// Création des bulles en utilisant la classe PHP :
	$bulle = new Bubble($bubble['id']);
	$bulle->init_plus();

	// Concatenation des données de chaque bulle en JSON :
	$reponse .= $bulle->get_JSON().',';
}

// On supprime la dernière virgule en trop et on ferme le crochet:
$reponse = substr($reponse,0,-1);
$reponse .= ']';

// On ouvre le fichier pour enregistrer les données :
$file = fopen('bubbles.json', 'w');

// On écrit dans le fichier :
fwrite($file,$reponse);

// On ferme le fichier :
fclose($file);