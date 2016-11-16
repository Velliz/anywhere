<?php
namespace controller;

use Dompdf\Exception;
use model\MailModel;
use model\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
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

    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
        $this->mail->SMTPOptions = ['ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]];
    }

    /**
     * #Template html false
     */
    public function Testing()
    {
        // Specify main and backup SMTP servers
        $this->mail->Host = '';
        // Enable SMTP authentication
        $this->mail->SMTPAuth = true;
        // SMTP username
        $this->mail->Username = '';
        // SMTP password
        $this->mail->Password = '';
        // Enable TLS encryption, `ssl` also accepted
        $this->mail->SMTPSecure = 'tls';
        // TCP port to connect to
        $this->mail->Port = 587;

        $this->mail->setFrom('system@example.com', 'Mail Systems');
        // Add a recipient
        $this->mail->addAddress('diditvelliz@example.com');
        // Name is optional
        //$this->mail->addReplyTo('info@example.com', 'Information');
        //$this->mail->addBCC('bcc@example.com');

        // Add attachments
        //$this->mail->addAttachment('/var/tmp/file.tar.gz');
        // Optional name
        //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');
        // Set email format to HTML
        $this->mail->isHTML(true);

        $this->mail->Subject = 'Here is the TES Mail';
        $this->mail->Body = 'This is the TEST message body <b>in bold!</b> send automatic by systems';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$this->mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $this->mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
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

            $emailAddess = Request::Post('mailaddress', null);
            $emailPassword = Request::Post('mailpassword', null);

            $host = Request::Post('host', null);
            $port = Request::Post('port', null);

            $smtpauth = Request::Post('smtpauth', null);
            $smtpsecure = Request::Post('smtpsecure', null);

            $requesttype = Request::Post('requesttype', null);
            $requesturl = Request::Post('requesturl', null);
            $requestsample = Request::Post('requestsample', null);

            //TODO: save data
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

    public function Html()
    {
    }

    public function Style()
    {
    }

    public function CodeRender()
    {
    }

    public function Render()
    {
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