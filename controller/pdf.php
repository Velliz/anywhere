<?php
namespace controller;

use Dompdf\Dompdf;
use model\DBAnywhere;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;

class pdf extends View implements Auth
{
    private $outputmode;
    private $paper;
    private $html;
    private $css;
    private $reportname;
    private $requesttype;
    private $requesturl;

    private $requestsample;

    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new DOMPDF();
    }

    public function main()
    {
        $session = Session::Get($this)->GetLoginData();

        if ((int)$session['statusID'] == 1) {
            $result = DBAnywhere::CountPDFUser($session['ID'])[0];
            if ((int)$result['result'] >= 2) $this->RedirectTo('limitations');
            return;
        }
        $filename = date('d-m-Y-His');
        $path = FILE . '/storage/' . $session['id'];
        mkdir($path, 0777, true);

        file_put_contents($path . '/HTML-PDF-' . $filename . '.html', "<h1>Hello to Anywhere</h1>");
        file_put_contents($path . '/CSS-PDF-' . $filename . '.css', "<h1>Hello to Anywhere</h1>");

        $pdfID = DBAnywhere::NewPdfPage($session['ID'], $filename);
        $dataPDF = DBAnywhere::GetPdfPage($pdfID)[0];
        $this->RedirectTo('update/' . $dataPDF['PDFID']);
    }

    public function limitations()
    {

    }

    public function render($apikey, $pdfID)
    {
        $pdfRender = DBAnywhere::GetPdfRender($apikey, $pdfID)[0];

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];
        $this->requesturl = $pdfRender['requesturl'];

        $head = file_get_contents(FILE . '/storage/head.html');
        $head .= "<link href='" . ROOT . '/storage/' . $pdfRender['id'] . '/' . $this->css . "' rel='stylesheet'></head><body>";
        $path = file_get_contents(FILE . '/storage/' . $pdfRender['id'] . '/' . $pdfRender['html']);
        $tail = file_get_contents(FILE . '/storage/tail.html');
        $content = $head . $path . $tail;

        $coreData = json_decode($pdfRender['requestsample']);

        if ($this->requesttype == 'POST') {

            $data = array(
                'status' => 'success',
            );

            if (!isset($_POST['jsondata'])) {
                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
                header("Author: Puko Framework v1");
                header('Content-Type: application/json');

                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            } elseif (isset($_POST['jsondata'])) {
                $coreData = json_decode($_POST['jsondata']);
            }
        }

        if ($this->requesttype == 'URL') {
            $fetch = file_get_contents($this->requesturl);
            $coreData = json_decode($fetch);
        }

        $render = new \pukoframework\pte\RenderEngine();
        $template = $render->PTEParser($content, $coreData);

        $this->dompdf->setPaper($this->paper);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        if ($this->outputmode == 'Inline') {
            $this->dompdf->stream($this->reportname, array("Attachment" => false));
        }
        if ($this->outputmode == 'Download') {
            $this->dompdf->stream($this->reportname, array("Attachment" => true));
        }
    }

    public function CodeRender($apikey, $pdfID)
    {
        $pdfRender = DBAnywhere::GetPdfRender($apikey, $pdfID)[0];

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];

        $head = file_get_contents(FILE . '/storage/head.html');
        $head .= "<link href='" . ROOT . '/storage/' . $pdfRender['id'] . '/' . $this->css . "' rel='stylesheet'></head><body>";
        $path = file_get_contents(FILE . '/storage/' . $pdfRender['id'] . '/' . $pdfRender['html']);
        $tail = file_get_contents(FILE . '/storage/tail.html');
        $content = $head . $path . $tail;

        $render = new \pukoframework\pte\RenderEngine();
        $template = $render->PTEParser($content, json_decode($pdfRender['requestsample']));

        $this->dompdf->setPaper($this->paper);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        $this->dompdf->stream($this->reportname, array("Attachment" => false));
    }

    public function designer()
    {
        if ((int)$_SESSION['statusid'] == 1) {
            $result = DBAnywhere::CountPDFUser($_SESSION['id'])[0];
            if ((int)$result['result'] >= 2)
                $this->RedirectTo('limitations');
        }
        $filename = date('d-m-Y-His');
        $pdfID = DBAnywhere::NewPdfPage($_SESSION['id'], $filename);

        $dataPDF = $_SESSION;
        $dataPDF[0]['pdf'] = DBAnywhere::GetPdfPage($pdfID)[0];

        return $dataPDF;
    }

    public function update($id)
    {
        $session = Session::Get($this)->GetLoginData();
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
            $result = DBAnywhere::UpdatePdfPage($arrayID, $arrayData);
            if ($result)
                $this->RedirectTo('beranda');
        }

        $dataPDF = $session;
        $dataPDF['pdf'] = DBAnywhere::GetPdfPage($id);
        var_dump($dataPDF);
        return $dataPDF;
    }

    public function html($idpdf)
    {
        $path = FILE . '/storage/' . $_SESSION['id'];
        $file = $_SESSION;
        $file['pdf'] = DBAnywhere::GetPdfPage($idpdf)[0];

        if (isset($_POST['code'])) {
            file_put_contents($path . '/' . $file['pdf']['html'], $_POST['code']);
        }

        $file['html'] = file_get_contents($path . '/' . $file['pdf']['html']);
        return $file;
    }

    public function css($idpdf)
    {

    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = DBAnywhere::GetUser($username, md5($password));
        return $loginResult[0]['ID'];
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return DBAnywhere::GetUserById($id)[0];
    }
    #end region auth
}