<?php
/*
class form qui me permet de creer des formulaires rapidement

*/

class Form{
	/*
	* @param $name 
	* @return un formulaire avec name=""
	*/
	public function input($name){
		echo '<input type="text" name="'.$name.'">';
	}

	/*
	@return bouton simple
	*/

	public function btn(){
		echo '<input type="submit">';
			}
}

/*
<form action="" method="POST">
<?php 
require 'functions/formulaire.php';
		$form = new Form($_POST);
		$boom = $_POST['lol'];
		echo $form->input('lol');
		echo $form->btn();
		echo $boom;
?>
</form>

*/