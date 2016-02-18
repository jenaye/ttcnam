<!DOCTYPE html5>
<html lang="fr">
	  <link rel="stylesheet" type="text/css" href="slider/css/test.css"/>

      <title>TTCNAM - Faux club de tennis</title>
    </head>



			<section class="main cadre" role="presentation">

				    <div class="colsmall"><img src="img/LogoTTCNAM.png"></div>

			    	<div class="colbig right"><p class="exergue txtcenter"><em>Le club de tennis d'excellence de Lille Métropole</em></p><br/>
						<p class="txtcenter right">La référence depuis 1981 ! Des installations sportives de pointe, un service premium, et des coaches de talent disponibles à chaque instant pour vous guider font du TTCNAM le club idéal pour les professionnels comme pour les amateurs.
						<br/><br/></p>
						<a href="index.php?page=apropos"><input class="lien bouton-co col center" type="button" value="Infos pratiques"></a><br/>
						<p class="txtcenter right warning wrap"><small>ATTENTION : ce site est un faux réalisé dans le cadre d'une formation. Aucune transaction ne peut y être réalisée.</small></p>
					</div>


			</section>

		    <section class="jump" role="espacement">
		    </section>

		    <section class="main" role="outils">


			    	<a href="index.php?page=reservation"><div class="col lien" role="colonne gauche resa">
			    	<div class="cadre">
			    		<div class="colsmall padding up"><i class="material-icons md-large">today</i></div>
			    		<div class="colbig padding"><h2>Réservation</h2>
			    		<p>Choisissez en ligne parmi nos 14 courts, et commandez tout ce dont vous aurez besoin pour votre séance !</p></div>
			       	</div>
					</div></a>

			    	<a href=<?php if(!isset($_SESSION['auth'])){ echo "'index.php?page=inscription'"; } else { echo "'index.php?page=profil'"; }; ?>
	index.php?page=inscription"><div class="col lien right" role="colonne droite compte">
			    	<div class="cadre">
			    			<div class="colsmall padding up"><i class="material-icons md-large">account_box</i></div>
							<?php
							if(!isset($_SESSION['auth'])){ // si pas identifié, on affiche une invitation à l'inscription, sinon, on link vers le compte
								echo "<div class='colbig padding'><h2>S'inscrire</h2><p>Devenir adhérent du TTCNAM, c'est simple comme un clic ! Inscrivez-vous pour profiter de tous nos services.</p> </div>";
							} else {
								echo "<div class='colbig padding'><h2>Mon compte</h2><p>Gérez vos cotisations ainsi que vos informations et réservations en toute simplicité, directement depuis votre compte.</p> </div>";
							}
							?>

					</div>
				    </div></a>

	    	</section>

		    <section class="jump" role="espacement">
			</section>


				<section class="bandeau bgvert inline">
					<a name="pratique"></a>
		    		<table class="large center">
						<tr>
							<p class="txtblanc txtcenter">Tennis Team CNAM<br/>
							256 rue des Sportifs<br/>
							59000 Lille</p>
							<br/>
						</tr>
						<tr>
							<p class=" note txtblanc txtcenter padding"><a href="index.php?page=apropos#map"> <i class="material-icons md-tiny up">location_on</i>
							<br/>Voir sur la carte</p></a>
						</tr>
					</table>

	    		</section>


	    	<section class="jump" role="espacement">
		    </section>


	<div class="cadre main largeonly">
		<div id="mi-slider" class="mi-slider">
			<ul>
				<li><img src="slider/images/01.gif" alt="img01"><h4>Climatisation</h4><span class="inline note">En intérieur</span></li>
				<li><img src="slider/images/02.gif" alt="img02"><h4>Olympique</h4><span class="inline note">1 court</span></li>
				<li><img src="slider/images/03.gif" alt="img03"><h4>Intérieur</h4> <span class="inline note">3 courts</span></li>
				<li><img src="slider/images/04.gif" alt="img04"><h4>Extérieur</h4> <span class="inline note">7 courts</span> </li>
			</ul>
			<ul>
				<li><img src="slider/images/05.gif" alt="img05"><h4>Raquettes</h4></li>
				<li><img src="slider/images/06.gif" alt="img06"><h4>Balles</h4></li>
				<li><img src="slider/images/07.gif" alt="img07"><h4>Robot</h4></li>
			</ul>
			<ul>
				<li><img src="slider/images/09.gif" alt="img09"><h4>Sauna</h4></li>
				<li><img src="slider/images/10.gif" alt="img10"><h4>Club-house</h4></li>
				<li><img src="slider/images/11.gif" alt="img11"><h4>Tournois</h4></li>
			</ul>
			<nav>
				<a href="#">Terrains</a>
				<a href="#">Matériel</a>
				<a href="#">Votre club</a>
			</nav>
			<br/>
		</div>
	</div>
	</div><!-- /container -->
	</div>


			<section class="jump">

<?php

include 'body/footer.php';
?>				<script src="js/jquery-1.10.2.js"></script>
				<script src="js/jquery-ui.js"></script>
				<script src="slider/js/jquery.catslider.js"></script>
				<script src="slider/js/modernizr.custom.63321.js"></script>

				<script>
					$(function() {

						$( '#mi-slider' ).catslider();

					});
				</script>
