<div class="page">
	<div class="doublejump" role="espacement">
	</div>
	<section class="main cadre" role="presentation">
		<div class="txtjustify">
			<p><b><em>Les meilleurs services, au plus bas prix, pour les mordus de terre battue et les brouteurs de gazon !</em></b><br/><br/>
				Appréciez nos terrains d'exception, dont un agréé conforme olympique ! Participez aux tournois organisés quotidiennement et remportez des prix !
				Le TTCNAM fournit à la location courts, balles et raquettes. Vestiaires, douches et sauna sont mis à votre disposition gratuitement.
				Un club-house est en libre accès pour les adhérents avec buvette pour l'entre-deux matchs !<br/>
			</p>
			<p>L'accès à nos services est réservé aux adhérents de l'association.</p>
			<br/>
			<h3>Nos courts</h3>
			<p><?php echo "<form name='courtadmin' method='post' action='index.php?page=admin'><fieldset><table class='txtcenter'>
			<tr class='note'><th colspan='2'>Nom du court</th><th colspan='2'>Type</th><th colspan='2'>Surface</th><th colspan='2'>Prix / heure</th><th></th></b></tr>";
			$req6 = $pdo->query("SELECT * FROM court ORDER BY NumCourt");
			$courts = $req6->fetchAll(PDO::FETCH_OBJ);

			foreach ($courts as $court) {
				// création d'un tableau assosiatif
				$surfacecourts = array(
					'terre_battue' => "terre battue",
					'resine' => "résine",
					'synthetique' => "synthétique",
					'dur' => "dur",
					'gazon' => "gazon",
				);

				$surface = $court->NatCourt;
				$surfacecourt = $surfacecourts[$surface];
				$numcourt = $court->NumCourt;
				$nomcourt = $court->NomCourt;
				$prixcourt = $court->PrixCourt;
				$typecourt = $court->TypCourt;
				if ($typecourt == 'externe') {$typecourt = 'extérieur';}
				elseif ($typecourt == 'couvert' && $prixcourt >= 17) {
					$typecourt = "couvert olympique"; }
					elseif ($typecourt == 'externe' || $prixcourt > 11) {
						$typecourt = "extérieur avec toit";   };


						echo $row = "<tr class='note'><td colspan='2'>$nomcourt</td><td colspan='2'>$typecourt</td><td colspan='2'>$surfacecourt</td><td colspan='2'>$prixcourt € </td></tr>";
					}
					echo "</form></table></fieldset>";
					?>
					<!-- fin du tableau -->
				</p>
				<br/>
				<div class="col left">
					<h3 class="txtcenter">Adhésion annuelle</h3><br/>
					<table class="padding cadre center">
						<tr>
							<th class="padding txtcenter bgvert txtblanc  note">De 18 à 25 ans<br></th>
							<th class="padding txtcenter bgvert txtblanc note">Plus de 25 ans<br></th>
							<th></th>
						</tr>
						<tr>
							<td class="txtcenter bgvert txtblanc" >40 €</td>
							<td class="txtcenter bgvert txtblanc" >48 €</td>
							<td class="padding txtcenter  bgvert txtblanc note">Résident de Lille <br></td>
						</tr>
						<tr>
							<td class="txtcenter bgvert txtblanc">50 €</tdv>
								<td class="txtcenter bgvert txtblanc" >60 €</td>
								<td class="padding txtcenter  bgvert txtblanc note padding ">Non-résident de Lille<br></td>
							</tr>
						</table>
						<div class="jump"></div>
					</div>

					<div class="col right">
						<h3 class="txtcenter">Matériel</h3><br/>
						<table class="padding cadre center">
							<tr class="bgvert txtblanc">
								<th></th>
								<th class="padding  bgvert txtblanc  note">Prix pièce par heure<br></th>
							</tr>
							<tr>
								<td class="txtcenter  bgvert txtblanc note">Balle<br></td>
								<td class="txtcenter bgvert txtblanc" >1 €</td>
							</tr>
							<tr>
								<td class="bgvert txtblanc note">Raquette</td>
								<td class="txtcenter bgvert txtblanc" >5 €</td>
							</tr>
							<tr>
								<td class="txtcenter  bgvert txtblanc note">Robot</tdv>
									<td class="txtcenter bgvert txtblanc" >30 €</td>
								</tr>
							</table>

							<div class="jump"></div>
						</div>

						<div class="jump"></div>
						<div class="txtcenter"><br>
							<h3>Où nous trouver ?</h3>
							<p>Le club TTCNAM</p>
							<p>256 rue des Sportifs</p>
							<p>59000 Lille</p><br/>
							<h4>Localisation</h4>
					<iframe id="map" class="txtcenter" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7098.94326104394!2d78.0430654485247!3d27.172909818538997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1385710909804" width="750" height="450" frameborder="0" style="border:0"></iframe>
						</div>

					</section>
					<div class="doublejump" role="espacement">
					</div>

					<section  role="adresse">
						<div class="main">
						</div>

						<div class="doublejump" role="espacement">
						</div>
					</div>

					<footer>
						<?php include("body/footer.php");	?>
					</footer>
