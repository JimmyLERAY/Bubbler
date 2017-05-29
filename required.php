<?php

// Chargement automatique des classes PHP :
require './class/Autoloader.php';
Autoloader::start();

// Initialisation de la classe MySQL
MySQL::init();

// Chargement des fonctions PHP :
require './models/functions.php';
