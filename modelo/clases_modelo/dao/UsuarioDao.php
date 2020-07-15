<?php

class UsuarioDao extends Dao{
    
    public function getById($id){
		$pu = UsuarioBean::getPrefijo();
		$rl = RolBean::getPrefijo();
		$ub = UbicacionBean::getPrefijo();
		$sql = "SELECT  u.id_usuario AS '$pu.id',
						u.nombre AS '$pu.nombre',
						u.usuario AS '$pu.usuario',
						u.status AS 'status',
						ub.id_ubicacion AS '$ub.id',
                        ub.descripcion AS '$ub.descripcion',
                        rl.id_rol as '$rl.id', 
						rl.descripcion AS '$rl.descripcion'
				FROM usuario u
                INNER JOIN ubicacion ub ON ub.id_ubicacion = u.id_ubicacion
                INNER JOIN rol_usuario ru ON ru.id_usuario = u.id_usuario
                INNER JOIN rol rl ON rl.id_rol = ru.id_rol
				WHERE u.id_usuario = :id_usuario;";
	
		try{

			$st = $this->conexion->prepare($sql);
			$st->bindValue(':id_usuario', $id, PDO::PARAM_INT);
			$u = new UsuarioBean();
			if($st->execute()){
                $inicial = true;
                while($input = $st->fetch(PDO::FETCH_ASSOC)){
                    if( $inicial ){
                        $input["$pu.status"] = $this->getStatus($input["status"]);
                        $u = new UsuarioBean($input);
                        $u->setRol( new RolBean(  $input  ) );
                        $inicial = false;
                    }else{
                        $u->setRol( new RolBean(  $input  ) );
                    }
				}
                return $u;   
			}
				
			$error = $st->errorInfo();
			$this->setError($error[2]);
			return false;
		}catch(PDOException $e){
			$this->setError($e->getMessage());
			return false;
		}
	}


	public function getByUsuarioContrasena($usuario, $contrasena){
		$pu = UsuarioBean::getPrefijo();
		$sql = "SELECT u.id_usuario AS '$pu.id',
						u.nombre AS '$pu.nombre',
						u.usuario AS '$pu.usuario',
						u.status AS 'status'
				FROM usuario u 
				WHERE u.usuario = :usuario 
					AND u.password = SHA1(:contrasena);";
		
		try{
			$st = $this->conexion->prepare($sql);
			
			$st->bindValue(':usuario', $usuario, PDO::PARAM_STR);
			$st->bindValue(':contrasena', $contrasena, PDO::PARAM_STR);
			
			if($st->execute()){
				
				$u = new UsuarioBean();
				while($input = $st->fetch(PDO::FETCH_ASSOC)){
					$input["$pu.status"] = $this->getStatus($input["status"]);
					$u = new UsuarioBean($input);
					break;
				}
				return $u;
			}
			
			$error = $st->errorInfo();
			$this->setError($error[2]);
			return false;
		}catch(PDOException $e){
			$this->setError($e->getMessage());
			return false;
		}
    }
    
    public static function getStatus($status){
		$a = self::getOpcionesStatus();
		$r = array(
			"id" => $status,
			"descripcion" => ""
		);
		
		foreach ($a as $o) {
			if($o["id"] == $status){
				$r["descripcion"] = $o["descripcion"];
			}
		}
		return $r;
	}
    
    
    public function getOpcionesStatus(){
		$status = array(
			array(
				"id" => 1,
				"descripcion" => "ACTIVO"
			),
			array(
				"id" => 0,
				"descripcion" => "INACTIVO" 
			)
		);
		
		return $status;
	}


}
