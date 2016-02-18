<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
    <link rel="icon" type="image/png" href="img/FaviconTTCNAM.png">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <title>TTCNAM - Reservation</title>

</head>
<body>
<div class="page">
    <div class="cadre main txtcenter">
        <p class="exergue">RESERVATION</p>
        <p class="exergue">Quand voulez-vous jouer ?</p>

<?php

/* ici on a la premiere partie du formulaire o� on demande la date, en fonction on propose les cr�neaux horaires, puis on envoie vers reservation2
qui check les courts dispos */

if(!isset($_SESSION['auth'])){ // si pas identifi�, redirection vers page connexion
    header('Location:index.php?page=connexion');
    exit();
}
else {
    require_once 'functions/main-functions.php';
}
?>
  <form class="center" method="post" name="formresa" action="index.php?page=reservation2">
            <table class="main">
               <tr class="txtcenter"><td><label for="datepicker">Choisir la date dans les 7 prochains jours :</label><br/><br/></td></tr>
                   <tr class="txtcenter"><td> <input class="champ main large txtcenter" type="date" name="dateresa" id="datepicker" required onchange="suite(this.value)"/><br/><br/></td>
               </tr></table>
            <table class="col main" id="horairepick">
                <tr class=""><td class="txtcenter"><label for="horaireresa">Choisir l'horaire :</label><br/><br/></td></tr>
                <tr class=""><td class=><select id="tranches_horaires" size="14" name="horaireresa" onchange="validateForm(this.value)" required disabled>
                <option class="display txtcenter large" value="defaut">Choisir</option>
                <option class="display txtcenter large" value="8_9"> 8H00 - 9H00</option>
                <option class="display txtcenter large" value="9_10">9H00 - 10H00</option>
                <option class="display txtcenter large" value="10_11">10H00 - 11H00</option>
                <option class="display txtcenter large" value="11_12">11H00 - 12H00</option>
                <option class="display txtcenter large" value="12_13">12H00 - 13H00</option>
                <option class="display txtcenter large" value="13_14">13H00 - 14H00</option>
                <option class="display txtcenter large" value="14_15">14H00 - 15H00</option>
                <option class="display txtcenter large" value="15_16">15H00 - 16H00</option>
                <option class="display txtcenter large" value="16_17">16H00 - 17H00</option>
                <option class="display txtcenter large"  value="17_18">17H00 - 18H00</option>
                <option class="cache txtcenter large" value="18_19">18H00 - 19H00</option>
                <option class="cache txtcenter large" value="19_20">19H00 - 20H00</option>
                <option class="cache txtcenter large" value="20_21">20H00 - 21H00</option>
                <option class="cache txtcenter large" value="21_22">21H00 - 22H00</option>
                </select><br/><br/></td></tr>
               </tr>
            </table>
            <table class="main">

                <tr>
                 <br/><br/>
                 <td colspan="2"><input type="submit" class="lien bouton-co right" name="horairesubmit" id="horairesubmit" value="Suite" ></td>
               </tr>
            </table>
        </form>
    </div>
</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/datepicker-fr.js"></script>

<script  type="text/javascript">
    $(function() { // calendrier en jquery
        $( "#datepicker" ).datepicker({
            minDate: 0,
            maxDate: "+7D",
            dateFormat: 'yy-mm-dd'
        });
    });

</script>


<script  type="text/javascript">
    function suite(date) { // en fonction des dates dans le calendrier, on modifie les attributs css pour cacher ou non les horaires


        var dateRez = new Date(date);
        var intRez = dateRez.getTime();
        var today = new Date();
        var intToday = today.getTime();
        var todayPlusWeek = intToday + 691200000;

        var tranches_horaires = document.getElementById("tranches_horaires");

        tranches_horaires.disabled = (intRez > todayPlusWeek);

        var y = document.getElementById("horairepick");
        y.style.display = "block";

        if (dateRez.getDay() == 0) {
            var horaires = document.querySelectorAll(".cache");
            var size = horaires.length;

            for (var i = 0; i < size; i += 1) {
                var horaire = horaires[i];
                horaire.style.display = "none";
            }

        } else {
            var horaires2 = document.querySelectorAll(".cache");
            var size2 = horaires2.length;

            for (var j = 0; j < size2; j += 1) {
                var horaire2 = horaires2[j];
                horaire2.style.display = "block";
            }
        }
    }

    function validateForm() {

            var y = document.getElementById("horairesubmit");
            y.style.display = "block";


    }
</script>


<footer>
    <?php

    include("body/footer.php");
    ?>

</footer>


</body>

</html>
