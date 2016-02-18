<?php
$user_id = $_GET['id'];
$token = $_GET['t'];
$req = $pdo->prepare('SELECT * FROM users WHERE Num_adh = ? AND token = ? ');
$req->execute([$user_id,$token]);
$user = $req->fetch(PDO::FETCH_OBJ);

if($user && $user->token == $token){
	$req = $pdo->prepare("UPDATE users SET token = '1' WHERE Num_adh = ?")->execute([$user_id]);
	unset($user->Password);
	$_SESSION['auth'] = $user;
	header('location: index.php?page=profil');
	exit();

}else {

	echo "<div class='cadreerreur txtcenter'>Le token n'est pas/plus valide</div>";
	// header('location: index.php?page=connexion');

}

include("body/footer.php");
