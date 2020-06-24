<?php
class Http {

    protected  $v = array ();

    public function __construct($var = array()){
		if (is_array($var))
			$this->v = $var;
	}

    public function defined($name){
        return isset($this->v[$name]);
    }

    public function int( $name ){
        return $this->defined($name) ? intval($this->v[$name]):0;
    }

    public function string( $name ){
        return $this->defined( $name ) ? strval( $this->v[$name] ) : "";
    }

    public function bool( $name ){
        if( $this->defined ($name) ){
            $val =  $this->v [$name];
            $boolval = ( is_string($val) ? filter_var($val, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : (bool) $val );
            return $boolval === null ? false : $boolval;
        }else{
            return false;
        }
    }

    public function float( $name ){
        return $this->defined( $name ) ? floatval( $this->v[$name] ) : 0.00;
    }

    public function raw( $name ){
        return $this->defined( $name ) ? $this->v[$name]:null;
    }

}