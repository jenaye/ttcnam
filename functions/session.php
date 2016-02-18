<?php

/*
class Session qui permet de verifier, ecraser, et crée une session
*/
	 class Session{

    /*
    @return session démarrer
    */

	 	public static function start(){
	 		// on utilise self au lieu de $this psk c'est function static
          if (!headers_sent() && !self::checksession()) {
          	// si les headers sont pas envoyé on commence la session
            session_start();
          }

	 	}

    /*
    @return session lancer ou pas ?
    */
	 	private static function checksession(){
	 		// on verifie si il existe une session
	 		return(!(session_status() == PHP_SESSION_NONE));
	 	}

    /*
    @return Session détruite
    */
      	public static function destroy(){
      		// pour la deconnnexion, on détruit toute la session
          	self::start();
	 					session_destroy();
          	unset($_SESSION);


          	}
      }
