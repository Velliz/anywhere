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

use Exception;
use model\ImageModel;
use model\UserModel;

use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use pukoframework\Request;

/**
 * Class images
 * @package controller
 *
 * #ClearOutput false
 * #Master master-images.html
 */
class images extends View implements Auth
{

    /**
     * #Template html false
     * #Auth true +
     */
    public function Main()
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) $this->RedirectTo(BASE_URL);

        if ((int)$session['statusID'] == 1) {
            $result = ImageModel::CountImageUser($session['ID'])[0];
            if ((int)$result['result'] >= LIMITATIONS) $this->RedirectTo('limitations');
        }
        $snap_shoot = date('d-m-Y-His');
        $arrayData = array(
            'userID' => $session['ID'],
            'imagename' => 'IMAGE-' . $snap_shoot . '.jpg',
            'requesttype' => 'URL',
            'requestsample' => json_encode(
                array(
                    'url' => BASE_URL . 'qr/render?data=developer@example.com',
                )
            )
        );
        $imageID = ImageModel::NewImagePage($arrayData);
        $dataIMAGE = ImageModel::GetImagePage($imageID)[0];

        $this->RedirectTo('update/' . $dataIMAGE['IMAGEID']);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     *
     * #Auth true +
     */
    public function Update($id)
    {
        if (!is_numeric($id)) throw new Exception("ID not defined");

        $session = Session::Get($this)->GetLoginData();

        if (Request::IsPost()) {

            $imageid = Request::Post('imageid', null);
            $imageName = Request::Post('imagename', null);

            $x = Request::Post('x', null);
            $x2 = Request::Post('x2', null);
            $y = Request::Post('y', null);
            $y2 = Request::Post('y2', null);
            $w = Request::Post('w', null);
            $h = Request::Post('h', null);
            $requesttype = Request::Post('requesttype', null);
            $requesturl = Request::Post('requesturl', null);

            $resultUpdate = ImageModel::UpdateImagePage(
                array('IMAGEID' => $imageid),
                array(
                    'imagename' => $imageName,
                    'x' => $x,
                    'x2' => $x2,
                    'y' => $y,
                    'y2' => $y2,
                    'w' => $w,
                    'h' => $h,
                    'requesttype' => $requesttype,
                    'requesturl' => $requesturl,
                ));

            if ($resultUpdate) $this->RedirectTo(BASE_URL . 'beranda');
            $this->RedirectTo(BASE_URL . 'sorry');
        }
        $dataIMAGE = $session;
        $dataIMAGE['image'] = ImageModel::GetImagePage($id);
        foreach ($dataIMAGE['image'] as $key => $value) {
            switch ($value['requesttype']) {
                case 'POST':
                    $dataIMAGE['image'][$key]['POST'] = 'checked';
                    break;
                case 'URL':
                    $dataIMAGE['image'][$key]['URL'] = 'checked';
                    break;
                case 'GET':
                    $dataIMAGE['image'][$key]['GET'] = 'checked';
                    break;
            }
        }

        return $dataIMAGE;
    }

    /**
     * @param $api_key
     * @param $imageId
     * @throws Exception
     *
     * #Template html false
     * #Auth false
     */
    public function Render($api_key, $imageId)
    {
        $mailRender = ImageModel::GetImageRender($api_key, $imageId)[0];

        $imageName = $mailRender['imagename'];
        $placeholderFile = $mailRender['placeholderfile'];
        $requestFile = null;

        if ($mailRender['requesttype'] == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $coreData = (array)json_decode($_POST['jsondata']);
            $requestFile = file_get_contents($coreData['url'], 'rb');
        }

        if ($mailRender['requesttype'] == 'URL') {
            $requestFile = file_get_contents($mailRender['requesturl'], 'rb');
        }

        if ($mailRender['requesttype'] == 'GET') {
            $url = Request::Get('requesturl', null);
            if($url == null) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $requestFile = file_get_contents($url, 'rb');
        }

        $x = $mailRender['x'];
        $y = $mailRender['y'];
        $w = $mailRender['w'];
        $h = $mailRender['h'];

        $placeHolder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestFile);

        $sx = imagesx($sample);
        $sy = imagesy($sample);

        $sampleCrop = imagecreatetruecolor($w, $h);

        imagecopyresized($sampleCrop, $sample, 0, 0, 0, 0, $w, $h, $sx, $sy);
        imagecopyresized($placeHolder, $sampleCrop, $x, $y, 0, 0, $w, $h, $w, $h);

        Request::OutputBufferStart();
        imagepng($placeHolder);
        $image = Request::OutputBufferClean();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;
        exit();
    }

    /**
     * @param $api_key
     * @param $imageId
     *
     * @throws Exception
     *
     * #Auth false
     * #Template html false
     */
    public function CodeRender($api_key, $imageId)
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) throw new Exception("Session Expired");

        $mailRender = ImageModel::GetImageRender($api_key, $imageId)[0];

        $imageName = $mailRender['imagename'];
        $placeholderFile = $mailRender['placeholderfile'];
        $requestSampleFile = $mailRender['requestsamplefile'];

        $x = $mailRender['x'];
        $y = $mailRender['y'];
        $w = $mailRender['w'];
        $h = $mailRender['h'];

        $placeHolder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestSampleFile);

        $sx = imagesx($sample);
        $sy = imagesy($sample);

        $sampleCrop = imagecreatetruecolor($w, $h);

        imagecopyresized($sampleCrop, $sample, 0, 0, 0, 0, $w, $h, $sx, $sy);
        imagecopyresized($placeHolder, $sampleCrop, $x, $y, 0, 0, $w, $h, $w, $h);

        Request::OutputBufferStart();
        imagepng($placeHolder);
        $image = Request::OutputBufferClean();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;
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

    public function OnInitialize()
    {
        // TODO: Implement OnInitialize() method.
    }
}