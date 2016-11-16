<?php
namespace controller;

use Dompdf\Exception;
use model\MailModel;
use model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\RenderEngine;
use pukoframework\pte\View;
use pukoframework\Request;

/**
 * Class mail
 * @package controller
 *
 * #Auth true
 * #ClearOutput false
 */
class mail extends View implements Auth
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
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->isHTML(true);

        //$this->mail->SMTPDebug = 2;
        //$this->mail->Debugoutput = 'html';

        $this->mail->SMTPOptions = ['ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]];
    }

    /**
     * #Template html false
     * #Auth true
     * #ClearOutput false
     *
     * initialize a new email template
     * then redirect to configure
     */
    public function Main()
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) $this->RedirectTo(BASE_URL);

        if ((int)$session['statusID'] == 1) {
            $result = MailModel::CountMailUser($session['ID'])[0];
            if ((int)$result['result'] >= 2) $this->RedirectTo('limitations');
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
        );

        $mailID = MailModel::NewMailPage($arrayData);
        $dataMAIL = MailModel::GetMailPage($mailID)[0];

        $this->RedirectTo('update/' . $dataMAIL['MAILID']);
    }

    public function Update($id)
    {
        if (!is_numeric($id)) throw new Exception("ID not defined");

        $session = Session::Get($this)->GetLoginData();

        if (Request::IsPost()) {
            $mailid = Request::Post('mailid', null);
            $mailName = Request::Post('mailname', null);

            $mailAddress = Request::Post('mailaddress', null);
            $mailPassword = Request::Post('mailpassword', null);

            $host = Request::Post('host', null);
            $port = Request::Post('port', null);

            $smtpauth = Request::Post('smtpauth', null);
            $smtpsecure = Request::Post('smtpsecure', null);

            $requesttype = Request::Post('requesttype', null);
            $requesturl = Request::Post('requesturl', null);

            $requestsample = Request::Post('requestsample', null);

            $resultUpdate = MailModel::UpdateMailPage(
                array('MAILID' => $mailid),
                array(
                    'mailname' => $mailName,
                    'mailaddress' => $mailAddress,
                    'mailpassword' => $mailPassword,
                    'host' => $host,
                    'port' => $port,
                    'smtpauth' => $smtpauth,
                    'smtpsecure' => $smtpsecure,
                    'requesttype' => $requesttype,
                    'requesturl' => $requesturl,
                    'requestsample' => $requestsample,
                ));

            if ($resultUpdate) $this->RedirectTo(BASE_URL . 'beranda');
            $this->RedirectTo(BASE_URL . 'sorry');
        }
        $dataMAIL = $session;
        $dataMAIL['mail'] = MailModel::GetMailPage($id);

        foreach ($dataMAIL['mail'] as $key => $value) {
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

    public function Html($id_mail)
    {
        $session = Session::Get($this)->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('MAILID' => $id_mail);
            MailModel::UpdateMailPage($arrayID, array(
                'html' => $_POST['code']
            ));
        }

        $file['mail'] = MailModel::GetMailPage($id_mail);
        $file['html'] = $file['mail'][0]['html'];

        return $file;
    }

    public function Style($id_mail)
    {
        $session = Session::Get($this)->GetLoginData();
        $file = $session;
        if (isset($_POST['code'])) {
            $arrayID = array('MAILID' => $id_mail);
            MailModel::UpdateMailPage($arrayID, array(
                'css' => $_POST['code']
            ));
        }

        $file['mail'] = MailModel::GetMailPage($id_mail);
        $file['css'] = $file['mail'][0]['css'];

        return $file;
    }

    /**
     * @param $api_key
     * @param $mailId
     *
     * @throws Exception
     * @throws \Exception
     *
     * #Template html false
     */
    public function CodeRender($api_key, $mailId)
    {
        $session = Session::Get($this)->GetLoginData();

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

        $htmlFactory = $this->head . $this->css . $this->middle . $this->html . $this->tail;

        $render = new RenderEngine('string');
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($htmlFactory, json_decode($mailRender['requestsample']));

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");

        echo $template;
        exit();
    }

    /**
     * @param $api_key
     * @param $mailId
     * @throws Exception
     * @throws \Exception
     *
     * #Template html false
     */
    public function Render($api_key, $mailId)
    {
        $session = Session::Get($this)->GetLoginData();

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

        $htmlFactory = $this->head . $this->css . $this->middle . $this->html . $this->tail;

        $render = new RenderEngine('string');
        $render->clearOutput = false;
        $render->useMasterLayout = false;
        $template = $render->PTEParser($htmlFactory, (array) json_decode($mailRender['requestsample']));

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/json');

        $this->mail->Host = $this->host;
        $this->mail->SMTPAuth = ($this->smtpauth == 'true') ? true : false;
        $this->mail->Username = $this->mailAddress;
        $this->mail->Password = $this->mailPassword;
        $this->mail->SMTPSecure = $this->smtpsecure;
        $this->mail->Port = (int) $this->port;

        $data = (array) json_decode($mailRender['requestsample']);

        // sender
        $this->mail->setFrom($this->mailAddress, $this->mailName);
        // Add a recipient
        $this->mail->addAddress($data['to']);

        //$this->mail->addReplyTo('info@example.com', 'Information');
        //$this->mail->addCC('bcc@example.com');
        //$this->mail->addBCC('bcc@example.com');

        // Add attachments
        //$this->mail->addAttachment('/var/tmp/file.tar.gz');
        //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');

        $this->mail->Subject = $data['subject'];
        $this->mail->Body = $template;
        $this->mail->AltBody = $template;

        $response = array();
        if (!$this->mail->send()) {
            $response['IsSuccess'] = false;
            $response['Message'] = 'Message could not be sent';
            $response['ErrorMessage'] = $this->mail->ErrorInfo;
        } else {
            $response['IsSuccess'] = true;
            $response['Message'] = 'Message sent';
        }

        echo json_encode($response);
        exit();
    }

    public function Limitations()
    {
    }

    public function Login($username, $password)
    {
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return UserModel::GetUserById($id)[0];
    }
}