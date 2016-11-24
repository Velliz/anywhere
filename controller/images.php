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

    private $html;
    private $css;

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

            $resultUpdate = ImageModel::UpdateImagePage(
                array('IMAGEID' => $imageid),
                array(
                    'imagename' => $imageName,
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
     * @param $mailId
     *
     * @throws Exception
     * @throws \Exception
     *
     * #Template html false
     */
    public function CodeRender($api_key, $mailId)
    {
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