<?php
if(isset($_SESSION['auth'])){
  $datauser = [];
  if(isset($_POST['recherche'])){

    $name = $_POST['recherche'];
    $req= $pdo->prepare("SELECT * FROM users WHERE Nom_adh LIKE :search OR Email LIKE :search");
    $req->execute([ ':search' => '%'.$name.'%']);
    $datauser = $req->fetchAll(PDO::FETCH_OBJ);

      // Si la demande est en ajax (version perso)
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'oui') {
          // On range dans un tableau les r�sultats pour les transformer en json objet
          // { success: true, users: [...] } compr�hensible par le js
          $result = [
              'success' => true, // Au cas ou :)
              'users' => $datauser
          ];

          header('Content-Type: application/json'); // On d�fini le json comme type de contenu (par d�faut c'est html)
          ob_get_clean();

          echo json_encode($result); // on affiche ce qui renvoie les donn�es au js
          exit;
      }

  }

}else{
  echo "<body class='x'>
			<div class='jumpco' role='espacement'>
			</div>

			<section class='main cadre txtcenter' role='presentation'>
			    <h3>Vous n'avez pas le droit d'accéder à cette page</h3>
				<p>Veuillez contacter un administrateur</p><br/>
				<img src='img/forbidden128.png'>
			    	</div>

		    </section>
			</body>'
      ";
      exit();

}
?><div class="page">
  <div class="doublejump" role="espacement">
  </div>

  <section class="main cadre" role="presentation">
    <div class="txtcenter">

      <p class="txtblanc txtcenter"><h3>Recherchez un ami</h3>
        Prennez un curly

      </p>
      <!--  FORMULAIRE RECHERCHE MAGGLE -->

      <form method="POST" action="index.php?page=recherche">

        <label>Veuillez indiquez le nom de famille de votre partenaire, ou son adresse mail </label>
        <input type="text" name="recherche" id="recherche" />
        <input type="submit">
      </form>

    </div><br/>
    <!-- AFFICHAGE DES RESULTATS -->
    <h4 class="txtcenter">Votre recherche concernant les adhérants</h4>
    <table class="txtcenter">
        <thead>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody id="resultat">
    <?php foreach($datauser as $user): ?>
        <tr>
            <td><?= $user->Num_adh ?></td>
            <td><?= $user->Nom_adh ?></td>
            <td><?= $user->Prenom_adh ?></td>
            <td><?= $user->Email ?></td>
        </tr>
    <?php endforeach; ?>
        </tbody>
    </table>                                                                                                                                                                                                                                                                                                                                                                                                                             





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

    </footer
