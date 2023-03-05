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
use model\primary\log_mailContracts;
use model\primary\mailContracts;
use PHPMailer\PHPMailer\PHPMailer;
use plugins\controller\AnywhereView;
use pte\exception\PteException;
use pte\Pte;
use pukoframework\Request;
use pukoframework\Response;

/**
 * Class mail
 * @package controller
 *
 * #ClearOutput false
 * #ClearOutput value false
 * #Master master.html
 * #Value PageTitle Email Template
 */
class mail extends AnywhereView
{

    private $mailName;
    private $mailAddress;
    private $mailPassword;
    private $host;
    private $port;

    private $smtpauth;
    private $smtpsecure;
    private $requesttype;
    private $requesturl;
    private $requestsample;
    private $cssexternal;

    private $html;
    private $css;

    /**
     * @var PHPMailer
     */
    private $mail;

    private $head = <<<HEAD
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Mail Output - Anywhere</title>
            <style type="text/css">
                .preheader { display:none !important; visibility:hidden; opacity:0; color:transparent; height:0; width:0; }
HEAD;
    private $middle = <<<MIDDLE
            </style>
        </head>
        <body>
            <span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">{!preheader}</span>
MIDDLE;
    private $tail = <<<TAIL
        {!part(css)}
        </body>
        </html>
TAIL;

    public function __construct()
    {
        parent::__construct();
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->isHTML(true);
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $this->mail->SMTPDebug = 2;
        $this->mail->Debugoutput = 'html';
    }

    /**
     * @param $id_mail
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function update($id_mail)
    {
        $data['id_mail'] = $id_mail;
        $data['api_key'] = mailContracts::GetApiKeyById($id_mail);

        return $data;
    }

    /**
     * @param $id_mail
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function html($id_mail)
    {
        $data['id_mail'] = $id_mail;
        $data['api_key'] = mailContracts::GetApiKeyById($id_mail);

        return $data;
    }

    /**
     * @param $id_mail
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function style($id_mail)
    {
        $data['id_mail'] = $id_mail;
        $data['api_key'] = mailContracts::GetApiKeyById($id_mail);

        return $data;
    }

    /**
     * @param $api_key
     * @param $mailId
     * #Template html false
     * @throws PteException
     * @throws Exception
     */
    public function coderender($api_key, $mailId)
    {
        $mailRender = mailContracts::GetMailRender($api_key, $mailId);

        $this->mailName = $mailRender['mail_name'];
        $this->mailAddress = $mailRender['mail_address'];
        $this->mailPassword = $mailRender['mail_password'];

        $this->html = $mailRender['html'];
        $this->css = $mailRender['css'];

        $this->host = $mailRender['host'];
        $this->port = $mailRender['port'];

        $this->smtpauth = $mailRender['smtp_auth'];
        $this->smtpsecure = $mailRender['smtp_secure'];
        $this->requesttype = $mailRender['request_type'];
        $this->requesturl = $mailRender['request_url'];
        $this->requestsample = $mailRender['request_sample'];
        $this->cssexternal = $mailRender['css_external'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->cssexternal . $this->html . $this->tail;

        $response = new Response();
        $response->useMasterLayout = false;

        $render = new Pte(false);
        if ($response->useMasterLayout) {
            $render->SetMaster($response->htmlMaster);
        }
        $render->SetValue(json_decode($this->requestsample, true));
        $render->SetHtml($htmlFactory, true);
        $template = $render->Output($this, Pte::VIEW_HTML);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");

        echo $template;
        exit();
    }

    /**
     * @param $api_key
     * @param $mailId
     * @throws PteException
     * @throws Exception
     */
    public function render($api_key, $mailId)
    {
        $mailRender = mailContracts::GetMailRender($api_key, $mailId);

        $this->mailName = $mailRender['mail_name'];
        $this->mailAddress = $mailRender['mail_address'];
        $this->mailPassword = $mailRender['mail_password'];

        $this->html = $mailRender['html'];
        $this->css = $mailRender['css'];

        $this->host = $mailRender['host'];
        $this->port = $mailRender['port'];

        $this->smtpauth = $mailRender['smtp_auth'];
        $this->smtpsecure = $mailRender['smtp_secure'];
        $this->requesttype = $mailRender['request_type'];
        $this->requesturl = $mailRender['request_url'];
        $this->requestsample = $mailRender['request_sample'];
        $this->cssexternal = $mailRender['css_external'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->cssexternal . $this->html . $this->tail;

        $coreData = array();

        header("Author: Anywhere 0.1");

        $this->mail->Host = $this->host;
        $this->mail->SMTPAuth = ($this->smtpauth == 'true') ? true : false;
        $this->mail->Username = $this->mailAddress;
        $this->mail->Password = $this->mailPassword;
        $this->mail->SMTPSecure = $this->smtpsecure;
        $this->mail->Port = (int)$this->port;

        if ($this->requesttype == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $coreData = (array)json_decode($_POST['jsondata'], true);
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
            $coreData = (array)json_decode($fetch, true);
        }

        if (!isset($coreData['to'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'mail destination not defined.';
            die(json_encode($data));
        }

        if (!isset($coreData['subject'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'mail subject not defined.';
            die(json_encode($data));
        }

        $this->mail->setFrom($this->mailAddress, $this->mailName);
        $this->mail->addAddress($coreData['to']);

        if (isset($coreData['replyto']) && isset($coreData['replyname']))
            $this->mail->addReplyTo($coreData['replyto'], $coreData['replyname']);

        if (isset($coreData['cc'])) $this->mail->addCC($coreData['cc']);
        if (isset($coreData['bcc'])) $this->mail->addBCC($coreData['bcc']);

        if (isset($coreData['attachment']) && is_array($coreData['attachment'])) {
            foreach ($coreData['attachment'] as $key => $val) {
                $this->mail->addStringAttachment(file_get_contents($val->url), $val->name);
            }
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

        $this->mail->Subject = $coreData['subject'];
        $this->mail->msgHTML($template);
        $this->mail->AltBody = $this->formatHtml2Text($template);

        Request::OutputBufferStart();

        $response = array();
        if (!$this->mail->send()) {
            $response['IsSuccess'] = false;
            $response['Message'] = 'Message could not be sent';
            $response['ErrorMessage'] = $this->mail->ErrorInfo;
        } else {
            $response['IsSuccess'] = true;
            $response['Message'] = 'Message sent';
        }

        //save logs
        $log_mail = new \plugins\model\primary\log_mail();
        $log_mail->created = $this->GetServerDateTime();
        $log_mail->cuid = $mailRender['user_id'];

        $log_mail->mail_id = $mailRender['id'];
        $log_mail->user_id = $mailRender['user_id'];
        $log_mail->sent_at = $this->GetServerDateTime();
        $log_mail->json_data = json_encode($coreData, true);
        $log_mail->result_data = json_encode($response, true);
        $log_mail->debug_info = Request::OutputBufferClean();
        $log_mail->processing_time = $render->GetElapsedTime();
        $log_mail->save();

        echo json_encode($response);
        exit();
    }

    public function timelinerender($logID, $api_key, $mailId)
    {
        $mailRender = mailContracts::GetMailRender($api_key, $mailId);
        $logData = log_mailContracts::GetById($logID);

        $this->mailName = $mailRender['mail_name'];
        $this->mailAddress = $mailRender['mail_address'];

        $this->html = $mailRender['html'];
        $this->css = $mailRender['css'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->cssexternal . $this->html . $this->tail;

        $coreData = (array)json_decode($logData['json_data'], true);

        $render = new Pte(false);
        $render->SetValue($coreData);
        $render->SetHtml($htmlFactory, true);
        $template = $render->Output($this, Pte::VIEW_HTML);

        echo $template;
        exit();
    }

    /**
     * Strips extra whitespace, breaklines.
     *
     * This is a workaround to format correctly plain text body messages.
     * if we use the function AltBody to auto format our html from the
     * template the text message can get multiple break lines and spaces.
     *
     * @param string $str
     * @return string
     */
    private function formatHtml2Text($str)
    {

        return preg_replace('/\s{2,}/u', "\n\r", $str);
    }

    /**
     * @param $id_mail
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function timeline($id_mail = '')
    {
        $data['id_mail'] = $id_mail;
        $data['api_key'] = mailContracts::GetApiKeyById($id_mail);

        return $data;
    }

}
