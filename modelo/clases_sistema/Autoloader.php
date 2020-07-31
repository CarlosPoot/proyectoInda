<?php
class Autoloader {
    
    private static $prefijo = "";
    private static $MIS_ARCHIVOS = array(
        "Conexion"                  => "clases_sistema/Conexion.php",
        "Config"                    => "clases_sistema/Config.php",
        "Constantes"                => "clases_sistema/Constantes.php",
        "Session"                   => "clases_sistema/Session.php",
        'Http' 						=> 'clases_sistema/Http.php',
		'HttpInput' 				=> 'clases_sistema/HttpInput.php',
		'HttpPost'					=> 'clases_sistema/HttpPost.php',
		'HttpGet' 					=> 'clases_sistema/HttpGet.php',
        "Menu"                      => "clases_sistema/Menu.php",
        "Utilidades"                => "clases_sistema/Utilidades.php",
        'AutenticacionController'	=> 'clases_controlador/AutenticacionController.php',
        'LoginController'	        => 'clases_controlador/LoginController.php',
        'ClienteController'	        => 'clases_controlador/ClienteController.php',
        'UsuarioBean' 				=> 'clases_modelo/bean/UsuarioBean.php',
        'RolBean' 				    => 'clases_modelo/bean/RolBean.php',
        'OficinaBean' 				=> 'clases_modelo/bean/OficinaBean.php',
        'ClienteBean' 				=> 'clases_modelo/bean/ClienteBean.php',
        'Dao' 					    => 'clases_modelo/dao/Dao.php',
        'UsuarioDao' 				=> 'clases_modelo/dao/UsuarioDao.php',
        'ClienteDao' 				=> 'clases_modelo/dao/ClienteDao.php',
    );

    public function __construct( $prefijo = "" ){
        self::$prefijo = $prefijo;
        spl_autoload_register(array($this, 'load'));
    }

    private function load($className){
		$file = '';
		if(isset(self::$MIS_ARCHIVOS[$className])){
			$file = self::$prefijo . self::$MIS_ARCHIVOS[$className];
			if($file != '' && file_exists($file)){
				if(!class_exists($className, false)){
					include($file);
                }
			}elseif(sizeof(spl_autoload_functions()) == 1){
				$respuesta = new stdClass();
				$respuesta->success = false;
				$respuesta->mensaje = "Error al cargar clase ". $className;
				echo json_encode($respuesta);
				exit();
			}
        }
    }

}