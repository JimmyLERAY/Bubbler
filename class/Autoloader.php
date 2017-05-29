<?php

class Autoloader{


	// Initialise et enregistre l'autoloader :
	public static function start(){
		if(!spl_autoload_register(array(__CLASS__,'autoload')))
		{echo 'Autoloader : Echec de l\'initialisation !!</br>';}
	}


	// Charge une classe automatiquement :
	private static function autoload($class){
		$file_url = '/class/'.$class.'.php';
		if(file_exists('.'.$file_url)){require '.'.$file_url;}
		elseif(file_exists('..'.$file_url)){require '..'.$file_url;}
		else{echo 'Autoloader : La classe '.$class.' est introuvable !</br>';}
	}

}