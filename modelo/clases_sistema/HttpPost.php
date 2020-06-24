<?php
class HttpPost extends Http{

    public function __construct(){
        parent::__construct( $_POST );
    }

    public function getFiles(){
        return $_FILES;
    }
}