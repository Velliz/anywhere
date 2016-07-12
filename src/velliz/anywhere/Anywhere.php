<?php
namespace velliz\anywhere;

class Anywhere extends AnyAddress
{
    static $instance;
    static $address = array();
    static $env;

    var $data; // json format of data
    var $destination; // PDF, Excel, Word etc
    var $layout; // layout code

    public static function Setup($address, $env = DEVELOPMENT)
    {
        self::$env = $env;
        self::$address = $address;
        self::ParseAddress(self::$address);
        if(!isset(self::$instance))
            self::$instance = new Anywhere();
        return self::$instance;
    }

    public function Start() {

    }

    public function ParseAddress(&$address) {

    }

}