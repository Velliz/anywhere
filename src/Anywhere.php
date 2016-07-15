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
        @session_start();
        // localhost/anywhere/
        if (!isset($_GET['query']))
            return call_user_func(array(new FrontendController(), 'main'));

        $address = explode('/', self::URLAddressChecker(strtolower($_GET['query'])));

        if ($address[0] == 'render') {

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
            if (!is_numeric($address[0]))
                return call_user_func(array(new FrontendController(), 'sorry'));

            // login handler
            if (!isset($_SESSION['ID']))
                return call_user_func(array(new FrontendController(), 'sorry'));

            //only can access own data handler
            if ((int)$address[0] != (int)$_SESSION['ID'])
                return call_user_func(array(new FrontendController(), 'sorry'));

            // http://localhost/anywhere/1/pdf/designer
            // http://localhost/anywhere/1/pdf/designer/1

            $pdfID = $address[3];
            if (!is_numeric($address[3])) {
                if ($_SESSION['status'] == 'Free Plan') {
                    $result = DBAnywhere::CountPDFUser($_SESSION['ID'])[0];
                    if ($result['result'] > 2) return call_user_func(array(new FrontendController(), 'limitations'));
                }
                // todo : ini kena trigger bug kalo dia update.
                $pdfID = DBAnywhere::NewPdfPage($address[0]);
            }

            switch ($address[1]) {
                case 'pdf':
                    return call_user_func_array(array(new PDFController(), $address[2]), array($pdfID));
                    break;
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