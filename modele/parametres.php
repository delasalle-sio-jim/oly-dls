<?php
// ce fichier est destiné à être inclus dans les pages PHP qui ont besoin de se connecter à une base de données
// 2 possibilités pour inclure ce fichier :
//     include_once ('_inc_parametres.php');
//     require_once ('_inc_parametres.php');

// connexion de l'application cliente au SGBD MySQL
$HOTE = "localhost";	// nom du serveur de données : localhost ou serv-wamp1 ou serv-wamp1
$PORT = '3306';			// numéro du port
$USER = "corewqqc_user";			// nom de l'utilisateur
$PWD  = "k3y95ZEEew@@hR5";		// son mot de passe
$BDD  = "oly_dls_bdd";		// nom de la base de données	
?>
