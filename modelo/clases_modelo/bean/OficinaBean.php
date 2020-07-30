<?php
class OficinaBean{
    private static $prefijo = "ofc";
    
    private $id;
    private $ubicacion;
    private $oficina;

    function __construct($input = null, $isJson = false){
		if($input !== null){
			$prefijo = "";
			if(!$isJson){
                $prefijo = self::$prefijo . ".";
                $this->setUbicacion(new UbicacionBean($input));
			}else{
                $this->setUbicacion( isset($input[$prefijo . "ubicacion"]) ? new UbicacionBean($input[$prefijo . "ubicacion"], true) : new UbicacionBean());
            }
			
			$this->setId(isset($input[$prefijo . "id"]) ? $input[$prefijo . "id"] : "");
			$this->setOficina(isset($input[$prefijo . "oficina"]) ? $input[$prefijo . "oficina"] : "");
			
            
			/**$r = array();
			if(isset($input[$prefijo . "roles"]) && is_array($input[$prefijo . "roles"])){
				foreach($input[$prefijo . "roles"] as $rol){
					$r[] = new RolBean($rol, $isJson);
				}
			}
			
			$this->setRoles($r);**/
		}else{
			$this->id = "";
			$this->oficina = "";
			
            $this->ubicacion = new UbicacionBean();
        }
    }
    
    public function getOficina(){
        return $this->oficina;
    }

	public function setOficina($oficina){
        $this->oficina = $oficina;
    }
	
}