<?php

// On va concatener les différents fichiers du dossier spécifié,
// on précise que l'on souhaite écrire un fichier d'un type particulier :
header("Content-Type:text/javascript;");

$path = "./scripts/";
// Si on arrive à bien ouvrir le dossier des scripts Javascripts :
if($dossier = opendir($path)){

	// On parcourt tous les fichiers du dossier :
	while(false !== ($file = readdir($dossier))){

		// Si les fichiers existent bien on les concatène :
		if(file_exists($path.$file)){

			// Condition pour exclure les fichiers non-minifiés JS :
			if(strpos($file,'.min.')){
				echo file_get_contents($path.$file);
			}
			else if($file == "autocomplete.php"){
				// Condition pour inclure le fichier de type PHP :
				require($path.$file);
			}
		}
	}

	// On ferme le dossier :
	closedir($dossier);
}


// On refait la même chose mais pour le dossier des controleurs :
$path = "./controls/";

// Si on arrive à bien ouvrir le dossier :
if($dossier = opendir($path)){

	// On parcourt tous les fichiers du dossier :
	while(false !== ($file = readdir($dossier))){

		// Si les fichiers existent bien on les concatène :
		if(file_exists($path.$file)){

			// Condition pour exclure les fichiers non-minifiés JS :
			if(strpos($file,'.min.')){
				echo file_get_contents($path.$file);
			}
		}
	}

	// On ferme le dossier :
	closedir($dossier);
}


// On refait la même chose mais pour le dossier des directives :
$path = "./directives/";

// Si on arrive à bien ouvrir le dossier :
if($dossier = opendir($path)){

	// On parcourt tous les fichiers du dossier :
	while(false !== ($file = readdir($dossier))){

		// Si les fichiers existent bien on les concatène :
		if(file_exists($path.$file)){

			// Condition pour exclure les fichiers non-minifiés JS :
			if(strpos($file,'.min.')){
				echo file_get_contents($path.$file);
			}
		}
	}

	// On ferme le dossier :
	closedir($dossier);
}