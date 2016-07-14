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
        // localhost/anywhere/login/
        // localhost/anywhere/logout/
        // localhost/anywhere/register/
        // localhost/anywhere/beranda/
        if (!isset($_GET['query']))
            return call_user_func(array(new FrontendController(), 'main'));

        $address = explode('/', self::URLAddressChecker(strtolower($_GET['query'])));
        if (sizeof($address) == 2) {
            return call_user_func(array(new FrontendController(), $_GET['query']));
        } elseif (sizeof($address) > 2) {
            if (!is_numeric($address[0]))
                return call_user_func(array(new FrontendController(), 'sorry'));

            if(!isset($_SESSION['ID']))
                return call_user_func(array(new FrontendController(), 'sorry'));

            if ((int)$address[0] != (int)$_SESSION['ID'])
                return call_user_func(array(new FrontendController(), 'sorry'));

            // http://localhost/anywhere/1/pdf/designer
            // http://localhost/anywhere/1/pdf/designer/1
            $pdfID = $address[3];
            if (!is_numeric($address[3]))
                $pdfID = DBAnywhere::NewPdfPage($address[0]);

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

        // localhost/anywhere/[UID]/PDF/
        // localhost/anywhere/[UID]/PDF/designer/[PAGEID]
        // localhost/anywhere/[UID]/EXCEL/
        // localhost/anywhere/[UID]/EXCEL/designer/[PAGEID]
        // localhost/anywhere/[UID]/WORD/
        // localhost/anywhere/[UID]/WORD/designer/[PAGEID]
        // localhost/anywhere/[UID]/JPG/

        // localhost/anywhere/[API]/render/[PAGEID]
        return true;
    }

    public function ParseData(&$data)
    {

    }

}