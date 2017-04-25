<?php

$pdo = new PDO('mysql:host=localhost;dbname=sallea','root','',
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

session_start();

// VARIABLES
$msg='';
$page= '';
$contenu ='';

// AUTRES INCLUSIONS
require_once('fonctions.inc.php');

// CHEMIN : on va créer une constante racine site pour gérer les redrections dans le site:
define('RACINE_SITE','/sallea/');

// CHEMIN : on va créer une constante racine serveur pour le déplacement des fichiers :
define('RACINE_SERVEUR',$_SERVER['DOCUMENT_ROOT']);

 ?>
