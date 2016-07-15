<?php
namespace anywhere\app;

use anywhere\engine\AnywhereController;
use anywhere\model\DBAnywhere;
use Dompdf\Dompdf;

class PDFController extends AnywhereController
{

    public function __construct()
    {
        @session_start();
//        header("Cache-Control: no-cache");
//        header("Pragma: no-cache");
//        header("Author: Anywhere 0.1");
//        header('Content-Type: application/pdf');
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

    public function designer($id)
    {
        if (isset($_POST['pdfid']) && isset($_POST['paper']) && isset($_POST['requesttype']) && isset($_POST['requesturl'])) {
            $arrayID = array('PDFID' => $_POST['pdfid']);
            $arrayData = array(
                'PDFID' => $_POST['pdfid'],
                'reportname' => $_POST['reportname'],
                'outputmode' => $_POST['outputmode'],
                'paper' => $_POST['paper'],
                'requesttype' => $_POST['requesttype'],
                'requesturl' => $_POST['requesturl'],
                'requestsample' => $_POST['requestsample'],
            );
            DBAnywhere::UpdatePdfPage($arrayID, $arrayData);
        }

        $dataPDF = $_SESSION;
        $dataPDF['pdf'] = DBAnywhere::GetPdfPage($id)[0];
        $this->view('templates/head');
        $this->view('frontend/pdf/designer', $dataPDF);
    }
}