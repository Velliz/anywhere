<?php
namespace controller;

use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;

use model\UserModel;

class guide extends View implements Auth
{

    /**
     * #Value PageTitle Manual
     */
    public function main()
    {
        if (Session::IsSession()) {
            $session = Session::Get($this)->GetLoginData();
            $session['IsLoginBlock'] = true;
            $session['IsSessionBlock'] = false;
            return $session;
        }
        return array('IsLoginBlock' => false, 'IsSessionBlock' => true);
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