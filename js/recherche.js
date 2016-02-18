$(function() {
  var recherche = $('#recherche');
  var resultat = $('#resultat');

  recherche.on('keyup', function(event) {

    var rec = recherche.val();

    if (rec.length >= 3) {

      $.post('index.php?page=recherche', {
        recherche: rec,
        ajax: 'oui'
      }, function(dataResult) {

        if (dataResult && dataResult.success) {
          resultat.empty();
          for (var i = 0; i < dataResult.users.length; i++) {
            var ligne = dataResult.users[i];


            var $tdNum = $('<td>' + ligne.Num_adh + '</td>');
            var $tdNom = $('<td>' + ligne.Nom_adh + '</td>');
            var $tdPrenom = $('<td>' + ligne.Prenom_adh + '</td>');
            var $tdEmail = $('<td>' + ligne.Email + '</td>');

            var $tr = $('<tr></tr>');
            $tr.append($tdNum);
            $tr.append($tdNom);
            $tr.append($tdPrenom);
            $tr.append($tdEmail);


            resultat.append($tr);
          }
        }
      }, 'json');
    }


  });
});
