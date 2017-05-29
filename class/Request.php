<?php

class Request{

	private static $query;
	private static $page;

	// Retourne la query (ne doit etre appelee qu'une seule fois)
	public static function init(){
		$query = $_SERVER['QUERY_STRING'];
		parse_str($query);
		if(!isset($p)){
			if($query==''){$p = 'accueil'; $query = 'p='.$p;}
			else{$p = 'erreur'; $query = 'p='.$p;}
		}
		self::$query = $query;
		self::$page = $p;
	}

	public static function get_page(){
		return self::$page;
	}

}