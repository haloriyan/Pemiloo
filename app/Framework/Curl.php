<?php

class Curl {
    public $ch;
    private static $_instance = null;

    public function __construct() {
        $this->ch = curl_init();
        if(self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    public function get($url) {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $res = curl_exec($this->ch);
        return $res;
    }
    public function post($url, $bodyFields) {
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $bodyFields);
        $res = curl_exec($this->ch);
        return $res;
    }
}