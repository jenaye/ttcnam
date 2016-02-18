<!-- NAVBAR POUR ECRANS AU DESSUS DE 600 px DE LARGEUR -->

		<section class="navbar-container bgvert front mobilehide" role="flottement-navbar-desktop">
            <div class="navbar main" role="navbar">

            	<div class="widget" role="header">

						<div class="left" role="logo-miniature">
								<a href="index.php?page=home"><img src="img/FaviconTTCNAM.png"></a>
						</div>

						<div class="txtblanc" role="titre">
								<a href="index.php?page=home"><h4 class="inline">TTCNAM</h4><h6 class="inline">Le faux club de tennis</h6></a>

						</div>
				</div>

				<div  class="widget right" role="nav-compte">

						<div class="left txtjaune inline" role="icone-compte">
							<i class="material-icons md-small">account_box</i>
						</div>
<?php
	require_once 'functions/session.php';
		Session::start();
		if(isset($_SESSION) && !empty($_SESSION['auth'])){



            $co = '<div class="inline" role="texte-nav-compte"><p class="txtblanc"><a href="index.php?page=profil">'.$_SESSION["name"].'</a><br/><a href="index.php?page=deconnexion">Déconnexion</a></p></div>';

	}else {

            $co = '<div class="inline" role="texte-nav-compte"><p class="txtblanc"><a href="index.php?page=connexion">Connexion</a><br/><a href="index.php?page=inscription">Pas encore inscrit ?</a></p></div>';

        }
    echo $co;


?>


				</div>

			</div>
		</section>

<!-- NAVBAR POUR ECRANS EN DESSOUS DE 600 px DE LARGEUR -->

		<section class="navbar-container bgvert front mobileonly" role="flottement-navbar-mobile">
            <div class="navbar main" role="navbar">

            	<div class="widget" role="header">

						<div class="left" role="logo-miniature">
								<a href="index.php?page=home"><img src="img/FaviconTTCNAM.png"></a>
						</div>

						<div class="txtblanc" role="titre">
								<a href="index.php?page=home"><h4 class="inline">TTCNAM</h4></a>

						</div>

				</div>

				<div  class="widget right" role="nav-compte">

						<div class="txtjaune inline" role="icone-compte">
							<a class="txtjaune" href="#" id="toggle"><i class="material-icons md-small txtjaune">menu</i></a>
						</div>

				</div>

			</div>

		</section>
		<div class="hide">
			<ul class="bgvert txtjaune padding">
				<?php echo $co ; ?>
			</ul>
		</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>

<script>
$('#toggle').click(function() {
$('.hide').slideToggle('slow', 'linear', function() {
// Animation complete.
});
});
</script>
