<?php
class LoginController extends AutenticacionController{
	
	function __construct(){
		$P = new HttpInput();
		if($P->string('metodo') == "iniciarSesion"){
			return;
		}else{
			parent::__construct();
		}
	}
	
	public function iniciarSesion(){
		$P = new HttpInput();
		$respuesta = new stdClass();
		$conexion = new Conexion();
		$usuarioDao = new UsuarioDao($conexion);
		$u = $usuarioDao->getByUsuarioContrasena($P->string('usuario'), $P->string('contrasena'));
		
		if($u instanceof UsuarioBean){
			if($u->getId() != ""){
				$status = $u->getStatus();
				if($status["id"] == Constantes::$USUARIO_ACTIVO){
					
                    $sesion = new Session();
                    $sesion->iniciarSesion($u->getId());
                    $respuesta->success = true;
                    $respuesta->respuesta = true;
					
				}else{
					$respuesta->success = false;
					$respuesta->respuesta = false;
					$respuesta->mensaje = "Su usuario esta inactivo.";
				}
			}else{
				$respuesta->success = false;
				$respuesta->respuesta = false;
				$respuesta->mensaje = "Usuario y/o contraseña incorrectos.";
			}
			return $respuesta;
		}
		
		$respuesta->success = false;
		$respuesta->respuesta = false;
		$respuesta->mensaje = $usuarioDao->getError();
		return $respuesta;
	}

	public function getUsuarioLogueado(){
        $sesion = new Session();
		$respuesta = new stdClass();
        if( $sesion->isOpen() ){

            $respuesta->success = true;
            $respuesta->usuario = $sesion->getIdSesion();
            $respuesta->timeout = $sesion->getTimeOut();
            $respuesta->tiempoSesion = date('H:i:s', $sesion->getVariableSesion(Constantes::$ID_SESSION . "_TIME"));
            $respuesta->respuesta = true;
            return $respuesta;

        }else{
            $sesion->cerrarSesion();
            $respuesta->success = true;
            $respuesta->respuesta = false;
            return $respuesta;
        }
	}

	public function cerrarSesion(){
		$sesion = new Session();
		$respuesta = new stdClass();
		
		if($sesion->isOpen()){
			$sesion->cerrarSesion();			
		}
		
		$respuesta->success = true;
		$respuesta->respuesta = true;
	}
}