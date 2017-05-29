<?php

class Constructor{


	// Charge le fichier pour créer la page :
	public static function init(){
		MySQL::init();
		Request::init();

		// Ajout des fonctions PHP :
		require './models/functions.php';
		require './models/security.php';

		// Création de la page :
		require './layouts/main.php';
	}

}