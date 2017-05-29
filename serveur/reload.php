<?php

// Chargement automatique des classes PHP :
require '../class/Autoloader.php';
Autoloader::start();

// Initialisation de la classe MySQL
MySQL::init();

// On coupe le serveur :
MySQL::update_data('serveur',array('statut'),array(0),'id="serveur"');