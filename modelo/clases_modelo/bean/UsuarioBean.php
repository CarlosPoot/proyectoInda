<?php
class UsuarioBean{
	private static $prefijo = "usr";
	private $id;
	private $nombre;
	private $usuario;
	private $contrasena;
    private $roles;
    private $oficina;
	private $status;
	
	function __construct($input = null, $isJson = false){
		if($input !== null){
			$prefijo = "";
			if(!$isJson){
                $prefijo = self::$prefijo . ".";
                $this->setOficina(new OficinaBean($input));
			}else{
                $this->setOficina( isset($input[$prefijo . "oficina"]) ? new OficinaBean($input[$prefijo . "oficina"], true) : new OficinaBean());
            }
			
			$this->setId(isset($input[$prefijo . "id"]) ? $input[$prefijo . "id"] : "");
			$this->setNombre(isset($input[$prefijo . "nombre"]) ? $input[$prefijo . "nombre"] : "");
			$this->setUsuario(isset($input[$prefijo . "usuario"]) ? $input[$prefijo . "usuario"] : "");
			$this->setContrasena(isset($input[$prefijo . "contrasena"]) ? $input[$prefijo . "contrasena"] : "");
            $this->setStatus(isset($input[$prefijo . "status"]) ? $input[$prefijo . "status"] : "");
            
			$r = array();
			if(isset($input[$prefijo . "roles"]) && is_array($input[$prefijo . "roles"])){
				foreach($input[$prefijo . "roles"] as $rol){
					$r[] = new RolBean($rol, $isJson);
				}
			}
			
			$this->setRoles($r);
		}else{
			$this->id = "";
			$this->nombre = "";
			$this->usuario = "";
			$this->contrasena = "";
			$this->roles = array();
            $this->status = "";
            $this->oficina = new OficinaBean();
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

	public function getNombre(){
        return $this->nombre;
    }

	public function setNombre($nombre){
        $this->nombre = $nombre;
    }

	public function getUsuario(){
        return $this->usuario;
    }

	public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

	public function getContrasena(){
        return $this->contrasena;
    }

	public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }
    
	public function getRoles(){
        return $this->roles;
    }

	public function setRoles($roles){
        $this->roles = $roles;
    }
    
    public function setRol($rol){
        $this->roles[] = $rol;
    }
    
	public function getStatus(){
        return $this->status;
    }

	public function setStatus($status){
        $this->status = $status;
    }
    
    public function getOficina(){
        return $this->oficina;
    }

	public function setOficina($oficina){
        $this->oficina = $oficina;
    }
	
	public function jsonSerialize($dataset = 0){
        $roles = array();
        foreach( $this->getRoles() as $rol ){
            $roles[] = $rol->jsonSerialize();
        }

		$j = new stdClass();
		$j->id = intval($this->getId());
		$j->nombre = $this->getNombre();
		$j->usuario = $this->getUsuario();
        $j->status = $this->getStatus();
        $j->oficina = $this->getOficina()->jsonSerialize();
        $j->roles = $roles;
		return $j;
	}
}

