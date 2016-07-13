<?php
namespace anywhere\app;

use anywhere\engine\AnywhereController;
use Dompdf\Dompdf;

class PDFController extends AnywhereController
{

    public function __construct()
    {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');
    }

    public function main()
    {
        $dompdf = new DOMPDF();

        $html = "<html>
         <body>
          <h1>Hello Dompdf</h1>
         </body>
        </html>";

        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('hello', array("Attachment" => false));
        exit(0);

//        $output = $dompdf->output();
//        echo file_put_contents('Brochure.pdf', $output);
    }

    public function render()
    {

    }
}