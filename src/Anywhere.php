<?php
namespace anywhere;

use anywhere\app\FrontendController;

class Anywhere extends AnyAddress
{
    static $instance;
    static $address = array();
    static $env;

    var $command;
    var $data; // json format of data
    var $destination; // PDF, Excel, Word etc
    var $layout; // layout code

    public static function Setup($env = DEVELOPMENT)
    {
        self::$env = $env;
        self::ParseAddress(self::$address);
        if (!isset(self::$instance))
            self::$instance = new Anywhere();
        return self::$instance;
    }

    public function Start()
    {

    }

    public function ParseAddress(&$address)
    {
        if (!isset($_GET['query']))
            return call_user_func(array(new FrontendController(), 'main'));
        if ($_GET['query'] == 'login')
            return call_user_func(array(new FrontendController(), 'login'));

        $address = explode('/', $_GET['query']);
        $this->command = $address[0];

        return true;
    }

    public function ParseData(&$data)
    {

    }

}