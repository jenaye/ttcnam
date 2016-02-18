 <?php
include 'functions/main-functions.php';
 ?>
 <?php
 	$pages = scandir('pages/');
 	if(isset($_GET['page']) && !empty($_GET['page'])){
 	  if(in_array($_GET['page'].'.php',$pages)){
 		   	$page = $_GET['page'];
       	}else{
          $page = "error";

   }
 }
  else{

    $page = "home";
  }

  $pages_functions = scandir('functions/');
  if(in_array($page.'.func.php',$pages_functions)) {

    include 'functions/'.$page.'.func.php';
  }
 ?><!DOCTYPE html>
  <html>
    <head>
      <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
      	<link rel="stylesheet" href="css/jquery-ui.css">
        <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
        <!-- télécharger la version jquery pour la mettre en local -->
        <script src="js/datepicker-fr.js"></script>
        <script src="js/recherche.js"></script>
      <link rel="icon" type="image/png" href="img/FaviconTTCNAM.png">
      <title>TTCNAM - Faux club de tennis</title>

      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta charset="UTF-8">
    </head>

    <body>
      <?php include 'body/background.php'; ?>
      <?php
      include 'body/topbar.php';

         if(isset($_COOKIE["visit_ttcnam"])) { }
      else {
          setcookie("visit_ttcnam", true, time()+7*60*24*600);
          require_once 'body/cookies.php';
      }
      ?>

      <div class="doublejump"></div>

    		<?php
        include 'pages/'.$page.'.php';
        ?>
    </body>
  </html>


  <!-- ALTER TABLE `users`
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
 pour lié le role_id de user a l'id de la table role
-->
