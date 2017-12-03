<?php 

session_start();

define('CRTL_DIR', 'controleurs/');
define('CLASS_DIR', 'modeles/');	// Chemin vers les classes
define('LIB_DIR', 'lib/');	// Chemin vers les classes
define('VIEW_DIR', 'vues/'.THEME.'/');
// Ajoute le chemin dans les "path"
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
// Ajoute le chemin dans les "path"
set_include_path(get_include_path().PATH_SEPARATOR.LIB_DIR);
set_include_path(get_include_path().PATH_SEPARATOR.CRTL_DIR);
set_include_path(get_include_path().PATH_SEPARATOR.VIEW_DIR);
// Défini l'extension de fichier ".class.php" = Personne.class.php
spl_autoload_extensions('.class.php');
spl_autoload_register();