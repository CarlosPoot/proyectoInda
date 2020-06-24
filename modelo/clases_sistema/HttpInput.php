<?php
class HttpInput extends Http {

    public function __construct(){
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body, true);
		if ($data === null){
			$data = array();
		}
		parent::__construct($data);
	}
        
}