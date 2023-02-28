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
 * @package    velliz/anywhere
 * @author    Didit Velliz
 * @link    https://github.com/velliz/anywhere
 * @since    Version 1.0.0
 *
 */

namespace controller;

use Exception;
use model\primary\constantaContracts;
use model\primary\log_pdfContracts;
use model\primary\pdfContracts;
use Dompdf\Options;
use Dompdf\Dompdf;
use plugins\controller\AnywhereView;
use plugins\model\primary\log_pdf;
use pte\Pte;
use pukoframework\Response;

/**
 * Class pdf
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 * #Value PageTitle PDF Templates
 */
class pdf extends AnywhereView
{

    private $outputmode;
    private $paper;
    private $orientation;
    private $html;
    private $css;
    private $reportname;
    private $requesttype;
    private $requesturl;
    private $requestsample;
    private $cssexternal;

    /**
     * @var Dompdf
     */
    private $dompdf;

    private $head = "<!DOCTYPE html><html><body><style type='text/css'>";
    private $middle = "</style>";
    private $php_head = "<script type='text/php'>";
    private $php_tail = "</script>";
    private $tail = "</body></html>";

    /**
     * pdf constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $this->dompdf = new Dompdf($options);
    }

    /**
     * @param $id_pdf
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function update($id_pdf)
    {
        $data['id_pdf'] = $id_pdf;
        $data['api_key'] = pdfContracts::GetApiKeyById($id_pdf);

        return $data;
    }

    /**
     * @param $id_pdf
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function html($id_pdf)
    {
        $data['id_pdf'] = $id_pdf;
        $data['api_key'] = pdfContracts::GetApiKeyById($id_pdf);

        return $data;
    }

    /**
     * @param $id_pdf
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function style($id_pdf)
    {
        $data['id_pdf'] = $id_pdf;
        $data['api_key'] = pdfContracts::GetApiKeyById($id_pdf);

        return $data;
    }

    /**
     * @param $api_key
     * @param $pdfId
     * @throws Exception
     */
    public function coderender($api_key, $pdfId)
    {
        $pdfRender = pdfContracts::GetPdfRender($api_key, $pdfId);

        $this->outputmode = $pdfRender['output_mode'];
        $this->paper = $pdfRender['paper'];
        $this->orientation = $pdfRender['orientation'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['report_name'];
        $this->requesttype = $pdfRender['request_type'];
        $this->requestsample = $pdfRender['request_sample'];
        $this->cssexternal = $pdfRender['css_external'];

        $script = $pdfRender['php_script'];
        $php_script = $this->php_head . $script . $this->php_tail;

        $htmlFactory = $this->head . $this->css . $this->middle . $php_script . $this->cssexternal . $this->html . $this->tail;

        $render = new Pte(false);

        $render->SetValue(json_decode($this->requestsample, true));
        $render->SetHtml($htmlFactory, true);
        $template = $render->Output($this);

        $this->dompdf->setPaper($this->paper, $this->orientation);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename='{$this->reportname}.pdf'");

        $this->dompdf->stream("{$this->reportname}.pdf", [
            'Attachment' => 0
        ]);

        exit();
    }

    /**
     * #Template master false
     * @param $api_key
     * @param $pdfId
     * @throws Exception
     */
    public function render($api_key, $pdfId)
    {
        $pdfRender = pdfContracts::GetPdfRender($api_key, $pdfId);

        //because render executed outside vars need to be re-supplied
        $this->vars = constantaContracts::SearchData([
            'user_id' => $pdfRender['user_id']
        ]);

        $this->outputmode = $pdfRender['output_mode'];
        $this->paper = $pdfRender['paper'];
        $this->orientation = $pdfRender['orientation'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['report_name'];
        $this->requesttype = $pdfRender['request_type'];
        $this->requestsample = $pdfRender['request_sample'];
        $this->cssexternal = $pdfRender['css_external'];
        $this->requesturl = $pdfRender['request_url'];

        $script = $pdfRender['php_script'];
        $php_script = $this->php_head . $script . $this->php_tail;

        $htmlFactory = $this->head . $this->css . $this->middle . $php_script . $this->cssexternal . $this->html . $this->tail;

        $coreData = (array)json_decode($this->requestsample);

        if ($this->requesttype == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                header('Content-Type: application/json');
                die(json_encode($data));
            }
            $coreData = (array)json_decode($_POST['jsondata'], true);
        }

        if ($this->requesttype == 'URL') {
            $data['status'] = 'success';
            if ($this->requesturl == '') {
                $data['status'] = 'failed';
                $data['reason'] = 'request URL not defined.';
                header('Content-Type: application/json');
                die(json_encode($data));
            }
            $fetch = file_get_contents($this->requesturl);
            if (!$fetch) {
                $data['status'] = 'failed';
                $data['reason'] = 'url return zero data.';
                header('Content-Type: application/json');
                die(json_encode($data));
            }

            $coreData = (array)json_decode($fetch, true);
        }

        $response = new Response();
        $response->useMasterLayout = false;

        $render = new Pte(false);
        if ($response->useMasterLayout) {
            $render->SetMaster($response->htmlMaster);
        }
        $render->SetValue($coreData);
        $render->SetHtml($htmlFactory, true);
        $template = $render->Output($this, Pte::VIEW_HTML);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        $this->dompdf->setPaper($this->paper, $this->orientation);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        //save logs
        $log_pdf = new log_pdf();
        $log_pdf->created = $this->GetServerDateTime();
        $log_pdf->cuid = $pdfRender['user_id'];

        $log_pdf->pdf_id = $pdfId;
        $log_pdf->user_id = $pdfRender['user_id'];
        $log_pdf->sent_at = $this->GetServerDateTime();
        $log_pdf->json_data = json_encode($coreData, true);
        $log_pdf->creator_info = $_POST['creator'] ?? null;
        $log_pdf->processing_time = $render->GetElapsedTime();
        $log_pdf->save();

        if ($this->outputmode == 'Inline') {
            $this->dompdf->stream($this->reportname . '.pdf', array("Attachment" => 0));
        }
        if ($this->outputmode == 'Download') {
            $this->dompdf->stream($this->reportname . '.pdf', array("Attachment" => 1));
        }
        exit();
    }

    /**
     * @param $logID
     * @param $api_key
     * @param $pdfId
     * @throws Exception
     */
    public function timelinerender($logID, $api_key, $pdfId)
    {
        $pdfRender = pdfContracts::GetPdfRender($api_key, $pdfId);
        $logData = log_pdfContracts::GetById($logID);

        //because render executed outside vars need to be re-supplied
        $this->vars = constantaContracts::SearchData([
            'user_id' => $pdfRender['user_id']
        ]);

        $this->outputmode = $pdfRender['outputmode'];
        $this->paper = $pdfRender['paper'];
        $this->orientation = $pdfRender['orientation'];
        $this->html = $pdfRender['html'];
        $this->css = $pdfRender['css'];
        $this->reportname = $pdfRender['reportname'];
        $this->requesttype = $pdfRender['requesttype'];
        $this->requestsample = $pdfRender['requestsample'];
        $this->cssexternal = $pdfRender['cssexternal'];
        $this->requesturl = $pdfRender['requesturl'];

        $script = $pdfRender['phpscript'];
        $php_script = $this->php_head . $script . $this->php_tail;

        $htmlFactory = $this->head . $this->css . $this->middle . $php_script . $this->cssexternal . $this->html . $this->tail;

        $coreData = (array)json_decode($logData['jsondata'], true);

        $response = new Response();
        $response->useMasterLayout = false;

        $render = new Pte(false);
        if ($response->useMasterLayout) {
            $render->SetMaster($response->htmlMaster);
        }
        $render->SetValue($coreData);
        $render->SetHtml($htmlFactory, true);
        $template = $render->Output($this, Pte::VIEW_HTML);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/pdf');

        $this->dompdf->setPaper($this->paper, $this->orientation);
        $this->dompdf->loadHtml($template);
        $this->dompdf->render();

        if ($this->outputmode == 'Inline') {
            $this->dompdf->stream($this->reportname . '.pdf', array("Attachment" => 0));
        }
        if ($this->outputmode == 'Download') {
            $this->dompdf->stream($this->reportname . '.pdf', array("Attachment" => 1));
        }
        exit();
    }

    /**
     * @param $id_pdf
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function timeline($id_pdf)
    {
        $data['id_pdf'] = $id_pdf;
        $data['api_key'] = pdfContracts::GetApiKeyById($id_pdf);

        return $data;
    }

}
