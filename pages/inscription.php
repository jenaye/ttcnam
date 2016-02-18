<?php

/* PAGE d'INSCRIPTION -->

<-- Ici on a du php et du html pour le formulaire d'inscription. -->
<-- Avant d'enregistrer un nouvel utilisateur dans la BDD, on a notamment : -->
<-- - envoi d'un mail de confirmation avec token pour valider -->
<-- - vérification du format du mail -->
<-- - vérification que les deux passwords entrés sont identiques */

if(isset($_SESSION['auth'])){

	header('Location:index.php?page=profil');
	exit();
}


// si les $_POST sont pas vides,
// création d'un tableau d'erreur
if(!empty($_POST)){

	$errors = array();
	if(empty($_POST['nom']) || !preg_match('/^[a-zA-Z0-9\-]+$/', $_POST['nom'])){ // on vérifie que le nom est un caractère alpha numérique

		$errors['nom'] =  "<div class='cadreerreur bgjaune txtcenter'>Nom pas dans les normes ( alpha numerique )</div>"; // on crée un champ dans le tableau, ' nom ' qui affiche un message en cas d'erreur
	}
	$_POST['prenom'] = wd_remove_accents($_POST['prenom']);
	if(empty($_POST['prenom']) || !preg_match('/^[a-zA-Z0-9\-]+$/', $_POST['prenom'])){

		$errors['prenom'] =  "<div class='cadreerreur bgjaune txtcenter'>Prénom pas dans les normes ( alpha numerique )</div>"; // on crée un champ dans le tableau, ' nom ' qui affiche un message en cas d'erreur
	}

	if(empty($_POST['cp']) || !preg_match('/^[0-9]+$/', $_POST['cp'])){

		$errors['cp'] =  "<div class='cadreerreur bgjaune txtcenter'>votre code postal n'est pas correct</div>"; // on crée un champ dans le tableau, ' nom ' qui affiche un message en cas d'erreur
	}


	else {
		require_once "functions/main-functions.php";
	}


	if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){ // on vérifie que l'email est d'un format valide aa@aa.aa

		$errors['mail'] = "<div class='cadreerreur bgjaune txtcenter'>Votre adresse e-mail ne paraît pas valide</div>"; // on crée un champ dans le tableau 'mail' qui affiche un message d'erreur
	}
	else {

		// sinon on inclut le fichier de connexion a la bdd pour faire des requêtes
		require_once 'functions/main-functions.php';
		$req = $pdo->prepare('SELECT Email FROM users WHERE Email =  ?'); // on vérifie que l'email
		$req->execute([$_POST['mail']]);//  apres avoir preparé la requête, on l'execute on lui mettant en parametre l'email
		$user = $req->fetch(); // un petit fetch

		if($user) {
			;
			$errors['email'] = "<div class='cadreerreur bgjaune txtcenter'>Cette adresse mail est déjà utilisée par un autre utilisateur !</div>"; // creation d'un champ dans le tableau 'email ' pour le message d'erreur
		}

	}	// On verifie que le mot de passe et le passconfirm sont identiques sinon on met le message d'erreur en dessous

	if(empty($_POST['pass']) || $_POST['pass'] != $_POST['passconfirm'] ) {

		$errors['pass'] = "<div class='cadreerreur bgjaune txtcenter'> Vos mots de passe ne sont pas identiques</div>";


		//	echo "<p class='cadrevalidation bgvert txtcenter'>Bravo, vous pouvez dès à présent vous connecter avec votre compte.</p>";
	}

	if (empty($errors)) {

		// si y'a pas d'erreur, on execute tout ça
		require_once 'functions/alea.php';
		$key = keys::randomkey(10);

		$req = $pdo->prepare("INSERT INTO users SET Nom_adh = ?, Prenom_adh = ?, DNaiss_adh = ?, Email = ?, Adr_adh = ?, Cp_adh = ?, Ville_adh = ?, Password =? , token = ?, DFirst_adh  = NOW(), DLast_adh = NOW()");
		$password = password_hash($_POST['pass'], PASSWORD_BCRYPT);

		$date_naiss = new DateTime($_POST['dnaiss']);
		$dnaiss= $date_naiss->format('Y-m-d');
		$req->execute([$_POST['nom'], $_POST['prenom'], $dnaiss, $_POST['mail'], $_POST['adr'], $_POST['cp'], $_POST['ville'], $password, $key]);
		$user_id = $pdo->lastInsertId();
		$message = "Veuillez valider votre email en cliquant ici : http://cnam.jenaye.xyz/index.php?page=confirmation&t=$key&id=$user_id ";
		$to = $_POST['mail'];
		$sujet = 'Votre inscription au ttcnam';
		mail($to,$sujet,$message);

		echo "<div class='cadrevalidation bgvert txtcenter'>Vous allez recevoir un message de confirmation sur votre boîte mail. Merci de le valider !</div>";
	}
	else {
		// ici c'est une erreur
	}
}

$_POST = array_merge([
	'nom' => '',
	'prenom' => '',
	'dnaiss' => '',
	'mail' => '',
	'adr' => '',
	'cp' => '',
	'ville' => ''
], $_POST);

?>
<div class="page">

	<div class="padding">
		<section class="main cadre" role="inscription">
			<div class="txtcenter">
				<p class="exergue"><i class="material-icons md-large">account_box</i></p>
				<p class="exergue"><b>Inscription</b></p>
				<p class="exergue">Devenez adhérent du TTCNAM en quelques clics pour bénéficier de nos services !</p>
			</div>

			<br/>
			<?php if(!empty($errors)): ?>
				<p class="cadreerreur bgjaune txtcenter">Vous n'avez pas rempli le formulaire correctement</p><br/>
				<?php  foreach ($errors as $error): ?>
					<p class="txtcenter"><?= $error; ?></p>
				<?php endforeach; ?>
			<?php endif; ?>



			<div class="main colbig center border"><form method="post" action="" autocomplete="on">


				<ul class="center">
					<li><p class="table">
						<label class="inline padding  table" for="nom" >Nom de famille :</label>
						<input class="champ inline txtcenter right" name="nom" id="inscriptionnom"
							autofocus required="" type="text" size="25" placeholder="ex : Dupont" value="<?= $_POST['nom'] ?>"/>
					</p></li>

					<br/ class="largeonly">

					<li><p class="table">
						<label class="inline padding  table" for="prenom" >Prénom :</label>
						<input class="champ inline txtcenter right" name="prenom" id="inscriptionprenom"  required=""type="text" size="25" placeholder="ex : Bachar" value="<?= $_POST['prenom'] ?>"/>
					</p></li>

					<br/ class="largeonly">

					<li><p class="table">
						<label class="inline padding  table" for="jnaiss" >Date de naissance:</label>

						<input class="champ inline txtcenter right" name="dnaiss" id="datepicker" required="" type="date">

					</p></li>

					<br/ class="largeonly">

					<li><p class="table">
						<label class="inline padding  table" for="inscriptionemail" >Adresse mail :</label>
						<input class="champ inline txtcenter right" name="mail" id="inscriptionemail" required="" type="email" size="25" placeholder="ex : mail@mail.com" value="<?= $_POST['mail'] ?>"/>
					</p></li>

					<br/ class="largeonly">
					<br/ class="largeonly">

					<li><p class="table">
						<label class="inline padding table" for="adr" >N° et voie :</label>
						<textarea class="champ txtcenter right" name="adr" id="inscriptionadresse" required="" rows="3" placeholder="ex : 256 rue des Sportifs" value="<?= $_POST['adr'] ?>"/>  </textarea><br/>
					</p>
				</li>

				<br/ class="largeonly">
				<br/ class="largeonly">
				<br/ class="largeonly">
				<br/ class="largeonly">
				<li><p class="table">
					<label class="inline padding table" for="cp" >Code postal :</label>
					<input class="champ inline txtcenter right" name="cp" id="inscriptionadresse" required="" type="text" size="25" placeholder="ex : 59000" value="<?= $_POST['cp'] ?>"/>
				</p></li>

				<br/ class="largeonly">
				<li><p class="table">
					<label class="inline padding table" for="ville" >Commune :     </label>
					<input class="champ inline txtcenter right" name="ville" id="inscriptionadresse" required="" type="text" size="25" placeholder="ex : Lille" value="<?= $_POST['ville'] ?>"/>
				</p></li>


				<br/ class="largeonly">
				<li><p class="table">
					<label class="inline padding table" for="pass" >Mot de passe :</label>
					<input class="champ inline txtcenter right" name="pass" id="inscriptionmdp" required="" type="password" size="25" placeholder="ex : X8df!90EO"/>
				</p></li>

				<br/ class="largeonly">
				<li><p class="table">
					<label class="inline padding table" for="passconfirm">Confirmer le <br> mot de passe :</label>
					<input class="champ inline txtcenter right" name="passconfirm" id="inscriptionmdpconfirm" required="" type="password" size="25" placeholder="ex : X8df!90EO"/>
				</p></li>



				<br/><br/ class="mobileonly">


				<div class="doublejump mobileonly"></div>
				<br/ class="largeonly">
				<li><p class="right">
				</a><input class="lien bouton-co" type="submit" action="#Top" value="Valider">
			</p></li></ul>
		</div>



	</section>

	<div class="doublejump"></div>

</div>
<footer>
	<?php include("body/footer.php");	?>

</footer>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/datepicker-fr.js"></script>

	<script  type="text/javascript">
$('#datepicker').datepicker({changeMonth: true,
	changeYear: true,
	yearRange: '-100:-18'});

	</script>
