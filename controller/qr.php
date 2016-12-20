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

use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;
use QRcode;

class qr extends View implements Auth
{

    /**
     * @return bool
     *
     * #Auth true
     */
    public function main()
    {
        $session = Session::Get($this)->GetLoginData();
        $dataQR = $session;

        return $dataQR;
    }

    /**
     * #Auth false
     */
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