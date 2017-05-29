<?php

// Chargement des prérequis à toute requête :
require 'required.php';

$textstart = 'function autocomplete_init(id){';

$textstart .= 'var liste = [';

$text = '';
$bubbles = MySQL::select_data('bubbles',array('titre,type'),'');

foreach($bubbles as $bubble){
	if($bubble['type'] == 'humain-homme' OR $bubble['type'] == 'humain-femme'){
		$id_humain = str_replace('u-','',$bubble['titre']);
		$humain = MySQL::select_data('users',array('pseudo'),'id="'.$id_humain.'"');
		$text = $text.'"'.$humain[0]['pseudo'].'",';
	}
	else{
		$text = $text.'"'.$bubble['titre'].'",';
	}
}

$text = substr($text,0,-1);

$textend = '];';

$textend .=	'$("#"+id).autocomplete({';
$textend .=		'autoFocus:true,';
$textend .=		'source:liste,';
$textend .=		'minLength:3,';
$textend .=		'delay:0';
$textend .=	'});';

$textend .=	'}';

echo $textstart.$text.$textend;