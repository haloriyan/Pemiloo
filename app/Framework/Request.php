<?php

class Request {
    private $data = [];
    private static $_instance = null;

    public function __get($varName){
        if (!array_key_exists($varName,$this->data)) {
            //this attribute is not defined!
        }
            else return $this->data[$varName];
    }
    public function __set($varName,$value){
        $this->data[$varName] = $value;
    }
    public function __construct() {
        $inputs = file_get_contents('php://input');
        $datas = explode("&", $inputs);
        // Handle post params
        if($datas[0] != "") {
            foreach($datas as $data) {
                $a = explode("=", $data);
                $this->{$a[0]} = urldecode($a[1]);
            }
        }
        $postData = $_POST;
        if (count($postData) != 0) {
            foreach ($postData as $key => $value) {
                $this->{$key} = urldecode($value);
            }
        }

        // Handle get params
        foreach($_GET as $key => $value) {
            if ($key != "lokasiItuUntukDefaultParam") {
                $this->{$key} = urldecode($value);
            }
        }
    }
}