<!-- Clase para realizar conexiones a la base de datos -->
<?php
class Conexion extends PDO {

    private $transactionCount = 0;
    private $isUncommitable = true;
    
    public function __construct() {
		$servidor = Config::$SERVIDOR;
		$base = Config::$BASE;
		$usuarioBase = Config::$USUARIO_BASE;
        $pass = Config::$CONTRASENA_BASE;
		try {
            
            parent::__construct ( 'mysql:host=' . $servidor . ';dbname=' . $base . ';charset=utf8', $usuarioBase, $pass, array (
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'" 
            ));
            
		} catch ( PDOException $e ) {
			$resultado = new stdClass();
			$resultado->success = false;
			$resultado->mensaje = "Error al conectar con la base de datos";
			$resultado->codigoError = 3;
			$respuesta = json_encode ( $resultado );
			echo $respuesta;
			die();
		}
    }
    
    public function isCommitable() {
		return ($this->transactionCount > 0) && ! $this->isUncommitable;
    }
    
	public function beginTransaction() {
		$return = true;
		if (! $this->transactionCount) {
			$return = parent::beginTransaction ();
			$this->isUncommitable = false;
		}
		$this->transactionCount ++;
		return $return;
    }
    
	public function commit() {
		$return = true;
		if ($this->transactionCount > 0) {
			if ($this->transactionCount === 1) {
				if ($this->isUncommitable) {
					
					throw new Exception ( 'No es posible asegurar la transaccion' );
				}
				$return = parent::commit ();
			}
			$this->transactionCount --;
		}
		return $return;
    }
    
	public function rollBack() {
		$return = true;
		if ($this->transactionCount > 0) {
			if ($this->transactionCount === 1) {
				$return = parent::rollBack ();
			} else {
				$this->isUncommitable = true;
			}
			
			$this->transactionCount --;
		}
		return $return;
	}
    
    public function forceRollBack() {
		$return = true;
		
		if ($this->transactionCount) {
			$return = parent::rollBack ();
			$this->transactionCount = 0;
		}
		
		return $return;
	}

}
