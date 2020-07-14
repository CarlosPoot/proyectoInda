<?php
class AutenticacionController{
    
    function __construct(){
		$s = new Session();
		if(! $s->isOpen()){
			header('HTTP/1.0 403 Forbidden');
		}else{
			if($s->getVariableSesion(Constantes::$ID_SESSION) == "" ||
					$s->validarTiempo() == false){
						$s->cerrarSesion();
						header('HTTP/1.0 403 Forbidden');
			}else{
				$s->setTime();
			}
		}
	}
}