<?php
class ClienteController {
	    	
	public function crearCliente(){
		$respuesta = new stdClass();
		$input     = new HttpInput();
		$conexion  = new Conexion();
		$clienteDao = new ClienteDao($conexion);
		
        if( !$input->defined('cliente') ){
            $respuesta->success = false;
            $respuesta->mensaje = "Parametros Invalidos";
            return $respuesta;
        }

        $cliente = new ClienteBean($input->raw('cliente'), true);
		$guardarCliente = $clienteDao->crearCliente($cliente);
		if($guardarCliente !== false){
            $respuesta->success = true;
            $respuesta->mensaje = "Cliente guardado exitosamente";
		}else{
			$respuesta->success = false;
			$respuesta->mensaje = $clienteDao->getError();
		}
		return $respuesta;
    }
    
    public function getClientes(){
        $respuesta  = new stdClass();
        $input      = new HttpInput();
        $conexion   = new Conexion();
        $clienteDao = new ClienteDao($conexion);
        $registros  = $clienteDao->getClientes( $input );

        if( $registros !== false  ){
            $totalRegistros = true;
            // $totalRegistros = $monitorDao->getTotalRegistros( $input );
            if( $totalRegistros !== false ){
                $tem = array();
                foreach(  $registros as $r ){
                    $tem[] = $r->jsonSerialize();
                }

                $respuesta->success = true;
                $respuesta->registros = $tem;
                $respuesta->totalRegistros = 1000;
            }else{
                $respuesta->success = false;
                $respuesta->mensaje = $monitorDao->getError();
            }
        }else{
            $respuesta->success = false;
            $respuesta->mensaje = $monitorDao->getError();
        }

        return $respuesta;
    }
    
}