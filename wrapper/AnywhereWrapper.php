<?php

abstract class AnywhereWrapper
{

    const PDF = 1;
    const IMAGES = 2;
    const EMAIL = 3;

    const POST = 9;
    const GET = 8;
    const URL = 7;

    var $mode;

    var $requestType;
    var $requestUrl;

    var $jsonData = array();
    var $attachmentData = array();

    var $apiUrl;

    public function __construct()
    {
        $this->Init();
    }

    public function getData()
    {
        return $this->jsonData;
    }

    public function getAttachment()
    {
        return $this->attachmentData;
    }

    protected abstract function Init();

    public abstract function Send($apiUrl);

}

class AnywhereImage extends AnywhereWrapper
{

    protected function Init()
    {

    }

    public function Send($apiUrl)
    {

    }
}

class AnywherePdf extends AnywhereWrapper
{

    public function __construct($requestType, $requestUrl = null)
    {
        parent::__construct();
        $this->requestType = $requestType;
        $this->requestUrl = $requestUrl;
    }

    public function setValue($key, $value)
    {
        if ($key == null)
            throw new Exception('Key not set.');
        if ($value == null)
            throw new Exception('Value not set.');
        $this->jsonData[$key] = $value;
    }

    protected function Init()
    {
        $this->mode = AnywhereWrapper::PDF;
    }

    public function Send($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->jsonData['attachment'] = $this->attachmentData;
        $post['jsondata'] = json_encode($this->jsonData);

        if ($this->requestType == AnywhereWrapper::POST) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Anywhere Wrapper');
            $response = curl_exec($curl);
            curl_close($curl);

            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
            header("Author: Anywhere 0.1");
            header('Content-Type: application/pdf');
            
            echo $response;
        }
    }
}

class AnywhereMail extends AnywhereWrapper
{

    public function __construct($requestType, $requestUrl = null)
    {
        parent::__construct();
        $this->requestType = $requestType;
        $this->requestUrl = $requestUrl;
    }

    public function setTo($destinationEmail)
    {
        if ($destinationEmail == null)
            throw new Exception('Destination email not set.');
        $this->jsonData['to'] = $destinationEmail;
    }

    public function setValue($key, $value)
    {
        if ($key == null)
            throw new Exception('Key not set.');
        if ($value == null)
            throw new Exception('Value not set.');
        $this->jsonData[$key] = $value;
    }

    public function setCc($cc)
    {
        if ($cc == null)
            throw new Exception('CC not set.');
        $this->jsonData['cc'] = $cc;
    }

    public function setBcc($cc)
    {
        if ($cc == null)
            throw new Exception('BCC not set.');
        $this->jsonData['bcc'] = $cc;
    }

    public function setSubject($subject)
    {
        if ($subject == null)
            throw new Exception('Subject email not set.');
        $this->jsonData['subject'] = $subject;
    }

    public function setReplyTo($replyEmail)
    {
        if ($replyEmail == null)
            throw new Exception('Reply email not set.');
        $this->jsonData['replyto'] = $replyEmail;
    }

    public function setAttachment($fileName, $fileUrl)
    {
        if ($fileName == null)
            throw new Exception('File name not set.');
        if ($fileUrl == null)
            throw new Exception('File url not set.');

        array_push($this->attachmentData, array(
            'name' => $fileName,
            'url' => $fileUrl
        ));
    }

    protected function Init()
    {
        $this->mode = AnywhereWrapper::EMAIL;
    }

    public function Send($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->jsonData['attachment'] = $this->attachmentData;
        $post['jsondata'] = json_encode($this->jsonData);

        if ($this->requestType == AnywhereWrapper::POST) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Anywhere Wrapper');
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
            curl_exec($curl);
            curl_close($curl);
        }
    }
}