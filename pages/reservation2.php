
<?php
if (!isset ($_POST["horaireresa"]) || !isset ($_POST["dateresa"])) {
    header('Location:index.php?page=reservation');
    exit();
}
$_SESSION['dateresa'] = $_POST["dateresa"];
$_SESSION['horaireresa'] = $_POST["horaireresa"];
$horaireresa = $_SESSION['horaireresa'] ;
$dateresa = new DateTime($_SESSION["dateresa"]);
// on affecte des variables aux données récupérées dans le premier formulaire
 // et on les stocke dans la session
$today = date_create();
if ($dateresa < $today) {
   echo "<div class='warning cadreerreur bgjaune txtcenter'>Veuillez choisir une date dans les sept jours à venir ! <a href='index.php?page=reservation'>Retour</a> </div>";
    die();
}

if (date('w', strtotime($_POST["dateresa"])) == 0 && ($horaireresa == "18_19" || $horaireresa == "19_20" || $horaireresa == "20_21" || $horaireresa == "21_22")) {
    echo "<div class='warning cadreerreur bgjaune txtcenter'>Le TTCNAM est fermé à l'horaire choisi ! <a href='index.php?page=reservation'>Retour</a> </div>";
    die();
}



$req1 = $pdo->prepare('SELECT * FROM court');
$req1->execute();// requête sur la bdd de toutes les infos de la table contenant les courts
$req2 = $pdo->prepare('SELECT * FROM resa WHERE Jours BETWEEN NOW() and adddate(NOW(), +8) ORDER BY Jours desc;');
$req2->execute(); // requête sur la bdd des toutes les résas à +7 jours


$checkcourt = $req1->fetchAll(PDO::FETCH_OBJ); // on exécute les requêtes
$checkresas = $req2->fetchAll(PDO::FETCH_OBJ); // et on affecte des variables aux résultats



function horaire($valeur) //on crée une fonction pour afficher plus proprement les créneaux horaires
{
    $tablehoraires = array(
        "8_9" => "8h - 9h",
        "9_10" => "9h - 10h",
        "10_11" => "10h - 11h",
        "11_12" => "11h - 12h",
        "12_13" => "12h - 13h",
        "13_14" => "13h - 14h",
        "14_15" => "14h - 15h",
        "15_16" => "15h - 16h",
        "16_17" => "16h - 17h",
        "17_18" => "17h - 18h",
        "18_19" => "18h - 19h",
        "19_20" => "19h - 20h",
        "20_21" => "20h - 21h",
        "21_22" => "21h - 22h",
    );
    return $tablehoraires["$valeur"];

};


$courts = array( // on crée le tableau depuis lequel on va afficher les courts

    1 => "<option name='court[1]' value='1'><b>Djokovic</b> - <small>Couvert climatisé - Terre battue - 15 €/h</small></option>",
    2 => "<option  name='court[2]' value='2'><b>Murray</b> - <small>Couvert climatisé - Résine - 16 €/h</small></option>",
    3 => "<option  name='court[3]' value='3'><b>Nishikori</b> - <small>Couvert olympique - Synthétique - 17 €/h</small></option>",
    4 => "<option  name='court[4]' value='4'><b>Berdych</b> - <small>Extérieur - Dur - 8 €/h</small></option>",
    5 => "<option  name='court[5]' value='5'><b>Raonic</b> - <small>Extérieur - Dur - 8 €/h</small></option>",
    6 => "<option  name='court[6]' value='6'><b>Federer</b> - <small>Extérieur - Terre battue - 10 €/h</small></option>",
    7 => "<option  name='court[7]' value='7'><b>Ferrer</b> - <small>Extérieur - Terre battue - 10 €/h</small></option>",
    8 => "<option   name='court[8]' value='8'><b>Anderson</b> - <small>Extérieur - Terre battue - 10 €/h</small></option>",
    9 => "<option  name='court[9]' value='9'><b>Nadal</b> - <small>Extérieur avec toit - Dur - 12 €/h</small></option>",
    10 => "<option   name='court[10]' value='10'><b>Wawrinka</b> - <small>Extérieur avec toit - Gazon - 14 €/h</small></option>",
);


foreach ($checkresas as $checkresa) { // pour chaque réservation dans la bdd...
    $dateformat = date_create($checkresa->Jours); // on récupère la date de résa et on s'assure que les formats de date
    $dateprise = date_format($dateformat, "Y-m-d"); // sont compatibles pour pouvoir les comparer...
    $heureprise = $checkresa->heures; // on récupère l'heure de la réservation...
    $courtpris = $checkresa->NumCourt; // on récupère le numéro du court réservés...
    if ($dateprise == (date_format($dateresa, 'Y-m-d')) && $heureprise == $horaireresa) { // si la  date et l'heure choisies par l'utilisateur sont déjà dans la bdd...
        unset($courts[$courtpris]); // on enlève le court correspondant de la liste des courts
    };
};

?>

<body>
<div class="page">
    <div class="cadre main txtcenter">

        <?php       echo "<p class='txtcenter'><b>Date choisie : </b>".date_format($dateresa, 'd-m-Y'); // on affiche les infos date et horaires qui ont été
                    echo " -<b> Créneau choisi : </b>".horaire($horaireresa)."</p>"; // récupérés dans le formulaire précédent
                    echo "<br/><form method='POST' action='index.php?page=reservation' name='back'><input class='lien bouton-co right' type='submit' value='Modifier ma réservation'></form>"
        ?>
    </div><br/>
    <div class="cadre main txtcenter">
                <p class="exergue">Quel court souhaitez-vous prendre ?</p><br/>

                <table>
                    <form method='POST' action='index.php?page=reservation3' name='resasuite'>
                      <tr> <td><label>Choisir un court disponible :</label></td>
                      <td class='right'>
                          <select class='champ txtcenter' name='num_court' required>
                              <?php

                              foreach ($courts as $court) { // on affiche les éléments du tableau courts
                                  echo $court;
                                };
                              ?>
                          </select>
                     </td>

                    <tr>
                        <td><label for="balle"> Louer des balles <small>(1€ pièce/h)</small> :</label></td>
                            <td><input class="main champ right txtcenter" type="number" name="balle"  min="0" max="10"></td></tr>

                    <tr>
                        <td><p><label for="raquette"> Louer des raquettes <small>(5€ pièce/h)</small> :</label></td>
                            <td><input class="main champ right txtcenter" type="number" name="raquette"  min="0" max="4"></td></tr>


                    <tr>
                        <td><p>Utiliser un robot lanceur de balles <small>(30€/h)</small> </td>
                            <td> <p class="txtcenter"><input type="checkbox" name="robot"></p></td></tr>

                    <tr>
                        <td><p>Ajouter des spots d'éclairage supplémentaire <small>(4€/h)</small> </td>
                            <td> <p class="txtcenter"><input type="checkbox" name="lighton" value="1"></p></td></tr>



                <tr><td colspan="2"> <br><input class="lienalt bouton-co right" type="submit" name="resapaiement" value="Confirmer et payer"></td></tr>
              </form>
         </table>





    </div>
</div>


<footer>
    <?php

    include("body/footer.php");
    ?>

</footer>
