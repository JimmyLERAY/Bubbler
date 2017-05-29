<?php

// On va concatener les différents fichiers du dossier spécifié,
// on précise que l'on souhaite écrire un fichier d'un type particulier :
$path = "./css/";
header("Content-Type:text/css;");


// Si on arrive à bien ouvrir le dossier :
if($dossier = opendir($path)){

	// On parcourt tous les fichiers du dossier :
	while(false !== ($file = readdir($dossier))){

		// Si les fichiers existent bien on les concatène
		if(file_exists($path.$file) && $file != "icon.css"){
			echo file_get_contents($path.$file);
		}
	}
	
	// On ferme le dossier :
	closedir($dossier);
}
