<?php
namespace controller;

use model\DBAnywhere;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;

class users extends View implements Auth
{

    public function beranda()
    {
        $vars = Session::Get($this)->GetLoginData();
        $vars['PDFLists'] = DBAnywhere::GetPdfLists($vars['ID']);
        return $vars;
    }

    public function limitations()
    {
    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = DBAnywhere::GetUser($username, md5($password));
        return $loginResult[0]['ID'];
    }

    public function Logout()
    {
    }

    public function GetLoginData($id)
    {
        return DBAnywhere::GetUserById($id)[0];
    }
    #end region auth
}