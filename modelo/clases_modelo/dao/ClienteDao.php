<?php
class ClienteDao extends Dao {

    public function crearCliente( $cliente ){
        $sesion = new Session();
        $sql    = "INSERT INTO cliente(
                                numero_cliente,
                                nombre,
                                apellido,
                                nss,
                                curp,
                                afore,
                                asesor,
                                sc,
                                sd,
                                fb,
                                sbc,
                                alta,
                                dias_transcurridos,
                                comentarios,
                                id_oficina,
                                id_usuario
                            )VALUES(
                                :numeroCliente,
                                :nombre,
                                :apellido,
                                :nss,
                                :curp,
                                :afore,
                                :asesor,
                                :sc,
                                :sd,
                                :fb,
                                :sbc,
                                :alta,
                                :diasTranscurridos,
                                :comentarios,
                                :idOficina,
                                :idUsuario
                            )";

        
        try {
            $validarAlta = $this->validarCliente( $cliente );
            if( !$validarAlta ){
                return false;
            }

            $st = $this->conexion->prepare($sql);
            $st->bindValue(':numeroCliente', $cliente->getNumeroCliente() , PDO::PARAM_STR);
            $st->bindValue(':nombre', $cliente->getNombre() , PDO::PARAM_STR);
            $st->bindValue(':apellido', $cliente->getApellido() , PDO::PARAM_STR);
            $st->bindValue(':nss', $cliente->getNss() , PDO::PARAM_STR);
            $st->bindValue(':curp', $cliente->getCurp() , PDO::PARAM_STR);
            $st->bindValue(':afore', $cliente->getAfore() , PDO::PARAM_STR);
            $st->bindValue(':asesor', $cliente->getAsesor() , PDO::PARAM_STR);
            $st->bindValue(':sc', $cliente->getSc() , PDO::PARAM_INT);
            $st->bindValue(':sd', $cliente->getSd() , PDO::PARAM_INT);
            $st->bindValue(':fb', $cliente->getFb() , PDO::PARAM_STR);
            $st->bindValue(':sbc', $cliente->getSbc() , PDO::PARAM_INT);
            $st->bindValue(':alta', $cliente->getAlta() , PDO::PARAM_STR);
            $st->bindValue(':diasTranscurridos', $cliente->getDiasTranscurridos() , PDO::PARAM_STR);
            $st->bindValue(':comentarios', $cliente->getComentarios() , PDO::PARAM_STR);
            $st->bindValue(':idOficina', $sesion->getVariableSesion( Constantes::$OFICINA_SESSION ) , PDO::PARAM_INT);
            $st->bindValue(':idUsuario', $sesion->getIdSesion() , PDO::PARAM_INT);
            if ($st->execute()) {
                return true;
            }

            $error = $st->errorInfo();
            $this->setError($error[2]);
            return false;
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }


    public function validarCliente( $cliente ){

        $sql = "SELECT nss,numero_cliente as numeroCliente FROM cliente
                WHERE nss = :nss OR numero_cliente = :numeroCliente";
        
        try {
            $st = $this->conexion->prepare($sql);
            $st->bindValue(':nss', $cliente->getNss(), PDO::PARAM_STR);
            $st->bindValue(':numeroCliente', $cliente->getNumeroCliente(), PDO::PARAM_STR);
            if ($st->execute()) {
                if( $st->rowCount() > 0){
                    while ($input = $st->fetch(PDO::FETCH_ASSOC)) {
                        if( $cliente->getNss() == $input["nss"]){
                            $this->setError("El NSS del cliente ya existe");
                        }else {
                            $this->setError("El numero de cliente ingreado ya existe");
                        }
                        return false;
                    }
                } 
                return true;
            }
            $error = $st->errorInfo();
            $this->setError($error[2]);
            return false;
        } catch (PDOException $e) {
            $this->setError($e->getMessage());
            return false;
        }


    }


}