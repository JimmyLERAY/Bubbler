<?php

// Chargement automatique des classes PHP :
require '../class/Autoloader.php';
Autoloader::start();

header("Content-Type: text/html; charset=utf-8");

// Initialisation de la classe MySQL
MySQL::init();

// Chargement des fonctions :
require '../models/functions.php';