<div class="page">
    <div class="cadre main txtcenter">
        <p>Commande bien prise en compte. Vous avez 24h pour l'annuler depuis votre compte.</p>
        <a class='lien bouton-co large padding' href='index.php?page=profil'><small>Mon compte</small></a>

<?php

if (!isset ($_SESSION['auth']->Num_adh) || !isset ($_SESSION['dateresa']) || !isset ($_SESSION['horaireresa'])) {
    header('Location:index.php?page=reservation');
    exit();
}
$num_adh = $_SESSION['auth']->Num_adh;
$dateresa = new DateTime($_SESSION['dateresa']);
$horaireresa = $_SESSION['horaireresa'] ;
$datefinale = date_format($dateresa, "Y-m-d");
if (isset($_POST['num_court'])) {
    $num_court = $_POST['num_court'];
}
$req1 = $pdo->prepare('SELECT PrixCourt, NomCourt FROM court WHERE NumCourt ='.$num_court);
$req1->execute();// requête sur la bdd de toutes les infos de la table contenant les courts
$infocourt = $req1->fetch(PDO::FETCH_OBJ);
$prixcourt = $infocourt->PrixCourt;
$nomcourt = $infocourt->NomCourt;
$prixresa = $prixcourt;


function horaire($valeur) // on crée une fonction pour afficher plus proprement les créneaux horaires
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
    echo "<p>Le : ". date_format($dateresa, "d-m-Y")."</p>";
    echo "<p>Horaire : ". horaire($horaireresa)."</p>";


if (isset ($num_court)) {
        echo "<p>Court ".$nomcourt."</p>";
};




if (isset ($_POST['raquette'])) {
    $raquettes = ($_POST['raquette']);
    echo "<p>Raquettes : ".$raquettes."</p>";
    $prixresa = ($prixresa + (5 * $raquettes));
};

if (isset ($_POST['robot'])) {
    $robot = 1;
    echo "<p>+ Robot lanceur de balles</p>";
    $prixresa = ($prixresa + 30);
} else {
    $robot = 0;
};

if (isset ($_POST['balle'])) {
    $balles = ($_POST['balle']);
    $totalballes = $balles;
    if (isset ($_POST['robot'])) {
        $totalballes = $balles + 10;
    }
    echo "<p>Balles : ".$totalballes."</p>";
    $prixresa = ($prixresa + (1 * $balles));
};

if (isset ($_POST['lighton'])) {
    $lumiere = 1;
    echo "<p>+ Projecteurs</p>";
    $prixresa = ($prixresa + 4);
} else {
    $lumiere = 0;
};

echo "<p class='warning'>Total de la réservation :". $prixresa."  </p>";

if(isset($_POST["resapaiement"])) { // si l'utilisateur a cliqué sur le bouton Payer, on inscrit toutes les informations saisies dans la table resa
    $req = $pdo->prepare("INSERT INTO resa SET NumCourt ='$num_court', Num_adh = '$num_adh', Jours = '$datefinale',  heures = '$horaireresa', Lum = '$lumiere', balles = '$totalballes', raquettes = '$raquettes', robot = '$robot', date_resa=NOW();");
    $req->execute();
  $to = $_SESSION['auth']->Email;
   $sujet ="Réservation paiment";
   $dateresaok = date_format($dateresa, "d-m-Y");
   $message="confirmation de votre réservation au TTCNAM le : $dateresaok, de : $horaireresa h, je vous rappel que le prix est de : $prixresa €";
   mail($to,$sujet,$message);
}

unset ($_SESSION['horaireresa']);
unset ($_SESSION['dateresa']);


include("body/footer.php");

?>
