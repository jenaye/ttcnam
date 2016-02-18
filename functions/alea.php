<?php
/*
class pour la clef aleatoire ( le token )
*/
class keys {

/*
 @param $length ( longueur de la clef)
 @return une clef alatoire qui prend l'alphabet et qui multiplie, puis mélange dans tous les sens
*/
public static function randomkey($length){

	return(substr(str_shuffle(str_repeat("abcdefghABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",$length)),0,$length));

					}

		}
?>
