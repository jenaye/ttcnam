<?php
require_once 'functions/session.php';
$message="";

aint_connected();

if(!isset($_SESSION['auth'])){
	header('Location:index.php?page=home');
	// var_dump((!(session_status() == PHP_SESSION_NONE)));
	exit();
}  //  pas besoin de else a cause du header
	// var_dump($_SESSION['auth']);
	echo "<div class='bandeau bgvert txtblanc txtcenter'>Bonjour, ".$_SESSION['auth']->Prenom_adh." ".$_SESSION['auth']->Nom_adh."</div>";
	$req = $pdo->prepare("SELECT Num_adh, TIMESTAMPDIFF(YEAR, DLast_adh, NOW()) AS adherant FROM users WHERE Num_adh = ?");
	$req->execute([$_SESSION['auth']->Num_adh]);
	$user  = $req->fetch(PDO::FETCH_OBJ);
	if ($user->adherant > 0) {

		echo "<div class='page'><br/><div class='cadre main center txtcenter'><div class='bandeau bgvert txtblanc txtcenter'>Votre adhésion annuelle a expiré. Veuillez l'actualiser. <br/><br/><input type='button' class='lienalt bouton-co bgvert txtcenter' value='Payer'></div>";
	}else {

		echo "<div class='page'><br/><div class='cadre main center txtcenter'><form action='index.php'> </form><a class='warning' href='index.php?page=home'><i class='material-icons md-tiny inline'>home</i> <p class='inline'> Revenir à l'accueil</p> </a><br/>Votre compte est bien en règle.";



		if(!empty($_POST['mail'])){
			$mailentre = $_POST['mail'];
			$req2 = $pdo->prepare("SELECT * FROM users WHERE Email = '$mailentre'");
			$req2->execute();
			$mailcheck = $req2->fetch(PDO::FETCH_OBJ);
			if(!empty($mailcheck)) {
				$message= "<div class='cadreerreur bgjaune txtcenter'>Cette adresse mail est déjà utilisée !</div>";
			} else {
				$req = $pdo->prepare("UPDATE users SET Email=? WHERE Num_adh=?");
				$req->execute([$_POST['mail'], $_SESSION['auth']->Num_adh]);
				$message = "<div class='cadreerreur bgjaune txtcenter'>Adresse mail modifiée</div>";

			}


		}

		if (isset($_POST['password'])&& isset($_POST['passverif'])&& !empty($_POST['password'])&& !empty($_POST['passverif'])) {

			if ($_POST['password']==$_POST['passverif']) {
				$password = password_hash($_POST['passverif'], PASSWORD_BCRYPT);
				$req=$pdo->prepare("UPDATE users SET Password=? WHERE Num_adh=?");
				$req->execute([$password, $_SESSION['auth']->Num_adh]);
				$message= "<div class='cadreerreur bgjaune txtcenter'>Mot de passe modifié</div>";
			}

			else {
				$message = "<div class='cadreerreur bgjaune txtcenter'>Les mots de passe doivent être identiques</div>";

			}

		}

		if (isset($_POST['check_deleted'])&& !empty($_POST['check_deleted'])) {
			$req=$pdo->prepare("DELETE FROM users WHERE Num_adh=?");
			$req->execute([$_SESSION['auth']->Num_adh]);
			Session::reset();
			header('Location:index.php?page=home');
		}


        if (isset($_POST['del_last'])) {
            $req=$pdo->prepare("SELECT Jours, date_resa, NumResa FROM resa WHERE Num_adh = ? ORDER BY NumResa asc;");
            $req->execute([$_SESSION['auth']->Num_adh]);
            $fetch = $req->fetchAll(PDO::FETCH_OBJ);
            $now = date_create();
            foreach ($fetch as $f) {
                $datecommande = new DateTime($f->date_resa);
                $jourresa = new DateTime($f->Jours);
                $diff = $now->diff($datecommande);
                $resapassee = $diff->format('%d');
               if ($resapassee < 1 && $datecommande < $jourresa)
               {   $lastresa = $f->NumResa;
                   $req=$pdo->prepare("DELETE FROM resa WHERE NumResa = '$lastresa'");
                   $req->execute();
               exit(); }

            }
            echo "<p class='warning'>Suppression effectuée !</p>";
        }


        $dnaiss = new DateTime($_SESSION['auth']->DNaiss_adh);
        $dcotis = new DateTime($_SESSION['auth']->DLast_adh);
        $interval = $dnaiss->diff($dcotis);
        $reducmineurs = $interval->format('%y');
       if ($reducmineurs <= 25 ) {
           if ($_SESSION['auth']->Cp_adh == '59000' || $_SESSION['auth']->Cp_adh == '59800') {
               $prixadhesion = '40';}
           else {$prixadhesion = '50';};
        } else {
           if ($_SESSION['auth']->Cp_adh == '59000' || $_SESSION['auth']->Cp_adh == '59800') {
               $prixadhesion = '48';}
           else {$prixadhesion = '60';};
       }
        $prixcotis = "<p>Tarif de la cotisation annuelle : <b>".$prixadhesion." €</b></p>";
	}

?>

<body>

	</br></br>

	<?php echo $message;?>
    <?php echo $prixcotis; ?>


                <form class="center" method="post" name="adminresa" action="index.php?page=profil">
                    <input type="submit" class="lien bouton-co inline" name="profilresas" id="submitresas" value="Gérer mes réservations" ><div class="jump mobileonly"></div>
                    <input type="submit" class="lien bouton-co inline" name="profilinfos" id="submitusers" value="Gérer mes infos" >
                </form>


            </div>
            <div class="jump"></div>





					<?php

                    if (isset($_POST['profilresas'])) {

                        echo " <section class='main cadre'><div class='txtcenter'><form action='index.php?page=profil' method='post'><input type='submit' class='lienalt bouton-co large inline' name='del_last' value='Supprimer ma dernière réservation' ></form><br/><br><h2>Historique de réservations : </h2><br/>";

                        $iduser = $_SESSION['auth']->Num_adh;
                        $req3 = $pdo->prepare("SELECT * FROM resa WHERE Num_adh = '$iduser'");
                        $req3->execute(); // requête sur la bdd des toutes les résas à +7 jours
                        $checkresas = $req3->fetchAll(PDO::FETCH_OBJ);
                        $req3 = $pdo->prepare("SELECT * FROM resa WHERE Num_adh = '$iduser'");


                        if (empty($checkresas)) {
                            echo "<p>Vous n'avez pas de réservation !</p>";
                            exit();
                        } else {
                            echo "<table class='main txtcenter'><tr class='note'><th>Date</th><th>Heures</th><th>Terrain</th><th>Balles</th><th>Raquettes</th><th>Lumiere</th><th>Robot</th><th>Total de la réservation</th></tr>";
                            foreach ($checkresas as $checkresa) {
                                $numcourt = $checkresa->NumCourt;
                                $req3 = $pdo->query("SELECT PrixCourt FROM court WHERE NumCourt ='$numcourt'");
                                $prixcourtresa = $req3->fetch(PDO::FETCH_OBJ);
                                $prixcourt = $prixcourtresa->PrixCourt;
                                $numresa = $checkresa->NumResa;
                                $dateresa = new DateTime($checkresa->Jours);
                                $datecommande = new DateTime($checkresa->date_resa);
                                $horaireresa = $checkresa->heures;
                                $lum = $checkresa->Lum;
                                $balles = $checkresa->balles;
                                $raquettes = $checkresa->raquettes;
                                $robot = $checkresa->robot;
                                $prixresa = $prixcourt;
								$numducourt = $checkresa->NumCourt;
								$req9 = $pdo->query("SELECT NomCourt FROM court WHERE NumCourt ='$numducourt'");
								$recupnom= $req9->fetch(PDO::FETCH_OBJ);
								$nomducourt = $recupnom->NomCourt;

                                if ($robot == 1) {$prixresa = ($prixresa + 30);};
                                if ($lum == 1) {$prixresa = ($prixresa + 4);};

                                if ($balles != 0) { $prixresa = ($prixresa + (1 * $balles));};
                                if ($raquettes != 0) {$prixresa = ($prixresa + (5 * $raquettes));};


                               echo "<tr class='note'><td>" . $dateresa->format('d-m-Y') . "</td><td>" . $horaireresa . "</td><td>".$numducourt."</td><td>" . $balles . "</td><td>" . $raquettes . "</td><td>" . $lum . "</td><td>" . $robot . "</td><th>$prixresa €</th></tr>";

                            }
                            echo "</table>";
                        }
                    }


					elseif (isset($_POST['profilinfos'])) {
						echo <<< EOT



					<section class="main cadre">
					<table class="main">
					<form name="changemail" action="" method="POST" autocomplete="off">
						<tr>
							<td><label class="left"  for="mail">Modifier votre adresse e-mail</label></td>
							<td><input class="right" type="email" name="mail" placeholder="ex : mail@mail.com" ></td><br/>
						</tr>
						<tr>
							<td colspan="2"><input class="lien bouton-co right" type="submit" name="gochangemail" value="Changer"></td>
						</tr>
					</form>
					</table>


					<br/>
					<br/>
					<table class="main">
						<form name="changepass" action="" method="POST" autocomplete="off">
							<tr>
								<td><label class="left" for="pass">Modifier votre mot de passe</label></td>
								<td><input class="right" type="password" name="password" ><br></td>
							</tr>
							<tr>
								<td><label class="left" for="passverif">Confirmer le mot de passe</label></td>
								<td><input class="right" type="password" name="passverif" ></td>
							</tr>
							<tr>
								<td colspan="2"><input class="lien bouton-co right " type="submit" value="Changer"><br></td>
							</tr>
						</form>
					</table>

					<br/>
					<br/>
						<form  name ="form_deleted" id="deleted" action="" method="POST" onsubmit="return checked(this)">
							<fieldset>
							<div class="txtcenter">
								<label for="check_deleted">Voulez-vous supprimer votre compte ?</label>
								<input type="checkbox" name="check_deleted" id="check_deleted" value="deleted"> oui
								</br></br>
								<input name="suppression" type="submit" onclick="check()" class="lienalt bouton-co main large" value="Confirmer")>
							</div>
							</fieldset>

							<script>


								function checked(form_deleted){
									if (form_deleted.check_deleted.checked == true) {
										alert('votre compte a été supprimé !');

									}
								}

							</script>

						</form>

EOT;
					}

					else
					{
						echo <<< EOT
									<div class="main">
										<a href="index.php?page=reservation">
										<div class="col lien">
											<div class="cadre">
												<div class="colsmall padding up"><i class="material-icons md-large">today</i></div>
												<div class="colbig padding"><h2>Réservation</h2>
												<p>Choisissez en ligne parmi nos 14 courts, et commandez tout ce dont vous aurez besoin pour votre séance !</p>
												</div>
											</div>
										</div>
										</a>
										<a href="index.php?page=recherche">
										<div class="col lien right">
											<div class="cadre">
												<div class="colsmall padding up"><i class="material-icons md-large">search</i></div>
												<div class="colbig padding"><h2>Rechercher un membre</h2>
												<p>Vous avez rencontré quelqu'un au TTCNAM ? Retrouvez cette personne et ses informations avec l'outil de recherche !</p>
												</div>
											</div>
										</div>
										</a>
									</div>
									<div class="jump"></div>
EOT;

					}?>
                    </section>
</div></div>
	<footer>
		<?php

		include("body/footer.php");
		?>

	</footer>

</body>
