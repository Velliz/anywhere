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

use model\ConstantaModel;
use plugins\auth\AnywhereAuthenticator;
use Dompdf\Exception;
use model\LogMail;
use model\MailModel;
use model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use plugins\controller\AnywhereView;
use pte\exception\PteException;
use pte\Pte;
use pukoframework\auth\Session;
use pukoframework\Framework;
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
        $this->mail->SMTPOptions = ['ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]];
        $this->mail->SMTPDebug = 2;
        $this->mail->Debugoutput = 'html';
    }

    /**
     * #Template html false
     * #Auth session true
     *
     * initialize a new email template
     * then redirect to configure
     * @throws \Exception
     */
    public function Main()
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (!isset($session['ID'])) $this->RedirectTo(Framework::$factory->getBase());

        if ((int)$session['statusID'] == 1) {
            $result = MailModel::CountMailUser($session['ID'])[0];
            if ((int)$result['result'] >= $session['limitations']) $this->RedirectTo('limitations');
        }


        $snap_shoot = date('d-m-Y-His');

        $arrayData = array(
            'userID' => $session['ID'],
            'mailname' => 'MAIL-' . $snap_shoot . '.html',
            'html' => '<div>Welcome to Anywhere!</div>',
            'css' => 'body {}',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'smtpauth' => 'true',
            'smtpsecure' => 'tls',
            'requesttype' => 'POST',
            'requesturl' => '',
            'requestsample' => json_encode(array(
                'to' => 'example@anywhere.com',
                'subject' => 'Test Email',
                'attachment' => array(
                    array(
                        'name' => 'attachment1',
                        'url' => 'http://localhost/anywhere/qr/render?data=1234567890'
                    ),
                    array(
                        'name' => 'attachment2',
                        'url' => 'http://localhost/anywhere/qr/render?data=abcdefghijklmnopqrstuvwxyz'
                    ),
                )
            ), JSON_PRETTY_PRINT),
        );

        $mailID = MailModel::NewMailPage($arrayData);
        $dataMAIL = MailModel::GetMailPage($mailID)[0];

        $this->RedirectTo('update/' . $dataMAIL['MAILID']);
    }

    /**
     * @param $id
     * @return bool
     *
     * #Auth session true
     * @throws \Exception
     * #Master master-codes.html
     */
    public function Update($id)
    {
        if (!is_numeric($id)) throw new Exception("ID not defined");

        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();

        if (isset($_POST['mailid'])) {

            $mailid = Request::Post('mailid', null);
            $mailName = Request::Post('mailname', null);

            $host = Request::Post('host', null);
            $port = Request::Post('port', null);
            $requesttype = Request::Post('requesttype', null);

            $resultUpdate = MailModel::UpdateMailPage(
                array('MAILID' => $mailid),
                array(
                    'mailname' => $mailName,
                    'mailaddress' => $_POST['mailaddress'],
                    'mailpassword' => $_POST['mailpassword'],
                    'host' => $host,
                    'port' => $port,
                    'smtpauth' => $_POST['smtpauth'],
                    'smtpsecure' => $_POST['smtpsecure'],
                    'requesttype' => $requesttype,
                    'requesturl' => $_POST['requesturl'],
                    'requestsample' => $_POST['requestsample'],
                    'cssexternal' => $_POST['cssexternal'],
                ));

            if (!$resultUpdate) {
                $this->RedirectTo(Framework::$factory->getBase() . 'sorry');
            }
        }
        $dataMAIL = $session;
        $dataMAIL['mail'] = MailModel::GetMailPage($id);

        $dataMAIL['PageTitle'] = $dataMAIL['mail'][0]['mailname'];

        foreach ($dataMAIL['mail'] as $key => $value) {
            $dataMAIL['mail'][$key]['apikey'] = $session['apikey'];
            switch ($value['requesttype']) {
                case 'POST':
                    $dataMAIL['mail'][$key]['POST'] = 'checked';
                    break;
                case 'URL':
                    $dataMAIL['mail'][$key]['URL'] = 'checked';
                    break;
            }

        }

        return $dataMAIL;
    }

    /**
     * @param $id_mail
     * @return bool
     *
     * #Auth session true
     * @throws \Exception
     * #Master master-codes.html
     */
    public function Html($id_mail)
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('MAILID' => $id_mail);
            MailModel::UpdateMailPage($arrayID, array(
                'html' => $_POST['code']
            ));
        }

        $file['mail'] = MailModel::GetMailPage($id_mail);

        $file['PageTitle'] = "[HTML] " . $file['mail'][0]['mailname'];

        foreach ($file['mail'] as $key => $val) {
            $val['apikey'] = $session['apikey'];
            $file['mail'][$key] = $val;
        }
        $file['html'] = $file['mail'][0]['html'];

        $file['designer'] = [];
        $file['style'] = [
            'ID' => $id_mail
        ];

        return $file;
    }

    /**
     * @param $id_mail
     * @return bool
     *
     * #Auth session true
     * @throws \Exception
     * #Master master-codes.html
     */
    public function Style($id_mail)
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('MAILID' => $id_mail);
            MailModel::UpdateMailPage($arrayID, array(
                'css' => $_POST['code']
            ));
        }

        $file['mail'] = MailModel::GetMailPage($id_mail);

        $file['PageTitle'] = "[CSS] " . $file['mail'][0]['mailname'];

        foreach ($file['mail'] as $key => $val) {
            $val['apikey'] = $session['apikey'];
            $file['mail'][$key] = $val;
        }
        $file['css'] = $file['mail'][0]['css'];

        $file['designer'] = [
            'ID' => $id_mail
        ];
        $file['style'] = [];

        return $file;
    }

    /**
     * @param $api_key
     * @param $mailId
     * @throws Exception
     *
     * #Template html false
     * #Auth session true
     * @throws PteException
     * @throws \Exception
     */
    public function CodeRender($api_key, $mailId)
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();

        if (!isset($session['ID'])) throw new Exception("Session Expired");

        $mailRender = MailModel::GetMailRender($api_key, $mailId)[0];

        $this->mailName = $mailRender['mailname'];
        $this->mailAddress = $mailRender['mailaddress'];
        $this->mailPassword = $mailRender['mailpassword'];

        $this->html = $mailRender['html'];
        $this->css = $mailRender['css'];

        $this->host = $mailRender['host'];
        $this->port = $mailRender['port'];

        $this->smtpauth = $mailRender['smtpauth'];
        $this->smtpsecure = $mailRender['smtpsecure'];
        $this->requesttype = $mailRender['requesttype'];
        $this->requesturl = $mailRender['requesturl'];
        $this->requestsample = $mailRender['requestsample'];
        $this->cssexternal = $mailRender['cssexternal'];

        $htmlFactory = $this->head . $this->css . $this->middle . $this->cssexternal . $this->html . $this->tail;

        $response = new Response();
        $response->useMasterLayout = false;

        $render = new Pte(false);
        if ($response->useMasterLayout) {
            $render->SetMaster($response->htmlMaster);
        }
        $render->SetValue(json_decode($mailRender['requestsample'], true));
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
     * @throws \Exception
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function Render($api_key, $mailId)
    {
        $mailRender = MailModel::GetMailRender($api_key, $mailId)[0];

        //because render executed outside vars need to be re-supplied
        $this->vars = ConstantaModel::GetCollection($mailRender['userID']);

        $this->mailName = $mailRender['mailname'];
        $this->mailAddress = $mailRender['mailaddress'];
        $this->mailPassword = $mailRender['mailpassword'];

        $this->html = $mailRender['html'];
        $this->css = $mailRender['css'];

        $this->host = $mailRender['host'];
        $this->port = $mailRender['port'];

        $this->smtpauth = $mailRender['smtpauth'];
        $this->smtpsecure = $mailRender['smtpsecure'];
        $this->requesttype = $mailRender['requesttype'];
        $this->requesturl = $mailRender['requesturl'];
        $this->requestsample = $mailRender['requestsample'];
        $this->cssexternal = $mailRender['cssexternal'];

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
                /*
                $fileData = apc_fetch($val->name, $cacheResult);
                if ($cacheResult) {
                    $this->mail->addStringAttachment($fileData, $val->name);
                } else {
                    $fileData = file_get_contents($val->url);
                    apc_store($val->name, $fileData, Auth::EXPIRED_1_HOUR);
                    $this->mail->addStringAttachment($fileData, $val->name);
                }
                */
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

        LogMail::Create(array(
            'MAILID' => $mailId,
            'userid' => UserModel::UserIdByApiKey($api_key),
            'sentat' => $this->GetServerDateTime(),
            'jsondata' => json_encode($coreData),
            'resultdata' => json_encode($response),
            'debuginfo' => Request::OutputBufferClean(),
            'processingtime' => microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],
        ));

        echo json_encode($response);
        exit();
    }

    public function Limitations()
    {
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
}