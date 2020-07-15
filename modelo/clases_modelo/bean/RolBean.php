<?php

class RolBean{
	private static $prefijo = "rl";
	private $id;
	private $descripcion;
	
	function __construct($input = null, $isJson = false){
		if($input !== null){
			$prefijo = "";
			
			if(! $isJson){
				$prefijo = self::$prefijo . ".";
			}
			
			$this->setId(isset($input[$prefijo . "id"]) ? $input[$prefijo . "id"] : "");
			$this->setDescripcion(isset($input[$prefijo . "descripcion"]) ? $input[$prefijo . "descripcion"] : "");
		}else{
			$this->id = "";
			$this->descripcion = "";
		}
	}
	
	public static function getPrefijo(){
		return self::$prefijo;
	} 
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getDescripcion(){
		return $this->descripcion;
	}
	
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	
	public function jsonSerialize(){
		$j = new stdClass();
		
		$j->id = intval($this->getId());
		$j->descripcion = $this->getDescripcion();
		
		return $j;
	}
}
