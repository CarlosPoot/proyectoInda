<?php
class Dao{
	private $error;
	private $codigoError;
	protected $conexion;
	
	function __construct(Conexion $conexion){
		$this->conexion = $conexion;
		$this->error = "";
	}
	
	public function getError(){
		return $this->error;
	}
	
	public function setError($error){
		$this->error = "Ocurrió un error al realizar transacción. Detalles: \n" . $error;
	}
	
	public function setErrorValidacion($error){
		$this->error = $error;
	}
	
	public function getCodigoError(){
		return $this->codigoError;
	}
	
	public function setCodigoError($codigo){
		$this->codigoError = $codigo;
	}
}
