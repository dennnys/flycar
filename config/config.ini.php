<?php 

// securise de entre
defined('FLYCAR') or die('Access interdi');

// path par default
define('PATH', 'http://localhost:8001/flycar/');

// theme acctive
define('THEME', 'flycar');
define('PATH_THEME', PATH.'vues/'.THEME.'/');

// definr le sel
define('SEL', 'ab1s2d3_%_q4w5e6');

// Configuration basse de donne
const DB_SERVEUR = 'localhost';
const DB_LOGIN = 'root';
const DB_PASSWORD= '';
const DB_NOM = 'flycar';