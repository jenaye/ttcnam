<?php
// declaration des variables pour se connecter
$prod = true;
if($prod){
	$dbhost = 'mysql.hostinger.fr';
	$dbname = 'cnam';
	$dbuser = 'root';
	$dbpswd = '';

}
else{
	$dbhost = 'localhost';
	$dbname = 'cnam';
	$dbuser = 'root';
	$dbpswd = '';

}


// connection a la bdd avec pdo ( qui permet d'utiliser ce code sur nimporte quel sgbd)
try {
	$pdo = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dbuser,$dbpswd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	$pdo->exec("SET CHARACTER SET utf8");
	}catch(PDOexception $e){
	die ("Erreur survenue pendant la connexion à la base de données");
}

/*
FUNCTIONS POUR LA PAGE ADMIN ( réutilisable ailleurs )
*/

function is_member(){
	if($_SESSION['auth']->role_id == 2) {
		header('Location:index.php?page=profil');
		exit();
	}
}

function aint_connected(){
	if(!isset($_SESSION['auth']) ){
		header('Location:index.php?page=connexion');
		exit();
	}
}

function wd_remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;

}
