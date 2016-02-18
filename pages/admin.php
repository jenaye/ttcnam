
<div class="page">
  <div class="cadre main txtcenter">
    <h2 class="exergue">Administration</h2>
    <?php

    header('Content-type: text/html; charset=utf-8');

    /* ici on gère l'affichage général en php  ainsi que les requêtes adressées en n2 et leurs confirmations en n3 */
    is_member();
    aint_connected();

    if (isset($_POST['deleteresa']) && !empty($_POST['resa']) ) {
      foreach ($_POST['resa'] as $x => $y) {
        $suppressresa = $pdo->query("DELETE FROM resa WHERE NumResa ='$y'");
      }
      echo "<p class='warning'>Suppression bien prise en compte</p>";
    }


    if (isset($_POST['modif']) && isset($_POST['select_user'])) {
      $user_id = ($_POST['select_user']);
      foreach ($_POST['changer'] as $x => $y) {
        if ($x == "DLast_adh") {
          $date = new DateTime($y);
          $y = $date->format('Y-m-d');
        };
        if (!empty($y)) {
          $req5 = $pdo->prepare("UPDATE `users` SET `$x` = '$y' WHERE `users`.`Num_adh` = $user_id");
          $req5->execute();
        }
      };
      echo "<p class='warning'>Modification bien prise en compte</p>";

    }

    if (isset($_POST['modifcourt']) && isset($_POST['select_court'])) {
      $court_id = ($_POST['select_court']);
      foreach ($_POST['modif'] as $x => $y) {
        if (!empty($y) && $x != 'NumCourt') {
          $req7 = $pdo->prepare("UPDATE court SET `$x` = '$y' WHERE NumCourt = $court_id");
          $req7->execute();
        }

      };
      echo "<p class='warning'>Modification bien prise en compte</p>";

    }

    if (isset($_POST['suppcourt']) && isset($_POST['select_court'])) {
      $court_id = ($_POST['select_court']);

      $req7 = $pdo->prepare("DELETE FROM court WHERE NumCourt = $court_id");
      $req7->execute();

      echo "<p class='warning'>Suppression bien prise en compte</p>";

    }

    if (isset($_POST['addcourt']) &&  (count($_POST['modif']) > 4)) {

      $val = array();
      foreach ($_POST['modif'] as $x => $y) {
        $val[$x] = $y;
      }
      $numcourt = $val['NumCourt'];
      $prixcourt = $val['PrixCourt'];
      $typcourt = $val['TypCourt'];
      $natcourt = $val['NatCourt'];
      $nomcourt = $val['NomCourt'];

      $req8 = $pdo->prepare("INSERT INTO `court` SET `NumCourt` = ?, TypCourt = ?, NomCourt = ?, `NatCourt` = ?, `PrixCourt` = ?");
      $req8->execute([$numcourt, $typcourt, $nomcourt, $natcourt, $prixcourt]);



      echo "<p class='warning'>Ajout de court effectué</p>";
    }




    ?>


    <form class="center" method="post" name="adminresa" action="index.php?page=admin">
      <input type="submit" class="lien bouton-co inline" name="submitresas" id="submitresas" value="RESERVATIONS" >
      <input type="submit" class="lien bouton-co inline" name="submitusers" id="submitusers" value="ADHERENTS" >
      <input type="submit" class="lien bouton-co inline" name="submitcourts" id="submitcourts" value="COURTS" >
    </form>
  </div>
  <div class="jump"></div>



  <?php

  /* ici on gère ce qui s'affiche en fonction du bouton sur lequel on a cliqué */

  if (isset ($_POST['submitresas'])) {

    $req = $pdo->prepare('SELECT * FROM resa WHERE Jours BETWEEN NOW() and adddate(NOW(), +8) ORDER BY Jours desc;');
    $req->execute(); // requête sur la bdd des toutes les résas à +7 jours
    $checkresas = $req->fetchAll(PDO::FETCH_OBJ);
    echo "<div class='cadre main txtcenter'><p>Planning J+7</p><fieldset><form name='suppresa' method='post' action='#'><table class='txtcenter'><tr class='note'><b><th>Date</th><th>Horaire</th><th>Terrain</th><th>Nom</th><th>Balles</th><th>Raquettes</th><th>Lumiere</th><th>Robot</th><th>Total de la réservation</th><th></th></b></tr>";

    if (empty($checkresas)) {
      echo "</table></form><p>Il n'y a rien cette semaine !</p>";
      exit();
    } else {

      foreach ($checkresas as $id => $checkresa) {
        $numadh = $checkresa->Num_adh;
        $req2 = $pdo->query("SELECT * FROM users WHERE Num_adh ='$numadh'");
        $checkadh = $req2->fetch(PDO::FETCH_OBJ);
        $numresa = $checkresa->NumResa;
        $dateresa = new DateTime($checkresa->Jours);
        $datecommande = new DateTime($checkresa->date_resa);
        $lum = $checkresa->Lum;
        $balles = $checkresa->balles;
        $raquettes = $checkresa->raquettes;
        $robot = $checkresa->robot;
        $prenomadh = $checkadh->Prenom_adh;
        $nomadh = $checkadh->Nom_adh;
        $numducourt = $checkresa->NumCourt;
        $req9 = $pdo->query("SELECT NomCourt FROM court WHERE NumCourt ='$numducourt'");
        $recupnom= $req9->fetch(PDO::FETCH_OBJ);
        $nomducourt = $recupnom->NomCourt;
        $req3 = $pdo->query("SELECT PrixCourt FROM court WHERE NumCourt ='$numducourt'");
        $prixcourtresa = $req3->fetch(PDO::FETCH_OBJ);
        $prixcourt = $prixcourtresa->PrixCourt;
        $prixresa = $prixcourt;
        if ($robot == 1) {$prixresa = ($prixresa + 20);};
        if ($lum == 1) {$prixresa = ($prixresa + 4);};
        if ($balles != 0) { $prixresa = ($prixresa + (1 * $balles));};
        if ($raquettes != 0) {$prixresa = ($prixresa + (5 * $raquettes));};




        echo "<tr class='note'><td>" . $dateresa->format('d-m-Y') . "</td><td>" . $checkresa->heures . "</td><td>".$nomducourt."</td><td>" . $prenomadh . " " . $nomadh . "</td><td>" . $balles . "</td><td>" . $raquettes . "</td><td>" . $lum . "</td><td>" . $robot . "</td><th>$prixresa €</th><td><input class='inline' type='checkbox' name='resa[$id]' value='$numresa'></td></tr>";
      }
    }
    echo "<tr><td colspan='5'></td><td colspan='3'><input type='submit' name='deleteresa' class='lienalt bouton-co right' value='Supprimer'></td></tr></table></fieldset></form>";

  };


  if (isset ($_POST['submitusers']) || isset($_POST['search'])) {

    echo "<div class='cadre main txtcenter'><fieldset><table class='txtcenter'><form name='useradmin' method='post' action='index.php?page=admin'><tr class='note'><b><th>Id</th><th>Nom</th><th>Date de naissance</th><th>Mail</th><th colspan='3'>Adresse</th><th>Inscription</th><th>Cotisation</th><th></th></b></tr>";

    if(isset($_POST['search']) && !empty($_POST['recherche'])) {
      $searchuser = [];
      $name = $_POST['recherche'];
      $req = $pdo->prepare("SELECT * FROM users WHERE Nom_adh LIKE :search OR Email LIKE :search");
      $req->execute([':search' => '%' . $name . '%']);
      $searchuser = $req->fetchAll(PDO::FETCH_OBJ);

      foreach ($searchuser as $user) {
        $dnuser = new DateTime($user->DNaiss_adh);
        $inscription = new DateTime($user->DFirst_adh);
        $cotisation = new DateTime($user->DLast_adh);
        $cotisationdisplay = $cotisation->format('d-m-Y');
        echo "<tr class='note'><td>" . $user->Num_adh . "</td><td>" . $user->Nom_adh . " " . $user->Prenom_adh . "</td><td>" . $dnuser->format('d-m-Y') . "</td><td>$user->Email<td>$user->Adr_adh</td><td>$user->Cp_adh</td><td>$user->Ville_adh</td><td>" . $inscription->format('d-m-Y') . "</td><td>$cotisationdisplay</td><td><input class='inline' type='radio' name='select_user' value='$user->Num_adh '></td></tr>";
      }

    } else {
      $req3 = $pdo->prepare('SELECT * FROM users ORDER BY Nom_adh desc;');
      $req3->execute(); // requête sur la bdd des toutes les résas à +7 jours
      $checkusers= $req3->fetchAll(PDO::FETCH_OBJ);

      foreach ($checkusers as $checkuser) {
        $id = $checkuser->Num_adh;
        $nomuser = $checkuser->Nom_adh;
        $prenomuser = $checkuser->Prenom_adh;
        $mailuser = $checkuser->Email;
        $adruser = $checkuser->Adr_adh;
        $cpuser = $checkuser->Cp_adh;
        $comuser = $checkuser->Ville_adh;
        $dnuser = new DateTime($checkuser->DNaiss_adh);
        $inscription = new DateTime($checkuser->DFirst_adh);
        $cotisation = new DateTime($checkuser->DLast_adh);
        $cotisationdisplay = $cotisation->format('d-m-Y');
        echo "<tr class='note'><td>" . $id . "</td><td>" . $prenomuser . " " . $nomuser . "</td><td>" . $dnuser->format('d-m-Y') . "</td><td>$mailuser<td>$adruser</td><td>$cpuser</td><td>$comuser</td><td>" . $inscription->format('d-m-Y') . "</td><td>$cotisationdisplay</td><td><input class='inline' type='radio' name='select_user' value='$id'></td></tr>";
      }
    }

    echo "<tr><br/></tr><tr><td colspan='10'><br/><br/><input class='inline' type='date' placeholder='date de cotisation' name='changer[DLast_adh]'><input class='inline' type='email' placeholder='mail' name='changer[Email]'><input class='inline' type='text' placeholder='adresse' name='changer[Adr_adh]'><input class='inline' type='text' placeholder='code postal' name='changer[Cp_adh]'><input class='inline' type='text' placeholder='commune' name='changer[Ville_adh]'></td><tr><td colspan='10'><input class='lienalt bouton-co right' type='submit' name='modif' value='Modifier'></form></td></tr>";
    echo "<tr><td colspan='7'><form method='POST' action='index.php?page=admin'><br/><label class='inline''>Recherchez un adhérent par son nom ou son mail </label></td><td colspan='3'><br/><input type='text' name='recherche'/></td><tr><td colspan='10'><input class='lienalt bouton-co right' type='submit' value='Rechercher' name='search'></form></td></tr></table></fieldset>";
  };

  if (isset ($_POST['submitcourts'])) {
    echo "<div class='cadre main txtcenter'><form name='courtadmin' method='post' action='index.php?page=admin'><fieldset><table class='txtcenter'><tr class='note'><b><th>Nom du court</th><th>Type</th><th>Surface</th><th>Prix / heure</th><th></th></b></tr>";
    $req6 = $pdo->query("SELECT * FROM court ORDER BY NumCourt");
    $courts = $req6->fetchAll(PDO::FETCH_OBJ);
    $count= count($courts) + 1;

    foreach ($courts as $court) {

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
      if ($typecourt == 'couvert' && $prixcourt >= 17) {
        $typecourt = "couvert olympique"; }
        elseif ($typecourt == 'externe' && $prixcourt > 11) {
          $typecourt = "extérieur avec toit";   }
          elseif ($typecourt == 'couvert' && $prixcourt >= 15) {
            $typecourt = "couvert climatisé";   }
            elseif ($typecourt == 'externe') {$typecourt = 'extérieur';}



            echo $row = "<tr class='note'><td>$nomcourt</td><td>$typecourt</td><td>$surfacecourt</td><td>$prixcourt € </td><td><input class='inline' type='radio' name='select_court' value='$numcourt'></td></tr>";
          }
          echo "<tr><td colspan='6'><br/><br/><input class='inline' type='hidden' min='$count' max='$count' value='$count' name='modif[NumCourt]'><input class='inline' type='text' placeholder='nom du court' name='modif[NomCourt]'><select class='inline'  name='modif[TypCourt]'><option value=''>Type</option><option value='couvert'>Couvert</option><option value='externe'>Extérieur</option></select><select class='inline'  name='modif[NatCourt]'><option value=''>Surface</option><option value='dur'>Dur</option><option value='terre_battue'>Terre battue</option><option value='resine'>Résine</option><option value='synthetique'>Synthétique</option><option value='gazon'>Gazon</option></select><input class='inline' type='number' placeholder='prix' name='modif[PrixCourt]'></td></tr>";
    echo "<tr><br/></tr><tr><td colspan='6'><input class='lienalt bouton-co inline' type='submit' name='modifcourt' value='Modifier'> <input class='lienalt bouton-co inline' type='submit' name='suppcourt' value='Supprimer'> <input class='lienalt bouton-co inline' type='submit' name='addcourt' value='Ajouter un court'></form></td></tr></table></fieldset>";
        }
        ?>



      </div>
    </div>
  </div>

  <footer>
    <?php

    include("body/footer.php");
    ?>
  </footer>
