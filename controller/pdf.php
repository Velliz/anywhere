<?php

namespace controller;

use Dompdf\Dompdf;
use Dompdf\Exception;
use model\PdfModel;
use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\RenderEngine;
use pukoframework\pte\View;

/**
 * Class pdf
 * @package controller
 *
 * #ClearOutput false
 * #Auth true
 */
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

    /**
     * @var Dompdf
     */
    private $dompdf;

    private $head = <<<HEAD
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Title</title>
HEAD;
    private $tail = <<<TAIL
        </body>
        </html>
TAIL;


    public function __construct()
    {
        $this->dompdf = new DOMPDF();
    }

    /**
     * #Template html false
     */
    public function main()
    {
        $session = Session::Get($this)->GetLoginData();

        if ((int)$session['statusID'] == 1) {
            $result = PdfModel::CountPDFUser($session['ID'])[0];
            if ((int)$result['result'] >= 2) $this->RedirectTo('limitations');
        }
        $filename = date('d-m-Y-His');
        $path = FILE . '/storage/' . $session['ID'];

        if (!file_exists($path)) {
            umask(0);
            mkdir($path, 0777, true);
        }

        $pdfID = PdfModel::NewPdfPage($session['ID'], $filename);
        $dataPDF = PdfModel::GetPdfPage($pdfID)[0];
        $this->RedirectTo('update/' . $dataPDF['PDFID']);
    }

    /**
     * #Template master false
     *
     * @param $apikey
     * @param $pdfID
     * @throws \Exception
     */
    public function render($apikey, $pdfID)
    {
        $session = Session::Get($this)->GetLoginData();
        $pdfRender = PdfModel::GetPdfRender($apikey, $pdfID)[0];

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];
        $this->requesturl = $pdfRender['requesturl'];

        $head = $this->head;
        $head .= "<link href='" . BASE_URL . 'storage/' . $pdfRender['userID'] . '/' . $this->css . "' rel='stylesheet'>";
        $head .= "</head><body>";

        $path = file_get_contents(FILE . '/storage/' . $pdfRender['userID'] . '/' . $pdfRender['html']);
        $tail = $this->tail;
        $content = $head . $path . $tail;
        $filepath = FILE . '/storage/' . $session['ID'];
        file_put_contents($filepath . '/render-' . $this->reportname . '.html', $content);

        $coreData = json_decode($pdfRender['requestsample']);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/json');

        if ($this->requesttype == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $coreData = json_decode($_POST['jsondata']);
        }

        if ($this->requesttype == 'URL') {
            $data['status'] = 'success';
            if ($this->requesturl == '') {
                $data['status'] = 'failed';
                $data['reason'] = 'request URL not defined.';
                die(json_encode($data));
            }
            $fetch = file_get_contents($this->requesturl);
            if (!$fetch) {
                $data['status'] = 'failed';
                $data['reason'] = 'url return zero data.';
                die(json_encode($data));
            }

            $coreData = json_decode($fetch);
        }

        $render = new RenderEngine();
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($filepath . '/render-' . $this->reportname . '.html', $coreData);

        $this->dompdf->setPaper($this->paper);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        header('Content-Type: application/pdf');

        if ($this->outputmode == 'Inline') {
            $this->dompdf->stream($this->reportname, array("Attachment" => 0));
        }
        if ($this->outputmode == 'Download') {
            $this->dompdf->stream($this->reportname, array("Attachment" => 1));
        }
    }

    public function update($id)
    {
        $session = Session::Get($this)->GetLoginData();
        if (isset($_POST['pdfid']) && isset($_POST['paper']) && isset($_POST['requesttype'])) {
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
            $resultUpdate = PdfModel::UpdatePdfPage($arrayID, $arrayData);
            $filepath = FILE . '/storage/' . $session['ID'];
            unlink($filepath . '/render-' . $this->reportname . '.html');
            if ($resultUpdate) $this->RedirectTo(BASE_URL . 'beranda');
            $this->RedirectTo(BASE_URL . 'sorry');
        }

        $dataPDF = $session;
        $dataPDF['pdf'] = PdfModel::GetPdfPage($id);
        foreach ($dataPDF['pdf'] as $key => $value) {
            switch ($value['paper']) {
                case 'A4':
                    $dataPDF['pdf'][$key]['A4'] = 'checked';
                    break;
                case 'B5':
                    $dataPDF['pdf'][$key]['B5'] = 'checked';
                    break;
                case 'F4':
                    $dataPDF['pdf'][$key]['F4'] = 'checked';
                    break;
            }
            switch ($value['requesttype']) {
                case 'POST':
                    $dataPDF['pdf'][$key]['POST'] = 'checked';
                    break;
                case 'URL':
                    $dataPDF['pdf'][$key]['URL'] = 'checked';
                    break;
            }
            switch ($value['outputmode']) {
                case 'Inline':
                    $dataPDF['pdf'][$key]['Inline'] = 'checked';
                    break;
                case 'Download':
                    $dataPDF['pdf'][$key]['Download'] = 'checked';
                    break;
            }
        }
        return $dataPDF;
    }

    public function html($idpdf)
    {
        $session = Session::Get($this)->GetLoginData();
        $path = FILE . '/storage/' . $session['ID'];
        $file = $session;
        $file['pdf'] = PdfModel::GetPdfPage($idpdf);

        if (isset($_POST['code'])) {
            umask(0);
            file_put_contents($path . '/' . $file['pdf'][0]['html'], $_POST['code']);
        }

        $file['html'] = file_get_contents($path . '/' . $file['pdf'][0]['html']);
        return $file;
    }

    public function style($idpdf)
    {
        $session = Session::Get($this)->GetLoginData();
        $path = FILE . '/storage/' . $session['ID'];
        $file = $session;
        $file['pdf'] = PdfModel::GetPdfPage($idpdf);

        if (isset($_POST['code'])) {
            umask(0);
            file_put_contents($path . '/' . $file['pdf'][0]['css'], $_POST['code']);
        }

        $file['css'] = file_get_contents($path . '/' . $file['pdf'][0]['css']);
        return $file;
    }

    /**
     * #Template html false
     *
     * @param $apikey
     * @param $pdfID
     * @throws \Exception
     */
    public function coderender($apikey, $pdfID)
    {
        $session = Session::Get($this)->GetLoginData();
        $pdfRender = PdfModel::GetPdfRender($apikey, $pdfID)[0];
        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];

        $head = $this->head;
        $head .= "<link href='" . BASE_URL . 'storage/' . $pdfRender['userID'] . '/' . $this->css . "' rel='stylesheet'>";
        $head .= "</head><body>";
        $path = file_get_contents(FILE . '/storage/' . $pdfRender['userID'] . '/' . $pdfRender['html']);
        $tail = $this->tail;
        $content = $head . $path . $tail;
        $filepath = FILE . '/storage/' . $session['ID'];
        file_put_contents($filepath . '/render-' . $this->reportname . '.html', $content);

        $render = new RenderEngine();
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($filepath . '/render-' . $this->reportname . '.html', json_decode($pdfRender['requestsample']));

        echo $template;

        /*
        $this->dompdf->setPaper($this->paper);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        $this->dompdf->stream($this->reportname, array("Attachment" => 0));
        */
    }

    public function limitations()
    {

    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = UserModel::GetUser($username, md5($password));
        return $loginResult[0]['ID'];
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return UserModel::GetUserById($id)[0];
    }
    #end region auth
}