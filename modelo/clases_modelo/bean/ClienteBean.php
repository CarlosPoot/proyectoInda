<?php
class ClienteBean{
    
    private static $prefijo = "clt";
    private $id;
    private $numeroCliente;
	private $oficina;
	private $nombre;
	private $apellido;
    private $nss;
    private $curp;
    private $afore;
    private $asesor;
	private $sc;
	private $sd;
	private $fb;
    private $sbc;
    private $alta;
    private $diasTranscurridos;
    private $comentarios;
    private $status;

    function __construct($input = null, $isJson = false){
		if($input !== null){
            $prefijo = "";
            
			if(!$isJson){
                $prefijo = self::$prefijo . ".";
                $this->setOficina(new OficinaBean($input));
			}else{
                $this->setOficina( isset($input[$prefijo . "ubicacion"]) ? new OficinaBean($input[$prefijo . "ubicacion"], true) : new OficinaBean());
            }
			
			$this->setId(isset($input[$prefijo . "id"]) ? $input[$prefijo . "id"] : "");
			$this->setNumeroCliente(isset($input[$prefijo . "numeroCliente"]) ? $input[$prefijo . "numeroCliente"] : "");
			$this->setNombre(isset($input[$prefijo . "nombre"]) ? $input[$prefijo . "nombre"] : "");
            $this->setApellido(isset($input[$prefijo . "apellido"]) ? $input[$prefijo . "apellido"] : "");
            $this->setNss(isset($input[$prefijo . "nss"]) ? $input[$prefijo . "nss"] : "");
			$this->setCurp(isset($input[$prefijo . "curp"]) ? $input[$prefijo . "curp"] : "");
			$this->setAfore(isset($input[$prefijo . "afore"]) ? $input[$prefijo . "afore"] : "");
			$this->setAsesor(isset($input[$prefijo . "asesor"]) ? $input[$prefijo . "asesor"] : "");
            $this->setSc(isset($input[$prefijo . "sc"]) ? $input[$prefijo . "sc"] : "");
            $this->setSd(isset($input[$prefijo . "sd"]) ? $input[$prefijo . "sd"] : "");
            $this->setFb(isset($input[$prefijo . "fb"]) ? $input[$prefijo . "fb"] : "");
            $this->setSbc(isset($input[$prefijo . "sbc"]) ? $input[$prefijo . "sbc"] : "");
			$this->setAlta(isset($input[$prefijo . "alta"]) ? $input[$prefijo . "alta"] : "");
			$this->setDiasTranscurridos(isset($input[$prefijo . "diasTranscurridos"]) ? $input[$prefijo . "diasTranscurridos"] : "");
			$this->setComentarios(isset($input[$prefijo . "comentarios"]) ? $input[$prefijo . "comentarios"] : "");
            $this->setStatus(isset($input[$prefijo . "status"]) ? $input[$prefijo . "status"] : "");
            
		}else{
            
			$this->id = "";
            $this->numeroCliente = "";
            $this->oficina = "";
            $this->nombre = "";
            $this->nss = "";
            $this->curp = "";
			$this->afore = "";
			$this->asesor = "";
            $this->sc = "";
            $this->sd = "";
            $this->fb = "";
            $this->sbc = "";
            $this->alta = "";
            $this->diasTranscurridos = "";
            $this->comentarios = "";
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

    public function getNumeroCliente(){
        return $this->numeroCliente;
    }

	public function setNumeroCliente($numeroCliente){
        $this->numeroCliente = $numeroCliente;
    }

    public function getOficina(){
        return $this->oficina;
    }

	public function setOficina($oficina){
        $this->oficina = $oficina;
    }

    public function getNombre(){
        return $this->nombre;
    }

	public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

	public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getNss(){
        return $this->nss;
    }

	public function setNss($nss){
        $this->nss = $nss;
    }

    public function getCurp(){
        return $this->curp;
    }

	public function setCurp($curp){
        $this->curp = $curp;
    }

    public function getAfore(){
        return $this->afore;
    }

	public function setAfore($afore){
        $this->afore = $afore;
    }

    public function getAsesor(){
        return $this->asesor;
    }

	public function setAsesor($asesor){
        $this->asesor = $asesor;
    }

    public function getSc(){
        return $this->sc;
    }

	public function setSc($sc){
        $this->sc = $sc;
    }

    public function getSd(){
        return $this->sd;
    }

	public function setSd($sd){
        $this->sd = $sd;
    }

    public function getFb(){
        return $this->fb;
    }

	public function setFb($fb){
        $this->fb = $fb;
    }

    public function getSbc(){
        return $this->sbc;
    }

	public function setSbc($sbc){
        $this->sbc = $sbc;
    }

    public function getAlta(){
        return $this->alta;
    }

	public function setAlta($alta){
        $this->alta = $alta;
    }

    public function getDiasTranscurridos(){
        return $this->diasTranscurridos;
    }

	public function setDiasTranscurridos($diasTranscurridos){
        $this->diasTranscurridos = $diasTranscurridos;
    }

    public function getComentarios(){
        return $this->comentarios;
    }

	public function setComentarios($comentarios){
        $this->comentarios = $comentarios;
    }

    public function getStatus(){
        return $this->status;
    }

	public function setStatus($status){
        $this->status = $status;
    }

    public function jsonSerialize(){
		$j = new stdClass();
		
		$j->id = intval($this->getId());
        $j->numeroCliente = $this->getNumeroCliente();
        $j->asesor = $this->getAsesor();
        $j->oficina = $this->getOficina();
        $j->nombre = $this->getNombre();
        $j->apellido = $this->getApellido();
        $j->nss = $this->getNss();
        $j->curp = $this->getCurp();
        $j->afore = $this->getAfore();
        $j->sc = $this->getSc();
        $j->sd = $this->getSd();
        $j->fb = $this->getFb();
        $j->sbc = $this->getSbc();
        $j->alta = $this->getAlta();
        $j->diasTranscurridos = $this->getDiasTranscurridos();
        $j->comentarios = $this->getComentarios();
        return $j;
        
	}
}