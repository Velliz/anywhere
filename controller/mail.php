<?php
namespace controller;

use PHPMailer\PHPMailer\PHPMailer;
use pukoframework\auth\Auth;
use pukoframework\pte\View;

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
    public function main()
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

    public function Login($username, $password)
    {
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
    }
}