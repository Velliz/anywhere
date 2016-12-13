<?php
/**
 * Anywhere
 *
 * Anywhere is output-as-a-service (OAAS) platform.
 *
 * This content is released under the Apache License Version 2.0, January 2004
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright (c) 2016, Didit Velliz
 *
 * @package	velliz/anywhere
 * @author	Didit Velliz
 * @link	https://github.com/velliz/anywhere
 * @since	Version 1.0.0
 *
 */
namespace controller;

use Dompdf\Options;
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
            <title>PDF Output - Anywhere</title>
            <style type="text/css">
HEAD;
    private $middle = <<<MIDDLE
            </style>
        </head>
        <body>
MIDDLE;
    private $tail = <<<TAIL
        </body>
        </html>
TAIL;

    public function __construct()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $this->dompdf = new DOMPDF($options);
    }

    /**
     * #Template html false
     */
    public function Main()
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) $this->RedirectTo(BASE_URL);

        if ((int)$session['statusID'] == 1) {
            $result = PdfModel::CountPDFUser($session['ID'])[0];
            if ((int)$result['result'] >= LIMITATIONS) $this->RedirectTo('limitations');
        }

        $snap_shoot = date('d-m-Y-His');

        $arrayData = array(
            'userID' => $session['ID'],
            'reportname' => 'PDF-' . $snap_shoot . '.pdf',
            'html' => '<div>Welcome to Anywhere!</div>',
            'css' => 'body {}',
            'outputmode' => 'Inline',
            'paper' => 'A4',
            'requesttype' => 'POST',
        );

        $pdfID = PdfModel::NewPdfPage($arrayData);
        $dataPDF = PdfModel::GetPdfPage($pdfID)[0];

        $this->RedirectTo('update/' . $dataPDF['PDFID']);
    }

    public function Update($id)
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

    public function Html($id_pdf)
    {
        $session = Session::Get($this)->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('PDFID' => $id_pdf);
            PdfModel::UpdatePdfPage($arrayID, array(
                'html' => $_POST['code']
            ));
        }

        $file['pdf'] = PdfModel::GetPdfPage($id_pdf);
        $file['html'] = $file['pdf'][0]['html'];

        return $file;
    }

    public function Style($id_pdf)
    {
        $session = Session::Get($this)->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('PDFID' => $id_pdf);
            PdfModel::UpdatePdfPage($arrayID, array(
                'css' => $_POST['code']
            ));
        }

        $file['pdf'] = PdfModel::GetPdfPage($id_pdf);
        $file['css'] = $file['pdf'][0]['css'];
        return $file;
    }

    /**
     * @param $api_key
     * @param $pdfId
     * @throws Exception
     *
     * #Template html false
     */
    public function CodeRender($api_key, $pdfId)
    {
        $pdfRender = PdfModel::GetPdfRender($api_key, $pdfId)[0];

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->html . $this->tail;

        $render = new RenderEngine('string');
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($htmlFactory, (array)json_decode($pdfRender['requestsample']));

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

    /**
     * #Template master false
     *
     * @param $api_key
     * @param $pdfID
     * @throws Exception
     */
    public function Render($api_key, $pdfID)
    {
        $pdfRender = PdfModel::GetPdfRender($api_key, $pdfID)[0];

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];
        $this->requesturl = $pdfRender['requesturl'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->html . $this->tail;

        $coreData = (array)json_decode($pdfRender['requestsample']);

        if ($this->requesttype == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $coreData = (array)json_decode($_POST['jsondata']);
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

            $coreData = (array)json_decode($fetch);
        }

        $render = new RenderEngine('string');
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($htmlFactory, $coreData);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        $this->dompdf->setPaper($this->paper);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        if ($this->outputmode == 'Inline') {
            $this->dompdf->stream($this->reportname, array("Attachment" => 0));
        }
        if ($this->outputmode == 'Download') {
            $this->dompdf->stream($this->reportname, array("Attachment" => 1));
        }
        exit();
    }

    public function Limitations()
    {

    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = UserModel::GetUser($username, $password);
        return (isset($loginResult[0]['ID'])) ? $loginResult[0]['ID'] : false;
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