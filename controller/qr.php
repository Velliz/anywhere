<?php

namespace controller;

use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use QRcode;

class qr extends View implements Auth
{

    public function main()
    {
        $session = Session::Get($this)->GetLoginData();
        $dataQR = $session;

        return $dataQR;
    }

    public function render()
    {
        if(!isset($_GET['data'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'get data [data] is not defined.';
            die(json_encode($data));
        }

        $size = 10;
        $margin = 2;

        if(isset($_GET['size'])) $size = $_GET['size'];
        if(isset($_GET['margin'])) $size = $_GET['margin'];

        include(ROOT . '/libraries/phpqrcode/qrlib.php');

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');

        QRcode::png($_GET['data'], false, QR_ECLEVEL_L, $size, $margin);
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