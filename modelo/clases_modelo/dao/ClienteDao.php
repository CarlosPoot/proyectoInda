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

    public function actualizarCliente( $cliente ){
        $sql    = "UPDATE cliente SET 
                    numero_cliente=:numeroCliente,
                    nombre=:nombre,
                    apellido=:apellido,
                    nss=:nss,
                    curp = :curp,
                    afore=:afore,
                    asesor=:asesor,
                    sc=:sc,
                    sd=:sd,
                    fb=:fb,
                    sbc=:sbc,
                    comentarios=:comentarios,
                    alta=:alta,
                    dias_transcurridos = :diasTranscurridos,
                    status=:status
                    WHERE id_cliente = :idCliente";

        try {
            $validarAlta = $this->validarCliente( $cliente );
            if( !$validarAlta ){
                return false;
            }

            $st = $this->conexion->prepare($sql);
            $st->bindValue(':idCliente', $cliente->getId() , PDO::PARAM_INT);
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
            $st->bindValue(':comentarios', $cliente->getComentarios() , PDO::PARAM_STR);
            $st->bindValue(':alta', $cliente->getAlta() , PDO::PARAM_STR);
            $st->bindValue(':diasTranscurridos', $cliente->getDiasTranscurridos(), PDO::PARAM_STR);
            $st->bindValue(':status', $cliente->getStatus(), PDO::PARAM_INT);
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
                WHERE (nss = :nss OR numero_cliente = :numeroCliente)";
        
        if( $cliente->getId() ){
            $sql .= " AND id_cliente <> :idCliente";
        }

        try {
            $st = $this->conexion->prepare($sql);
            $st->bindValue(':nss', $cliente->getNss(), PDO::PARAM_STR);
            $st->bindValue(':numeroCliente', $cliente->getNumeroCliente(), PDO::PARAM_STR);
            if( $cliente->getId() ){
                $st->bindValue(':idCliente', $cliente->getId(), PDO::PARAM_INT);
            }
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

    public function getClientes( $input ){
        $cl = ClienteBean::getPrefijo();
        $of = OficinaBean::getPrefijo();
        $sesion = new Session();
        $estadoCliente = $input->int("estadoCliente");
        $sql = "SELECT  c.id_cliente AS '$cl.id',
                        c.numero_cliente AS '$cl.numeroCliente',
                        c.nombre AS '$cl.nombre',
                        c.apellido AS '$cl.apellido',
                        c.nss AS '$cl.nss',
                        c.curp AS '$cl.curp',
                        c.afore AS '$cl.afore',
                        c.asesor AS '$cl.asesor',
                        c.sc AS '$cl.sc',
                        c.sd AS '$cl.sd',
                        c.fb AS '$cl.fb',
                        c.sbc AS '$cl.sbc',
                        c.alta AS '$cl.alta',
                        c.dias_transcurridos AS '$cl.diasTranscurridos',
                        c.comentarios AS '$cl.comentarios',
                        c.status AS '$cl.status',
                        of.id_oficina AS '$of.id',
                        of.descripcion AS '$of.descripcion'
                FROM cliente c
                INNER JOIN oficina of ON of.id_oficina = c.id_oficina
                WHERE c.id_oficina = :oficinaCliente";

        $sort = $input->raw("orden");
        $filtros = $input->raw("filtros");
        
        if( $estadoCliente ){
            $sql .= " AND c.status = :estadoCliente";
        }

        foreach( $filtros as $f ){
            switch( $f["campo"] ){
                case "numeroCliente":
                    $sql .= " AND c.numero_cliente LIKE :numeroCliente";
                    break;
                case "nombre":
                    $sql .= " AND c.nombre LIKE :nombre";
                    break;
                case "apellido":
                    $sql .= " AND c.apellido LIKE :apellido";
                    break;
                case "nss":
                    $sql .= " AND c.nss LIKE :nss";
                    break;
                case "curp":
                    $sql .= " AND c.curp LIKE :curp";
                    break;
                case "afore":
                    $sql .= " AND c.afore LIKE :afore";
                    break;
                case "asesor":
                    $sql .= " AND c.asesor LIKE :asesor";
                    break;
                case "sc":
                    $sql .= " AND c.sc LIKE :sc";
                    break;
                case "sd":
                    $sql .= " AND c.sd LIKE :sd";
                    break;
                case "fb":
                    $sql .= " AND c.sb LIKE :fb";
                    break;
                case "alta":
                    $sql .= " AND c.alta LIKE :alta";
                    break;
            }
        }

        switch(  $sort["columna"]  ){
            case "numeroCliente":
                $sql.=" ORDER BY c.numero_cliente ".  strtoupper( $sort["orden"] );
                break;
            case "nombre":
                $sql.=" ORDER BY c.nombre ".  strtoupper( $sort["orden"] );
                break;
            case "apellido":
                $sql.=" ORDER BY c.apellido ".  strtoupper( $sort["orden"] );
                break;
            case "nss":
                $sql.=" ORDER BY c.nss ".  strtoupper( $sort["orden"] );
                break;
            case "curp":
                $sql.=" ORDER BY c.curp ".  strtoupper( $sort["orden"] );
                break;
            case "afore":
                $sql.=" ORDER BY c.afore ".  strtoupper( $sort["orden"] );
                break;
            case "asesor":
                $sql.=" ORDER BY c.asesor ".  strtoupper( $sort["orden"] );
                break;
            case "sc":
                $sql.=" ORDER BY c.sc ".  strtoupper( $sort["orden"] );
                break;
            case "sd":
                $sql.=" ORDER BY c.sd ".  strtoupper( $sort["orden"] );
                break;
            case "fb":
                $sql.=" ORDER BY c.fb ".  strtoupper( $sort["orden"] );
                break;
            case "alta":
                $sql.=" ORDER BY c.alta ".  strtoupper( $sort["orden"] );
                break;
            case "diasTranscurridos":
                $sql.=" ORDER BY c.dias_transcurridos ".  strtoupper( $sort["orden"] );
                break;
            default:
                $sql.= " ORDER BY c.id_cliente";
                break;
        }

        $sql .=" limit :inicio,:numRegistros";

        try{

            $inicio = ( $input->int("pagina") -1 ) * $input->int("numRegistros");
            $st = $this->conexion->prepare( $sql );
            $st->bindValue(":oficinaCliente", $sesion->getVariableSesion(Constantes::$OFICINA_SESSION), PDO::PARAM_INT );
            $st->bindValue(":inicio", $inicio, PDO::PARAM_INT );
            $st->bindValue(":numRegistros", $input->int("numRegistros") , PDO::PARAM_INT );
            $st->bindValue(":estadoCliente", $estadoCliente , PDO::PARAM_INT );
            foreach( $filtros as $f ){
                switch( $f["campo"] ){
                    case "numeroCliente":
                        $st->bindValue(":numeroCliente", "%". $f["termino"] . "%"  , PDO::PARAM_STR );
                        break;
                    case "nombre":
                        $st->bindValue(":nombre", "%" . $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "apellido":
                        $st->bindValue(":apellido", "%". $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "nss":
                        $st->bindValue(":nss", "%" . $f["termino"] . "%" , PDO::PARAM_STR );
                        break;
                    case "curp":
                        $st->bindValue(":curp", "%" . $f["termino"] . "%" , PDO::PARAM_STR );
                        break;
                    case "afore":
                        $st->bindValue(":afore", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "asesor":
                        $st->bindValue(":asesor", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "sc":
                        $st->bindValue(":sc", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "sd":
                        $st->bindValue(":sd", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "fb":
                        $st->bindValue(":fb", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "alta":
                        $st->bindValue(":alta", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "diasTranscurridos":
                        $st->bindValue(":diasTranscurridos", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                }
            }

            if( $st->execute() ){
                $registros = array();
                while( $input = $st->fetch(PDO::FETCH_ASSOC) ){
                    $registros[] = new ClienteBean( $input );
                }
                return $registros;
            }

            $error = $st->errorInfo();
            $this->setError($error[2]);
            return false;
        }catch(  PDOException $e ){
            $this->setError($e->getMessage());
			return false;
        }
    }

    public function getTotalRegistros( $input ){
        $sesion = new Session();
        $estadoCliente = $input->int("estadoCliente");
        if( !$estadoCliente ){
            $this->setError("Parametros Invalidos, estado de cliente no recibido.");
            return false;
        }

        $sql = "SELECT COUNT(c.id_cliente) as totalRegistros 
                FROM cliente c
                INNER JOIN oficina of ON of.id_oficina = c.id_oficina
                WHERE c.id_oficina = :oficinaCliente";

        if( $estadoCliente ){
            $sql .= " AND c.status = :estadoCliente";
        }

        $sort = $input->raw("orden");
        $filtros = $input->raw("filtros");
        foreach( $filtros as $f ){
            switch( $f["campo"] ){
                case "numeroCliente":
                    $sql .= " AND c.numero_cliente LIKE :numeroCliente";
                    break;
                case "nombre":
                    $sql .= " AND c.nombre LIKE :nombre";
                    break;
                case "apellido":
                    $sql .= " AND c.apellido LIKE :apellido";
                    break;
                case "nss":
                    $sql .= " AND c.nss LIKE :nss";
                    break;
                case "curp":
                    $sql .= " AND c.curp LIKE :curp";
                    break;
                case "afore":
                    $sql .= " AND c.afore LIKE :afore";
                    break;
                case "asesor":
                    $sql .= " AND c.asesor LIKE :asesor";
                    break;
                case "sc":
                    $sql .= " AND c.sc LIKE :sc";
                    break;
                case "sd":
                    $sql .= " AND c.sd LIKE :sd";
                    break;
                case "fb":
                    $sql .= " AND c.sb LIKE :fb";
                    break;
                case "alta":
                    $sql .= " AND c.alta LIKE :alta";
                    break;
            }
        }

        switch(  $sort["columna"]  ){
            case "numeroCliente":
                $sql.=" ORDER BY c.numero_cliente ".  strtoupper( $sort["orden"] );
                break;
            case "nombre":
                $sql.=" ORDER BY c.nombre ".  strtoupper( $sort["orden"] );
                break;
            case "apellido":
                $sql.=" ORDER BY c.apellido ".  strtoupper( $sort["orden"] );
                break;
            case "nss":
                $sql.=" ORDER BY c.nss ".  strtoupper( $sort["orden"] );
                break;
            case "curp":
                $sql.=" ORDER BY c.curp ".  strtoupper( $sort["orden"] );
                break;
            case "afore":
                $sql.=" ORDER BY c.afore ".  strtoupper( $sort["orden"] );
                break;
            case "asesor":
                $sql.=" ORDER BY c.asesor ".  strtoupper( $sort["orden"] );
                break;
            case "sc":
                $sql.=" ORDER BY c.sc ".  strtoupper( $sort["orden"] );
                break;
            case "sd":
                $sql.=" ORDER BY c.sd ".  strtoupper( $sort["orden"] );
                break;
            case "fb":
                $sql.=" ORDER BY c.fb ".  strtoupper( $sort["orden"] );
                break;
            case "alta":
                $sql.=" ORDER BY c.alta ".  strtoupper( $sort["orden"] );
                break;
            case "diasTranscurridos":
                $sql.=" ORDER BY c.dias_transcurridos ".  strtoupper( $sort["orden"] );
                break;
            default:
                $sql.= " ORDER BY c.id_cliente";
                break;
        }

        try{
        
            $st = $this->conexion->prepare( $sql );
            $st->bindValue(":oficinaCliente", $sesion->getVariableSesion(Constantes::$OFICINA_SESSION), PDO::PARAM_INT );
            $st->bindValue(":estadoCliente", $estadoCliente , PDO::PARAM_INT );
            foreach( $filtros as $f ){
                switch( $f["campo"] ){
                    case "numeroCliente":
                        $st->bindValue(":numeroCliente", "%". $f["termino"] . "%"  , PDO::PARAM_STR );
                        break;
                    case "nombre":
                        $st->bindValue(":nombre", "%" . $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "apellido":
                        $st->bindValue(":apellido", "%". $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "nss":
                        $st->bindValue(":nss", "%" . $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "curp":
                        $st->bindValue(":curp", "%" . $f["termino"] . "%" , PDO::PARAM_STR );
                        break;
                    case "afore":
                        $st->bindValue(":afore", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "asesor":
                        $st->bindValue(":asesor", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "sc":
                        $st->bindValue(":sc", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "sd":
                        $st->bindValue(":sd", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "fb":
                        $st->bindValue(":fb", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "alta":
                        $st->bindValue(":alta", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                    case "diasTranscurridos":
                        $st->bindValue(":diasTranscurridos", "%".  $f["termino"]. "%" , PDO::PARAM_STR );
                        break;
                }
            }

            if( $st->execute() ){
                $total = 0;
                while( $input = $st->fetch(PDO::FETCH_ASSOC) ){
                    $total = $input["totalRegistros"];
                }
                return $total;
            }

            $error = $st->errorInfo();
            $this->setError($error[2]);
            return false;
        }catch(  PDOException $e ){
            $this->setError($e->getMessage());
			return false;
        }
    }

    public function eliminarCliente( $idCliente ){
        $sql    = "UPDATE cliente SET 
                    status = :status
                    WHERE id_cliente = :idCliente";

        try {

            $st = $this->conexion->prepare($sql);
            $st->bindValue(':idCliente', $idCliente , PDO::PARAM_INT);
            $st->bindValue(':status', Constantes::$STATUS_ELIMINADO, PDO::PARAM_INT);
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

}