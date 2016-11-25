<?php
namespace controller;

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
 * #Auth true
 */
class images extends View implements Auth
{

    /**
     * images constructor.
     *
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
                ));

            if ($resultUpdate) $this->RedirectTo(BASE_URL . 'beranda');
            $this->RedirectTo(BASE_URL . 'sorry');
        }
        $dataIMAGE = $session;
        $dataIMAGE['image'] = ImageModel::GetImagePage($id);

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
     * @param $mailId
     * @throws Exception
     * @throws \Exception
     *
     * #Template html false
     */
    public function Render($api_key, $mailId)
    {
    }

    /**
     * @param $api_key
     * @param $imageId
     *
     * @throws Exception
     * @throws \Exception
     *
     * #Template html false
     */
    public function CodeRender($api_key, $imageId)
    {
        $session = Session::Get($this)->GetLoginData();
        if (!isset($session['ID'])) throw new Exception("Session Expired");

        $mailRender = ImageModel::GetImageRender($api_key, $imageId)[0];

        $imageName = $mailRender['imagename'];

        $placeholderName = $mailRender['placeholdername'];
        $placeholderFile = $mailRender['placeholderfile'];

        $requestsampleName = $mailRender['requestsamplename'];
        $requestsampleFile = $mailRender['requestsamplefile'];

        $x = $mailRender['x'];
        $y = $mailRender['y'];

        $x2 = $mailRender['x2'];
        $y2 = $mailRender['y2'];

        $w = $mailRender['w'];
        $h = $mailRender['h'];

        $palceholder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestsampleFile);

        $px = imagesx($palceholder);
        $py = imagesy($palceholder);

        $sx = imagesx($sample);
        $sy = imagesy($sample);

        //$sampleResized = imagecreatetruecolor($x2, $y2);
        //imagecopyresized($sampleResized, $sample, 0, 0, 0, 0, $x2, $y2, $sx, $sy);

        // $dst_image, $placeholder
        // $src_image, $sample

        // $dst_x, x-coordinate of destination point.
        // $dst_y, y-coordinate of destination point.

        // $src_x, x-coordinate of source point.
        // $src_y, y-coordinate of source point.

        // $dst_w, Destination width.
        // $dst_h, Destination height.

        // $src_w, Source width.
        // $src_h, Source height.

        //imagecopyresized($placeholder, $qr, 0, $start, 0, 0, $pWidth, $pWidth, $sx, $sy);
        
        imagecopyresized(
            $palceholder,
            $sample,
            $x, //x-coordinate of destination point.
            $y, //y-coordinate of destination point.
            0, //x-coordinate of source point.
            0, //y-coordinate of source point.
            $x2, //Destination width.
            $y2, //Destination height.
            $x2, //Source width.
            $y2 //Source height.
        );

        Request::OutputBufferStart();
        imagepng($palceholder);
        $image = Request::OutputBufferFinish();
        imagedestroy($palceholder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;
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