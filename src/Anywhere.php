<?php
namespace anywhere;

use anywhere\app\FrontendController;
use anywhere\app\PDFController;
use Dompdf\Exception;

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

        $address = explode('/', self::URLAddressChecker($_GET['query']));
        if (sizeof($address) == 2) {
            return call_user_func(array(new FrontendController(), $_GET['query']));
        } else if (sizeof($address) > 2) {
            if (!is_numeric($address[0]))
                return call_user_func(array(new FrontendController(), 'sorry'));

        }

        // localhost/anywhere/
        // localhost/anywhere/login/
        // localhost/anywhere/logout/
        // localhost/anywhere/register/
        // localhost/anywhere/beranda/
        // localhost/anywhere/[UID]/PDF/
        // localhost/anywhere/[UID]/PDF/designer/[PAGEID]
        // localhost/anywhere/[UID]/EXCEL/
        // localhost/anywhere/[UID]/EXCEL/designer/[PAGEID]
        // localhost/anywhere/[UID]/WORD/
        // localhost/anywhere/[UID]/WORD/designer/[PAGEID]
        // localhost/anywhere/[UID]/JPG/

        // localhost/anywhere/[API]/render/[PAGEID]

        switch (sizeof($address)) {

        }

        if ($_GET['query'] == 'login')
            return call_user_func(array(new FrontendController(), 'login'));
        if ($_GET['query'] == 'pdf')
            return call_user_func(array(new PDFController(), 'main'));

        if ($_GET['query'] == 'home')
            return call_user_func(array(new FrontendController(), 'home'));

        $address = explode('/', $_GET['query']);
        return true;
    }

    public function ParseData(&$data)
    {

    }

}