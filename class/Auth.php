<?php

class Auth{


	// Renvoit si l'utilisateur est connecte ou non
	static function is_connected(){
		if(isset($_SESSION['Auth']['email']) && isset($_SESSION['Auth']['pass']))
			{return true;}else{return false;}
	}


	// Renvoit si l'utilisateur est un administrateur ou non
	static function is_admin(){
		if(self::is_connected()){
			if($_SESSION['Auth']['type'] == 'admin')
				{return true;}else{return false;}
		}else{return false;}
	}


	// Renvoit si la page courante est privée ou non
	static function is_private(){
		$url_title = Request::get_page();
		$res = MySQL::select_data('pages',array('is_private'),'url_title="'.$url_title.'"');
		if(isset($res[0]['is_private'])){
			return $res[0]['is_private'];
		}else{return true;}
	}


	// Renvoit si la page courante est une page admin ou non
	static function is_admin_private(){
		$url_title = Request::get_page();
		if($url_title == 'admin' OR $url_title == 'serveur'){
			return true;
		}else{return false;}
	}


	// Renvoit l'id de l'utilisateur connecté
	static function user_id(){
		if(self::is_connected()){
			$res = MySQL::select_data('users',array('id'),'email="'.$_SESSION['Auth']['email'].'"');
			return $res[0]['id'];
		}else{return false;}
	}

	// Renvoit le token de l'utilisateur connecté
	static function user_token(){
		if(self::is_connected()){
			$res = MySQL::select_data('users',array('token'),'email="'.$_SESSION['Auth']['email'].'"');
			return $res[0]['token'];
		}else{return false;}
	}

}