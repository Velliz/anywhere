<?php
namespace anywhere;

use anywhere\app\ExcelController;
use anywhere\app\FrontendController;
use anywhere\app\PDFController;
use anywhere\app\WordController;
use anywhere\model\DBAnywhere;
use Dompdf\Exception;

class Anywhere extends AnyAddress
{
    static $instance;
    static $address = array();
    static $env;

    // todo : penggunaan variabel ini??
    var $command;
    var $data; // json format of data
    var $destination; // PDF, Excel, Word etc
    var $layout; // layout code

    public static function Setup($env = DEVELOPMENT)
    {
        self::$env = $env;
        if (!isset(self::$instance))
            self::$instance = new Anywhere();
        self::$instance->ParseAddress(self::$address);
        return self::$instance;
    }

    public function ParseAddress(&$address)
    {
        @session_start();

        // localhost/anywhere/ -> main welcome method
        if (!isset($_GET['query']))
            return call_user_func(array(new FrontendController(), 'main'));

        $address = explode('/', self::URLAddressChecker(strtolower($_GET['query'])));

        if ($address[0] == 'render' || $address[0] == 'coderender') {
            $apikey = $address[2];
            $pdfID = $address[3];
            // http://localhost/anywhere/render/pdf/[APIKEY]/[PDFID]
            switch ($address[1]) {
                case 'pdf':
                    return call_user_func_array(array(new PDFController(), $address[0]), array($apikey, $pdfID));
                    break;
                case 'word':
                    return call_user_func_array(array(new WordController(), $address[0]), array($apikey, $pdfID));
                    break;
                case 'excel':
                    return call_user_func_array(array(new ExcelController(), $address[0]), array($apikey, $pdfID));
                    break;
            }
        }

        // localhost/anywhere/login/
        // localhost/anywhere/logout/
        // localhost/anywhere/register/
        // localhost/anywhere/beranda/
        if (sizeof($address) <= 2) {
            return call_user_func(array(new FrontendController(), $_GET['query']));
        } elseif (sizeof($address) > 2) {
            // invalid userid
            if (!is_numeric($address[0]))
                return call_user_func(array(new FrontendController(), 'sorry'));
            // userid not logged in
            if (!isset($_SESSION['ID']))
                return call_user_func(array(new FrontendController(), 'sorry'));
            // user only can access own data
            if ((int)$address[0] != (int)$_SESSION['ID'])
                return call_user_func(array(new FrontendController(), 'sorry'));

            // http://localhost/anywhere/1/pdf/designer
            // http://localhost/anywhere/1/pdf/designer/1
            $pdfID = $address[3];

            switch ($address[1]) {
                case 'pdf':
                    return call_user_func_array(array(new PDFController(), $address[2]), array($pdfID));
                case 'word':
                    return call_user_func_array(array(new WordController(), $address[2]), array($pdfID));
                    break;
                case 'excel':
                    return call_user_func_array(array(new ExcelController(), $address[2]), array($pdfID));
                    break;
            }
        }
        return true;
    }

    public function ParseData(&$data)
    {

    }

}