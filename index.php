<?php 

// entre principale
define('FLYCAR', TRUE);

// le configuration
include('config/config.ini.php');

// Autoloader
include('config/autoloader.php');

$routeur = new Routeur();
$routeur->execute();

//echo '<a href="index.php?controller=page">Pages</a>';