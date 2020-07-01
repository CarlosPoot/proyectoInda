<?php
//error_reporting(E_ERROR | E_CORE_ERROR);
include 'clases_sistema/Autoloader.php';
set_time_limit(0);

new Autoloader();
$p = new HttpInput();

if($p->defined('controlador') == false){
	$p = new HttpPost();
}

if($p->defined('controlador') && $p->defined('metodo')){
	try{
		$claseControlador = $p->string('controlador') . "Controller";
		$instanciaControlador = new $claseControlador();
		$metodo = $p->string('metodo');
		if(method_exists($instanciaControlador, $metodo)){
			$respuesta = $instanciaControlador->$metodo();
		}
		else {
			$respuesta = new stdClass();
			$respuesta->success = false;
			$respuesta->mensaje = "Parametros Invalidos";
		}
	}catch(Exception $e){
		$respuesta = new stdClass();
		$respuesta->success = false;
		$respuesta->mensaje = $e->getMessage();
	}
}else{
	$respuesta = new stdClass();
	$respuesta->success = false;
	$respuesta->mensaje = "Parametros Invalidos.";
}

echo json_encode($respuesta);