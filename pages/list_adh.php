<?php
require_once 'functions/main-functions.php';
// inclure connexion a la db
if(!isset($_SESSION['auth']) || $_SESSION['auth']->role_id != 1){
	echo "	<body class='x'>
			<div class='jumpco' role='espacement'>
			</div>

			<section class='main cadre txtcenter' role='presentation'>
			    <h3>Vous n'avez pas le droit d'accéder à cette page</h3>
				<p>Veuillez contacter un administrateur</p><br/>
				<img src='img/forbidden128.png'>
			    	</div>

		    </section>
			</body>";
			include('body/footer.php');

  	exit;
}
$req = $pdo->prepare('SELECT COUNT(*) AS nb_users FROM users');
// on selectione le nombre total d'utilisteur de la table users
$req->execute();
// execution de la requete prepare

$nb = $req->fetch(PDO::FETCH_OBJ);
// on cree un var, qui recuperer tous les resultats
$nb_by_page = 2;
// nombre de d'element par page qu'on veut
$max_page = ceil($nb->nb_users / $nb_by_page);
//  ceil == retourne le maximum ( arrondie superieur )
//  nombre de page maximum qu'on peut affiché

$p = (isset($_GET['p'])) ? intval($_GET['p']) : 1;
// on verifie index.php?page=list_adh&p=  un nombre compris entre 1 et max_page
if ($p < 1 || $p > $max_page) {
	// on regarde si p < 1  OU  p > le nombre de page maximum
	$p = 1;
}

$req = $pdo->prepare("SELECT * FROM users LIMIT :offset, :limite");
// on select tout de users, avec la pagination
$req->bindValue('offset', ($p - 1) * $nb_by_page, PDO::PARAM_INT);
//  on calcul la valeur de offset,
$req->bindValue('limite', $nb_by_page, PDO::PARAM_INT);
// declaration du nombre d'utilisateur par page
$req->execute();
// execution

$users = $req->fetchAll(PDO::FETCH_OBJ);
// on recupere tous les résultats

?>
<!DOCTYPE html>
<html>
<head>
	<title>Listes des adhs</title>
</head>
<body>

<!-- --><div class="cadre">
<table>
	<thead>
		<tr>
			<th>Email</th>
			<th>Nom</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($users as $user):
// affichage des informations d'utilisateur
	?>
		<tr>
			<td class="txtcenter"><?= $user->Email // affichage de Email?></td>
			<td class="txtcenter"><?= $user->Nom_adh // on affichage le nom de l'utilisateur?></td>
		</tr>

	<?php endforeach; ?>
	</tbody>
</table>
</div>
<?php
 // echo $data[0]->Email;
?>
<div class="doublejump"></div>
<?php for($i = 1; $i <= $max_page; $i++): ?>
	<?php if ($i == $p): ?>
		<em><?= $i ?></em>
		<!-- affichage en italique de la page en cours-->
	<?php else: ?>
		<a href="index.php?page=list_adh&amp;p=<?= $i ?>"><?= $i ?></a>
		<!-- affichage des liens pour les autres pages, ( liste d'adh ) -->
	<?php endif; ?>
<?php endfor; ?>
</body>
</html>
