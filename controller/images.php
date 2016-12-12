<?php
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
 */
class images extends View implements Auth
{

    /**
     * images constructor.
     */
    public function __construct()
    {

    }

    /**
     * #Template html false
     * #Auth true
     * #ClearOutput false
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

    public function Html($id_mail)
    {
    }

    public function Style($id_mail)
    {
    }

    /**
     * @param $api_key
     * @param $imageId
     * @throws Exception
     *
     * #Template html false
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
        $image = Request::OutputBufferFinish();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;
        die();
    }

    /**
     * @param $api_key
     * @param $imageId
     *
     * @throws Exception
     *
     * #Template html false
     */
    public function CodeRender($api_key, $imageId)
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) throw new Exception("Session Expired");

        $mailRender = ImageModel::GetImageRender($api_key, $imageId)[0];

        $imageName = $mailRender['imagename'];
        //$placeholderName = $mailRender['placeholdername'];
        $placeholderFile = $mailRender['placeholderfile'];
        //$requestSampleName = $mailRender['requestsamplename'];
        $requestSampleFile = $mailRender['requestsamplefile'];

        $x = $mailRender['x'];
        $y = $mailRender['y'];
        //$x2 = $mailRender['x2'];
        //$y2 = $mailRender['y2'];
        $w = $mailRender['w'];
        $h = $mailRender['h'];

        $placeHolder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestSampleFile);

        //$px = imagesx($placeHolder);
        //$py = imagesy($placeHolder);
        $sx = imagesx($sample);
        $sy = imagesy($sample);

        $sampleCrop = imagecreatetruecolor($w, $h);

        imagecopyresized($sampleCrop, $sample, 0, 0, 0, 0, $w, $h, $sx, $sy);
        imagecopyresized($placeHolder, $sampleCrop, $x, $y, 0, 0, $w, $h, $w, $h);

        Request::OutputBufferStart();
        imagepng($placeHolder);
        $image = Request::OutputBufferFinish();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;
        die();
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