<?php

// Renvoit le titre de la page
function get_title(){
	$url_title = Request::get_page();
	$res = MySQL::select_data('pages',array('title'),'url_title="'.$url_title.'"');
	if(isset($res[0]['title'])){
		return $res[0]['title'];
	}else{return 'Erreur';}
}


// Renvoit le titre de la page en utilisant le titre de l'url
function get_title_from_url_title($url_title){
	$res = MySQL::select_data('pages',array('title'),'url_title="'.$url_title.'"');
	if(isset($res[0]['title'])){
		return $res[0]['title'];
	}else{return 'Erreur';}
}


// Vérifie si le titre de la page vaut $string
function is_title($string){
	if($string == get_title()){return true;}
	else{return false;}
}


// Vérifie si l'url_titre vaut $string
function is_url_title($string){
	$url_title = Request::get_page();
	if($string == $url_title){return true;}
	else{return false;}
}


// Renvoit le contenu HTML approprié
function get($content){
	if($content=='head'){require './layouts/head.php';}
	elseif($content=='navbar'){require './layouts/navbar.php';}
	elseif($content=='radial'){require './layouts/radial.php';}
	elseif($content=='info'){require './layouts/info.php';}
	elseif($content=='footer'){require './layouts/footer.php';}
	elseif($content=='scripts'){require './layouts/scripts.php';}
	elseif($content=='bubbles'){require './layouts/bubbles.php';}
	elseif($content=='zoom'){require './layouts/zoom.php';}
	elseif($content=='windows'){require './layouts/windows.php';}
	
	elseif($content=='content'){
		$url_title = Request::get_page();
		if(MySQL::count_data('pages','url_title="'.$url_title.'"')>0){
			require './pages/'.$url_title.'.php';
		}
	}
}


// Vérifie si une url existe ou non
function url_exists($url){
	if (!curl_init($url)){return false;}else{return true;}
}


// Renvoit une chaine de caractère sans les accents
function replace_accents($string){ 
    return str_replace( array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ','À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý'), array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y'), $string);
}


// Renvoit l'énergie cintétique totale :
function sum_kinetics(){ 
    $bubbles = MySQL::select_data('bubbles',array('id'),'');
	$sum_kinetics = 0;
	foreach($bubbles as $bubble){
		$id = $bubble['id'];
		if(!isset(${'B'.$id})){${'B'.$id} = new Bubble($id);}
	    $bulle = ${'B'.$id};
	    $sum_kinetics = $sum_kinetics + $bulle->get_Ec();
	}
	return round($sum_kinetics,2);
}


// Renvoit le nombre de bulles :
function nb_bubbles(){
	return MySQL::count_data('bubbles','');
}


// Renvoit le pas de temps de la simulation :
function delta_t(){
	$alpha = 5;
	if(sum_kinetics() == 0){return $dt = 0.01;}
	else{return $dt = round($alpha/(sum_kinetics()/nb_bubbles()),3);}
}


// Fonction renvoyant un nombre aléatoire en -2000 et 2000 :
function rand_position(){
  $distance = lcg_value()*2000; // 2000 = distance max du centre
  return $distance*(2*lcg_value()-1);
}


// Rend une chaine de caratère avec une majuscule comme 1er caractère :
function mb_ucfirst($string, $encoding){
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}