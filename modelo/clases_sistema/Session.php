<?php
class Session{

    private $idSesion;
    private $timeSesion;
    private static $band = false;
	private static $timeoutSeconds = 1800;

    function __construct(){
        $this->idSesion = Constantes::$ID_SESSION;
        if(self::$band == false){
			session_set_cookie_params(36000);
			session_start();
			self::$band = true;
		}
    }

    public function iniciarSesion( $id  ){
        $_SESSION[$this->idSesion] = $id;
        $this->setTime();
    }

    public function isOpen(){
        return isset($_SESSION[$this->idSesion]);
        // $_SESSION["USR_PORTAL"] ???
	}

    public function setTime(){
		$_SESSION[Constantes::$ID_SESSION . "_TIME"] = time();
    }

    public function getTime(){
		return isset($_SESSION[Constantes::$ID_SESSION . "_TIME"]) ? $_SESSION[Constantes::$ID_SESSION . "_TIME"] : 0;
	}
    
    public function validarTiempo(){
		$t1 = $_SESSION[Constantes::$ID_SESSION . "_TIME"];
		$t2 = time();
		
		if(($t2 - $t1) > self::$timeoutSeconds){
			return false;// EXPIRO EL TIEMPO PERMITIDO
		}else{
			$this->setTime(); // RENUEVA EL TIEMPO DE SESIÓN
			return true;
		}
	}

}