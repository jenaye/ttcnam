<?php
require_once 'functions/session.php';

	if(!empty($_POST['mail']) && !empty($_POST['pass'])){

		$req = $pdo->prepare("SELECT * FROM users WHERE Email = ? AND token = '1'");
		$req->execute([$_POST['mail']]);

		$user = $req->fetch(PDO::FETCH_OBJ);
		if ($user) {
			// Un utilisateur à été trouvé via le mail
			if (password_verify($_POST['pass'], $user->Password)) {
				unset($user->Password);
				$_SESSION['auth'] = $user;
				$_SESSION['name'] = $user->Prenom_adh." ".$user->Nom_adh;
				 header('Location:index.php?page=profil');
			} else {
				echo "<div class='warning cadreerreur bgjaune txtcenter'>Le mot de passe est incorrect</div>";

			}
		} else {

				echo "<div class='warning cadreerreur bgjaune txtcenter'>Il y a une erreur quelque part... voir partout</div>";
				}
	}

?>

<div class="page">

	<div class="main cadre colbig center " role="presentation">



							    <div class="col inline left mobilehide">
							    	<br/>
							    	<br/>
							    	<img class="col center" src="img/padlockv.png">

							    </div>

							    <div class="col left mobileonly">
							    	<br/>
							    	<img class="center" src="img/padlockv.png">
							    </div>

						    	<div class="col inline border">

						    		<form class="txtcenter" method="POST" action="">



						    				<p class="exergue"><b>Identifiez-vous</b></p>




											<p><input class="champ colbig txtcenter " id="login" type="text" name="mail" size="25" placeholder="Email" tabindex="1"></p>



											<p><input class="champ colbig txtcenter" type='password' id ='password' name='pass' size='25' placeholder="Mot de passe"
												tabindex="2"></p></td>



											<p><input class="lien bouton-co colbig txtcenter " type="submit" value="Connexion" tabindex="3"></p>
									</form>
											<p class="txtcenter note"><a href="index.php?page=inscription">Pas de compte ? S'inscrire</a><p>

																				<br/>
								</div>





    </div>
<div class="jumpco"><br/></div>
</div>


<footer>
	    <?php

	    include("body/footer.php");
	    ?>

</footer>
