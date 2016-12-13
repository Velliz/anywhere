<?php
namespace controller;

use model\DBAnywhere;
use model\ImageModel;
use model\MailModel;
use model\PdfModel;
use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\Session;
use pukoframework\pte\View;

/**
 * Class users
 * @package controller
 *
 * #Auth true
 * #ClearOutput false
 */
class users extends View implements Auth
{

    public function beranda()
    {
        $vars = Session::Get($this)->GetLoginData();
        $vars['PDFLists'] = PdfModel::GetPdfLists($vars['ID']);
        $vars['MAILLists'] = MailModel::GetMailLists($vars['ID']);
        $vars['IMAGELists'] = ImageModel::GetImageLists($vars['ID']);
        return $vars;
    }
    
    public function profil()
    {
        $vars = Session::Get($this)->GetLoginData();
        return $vars;
    }

    public function limitations()
    {
    }

    #region auth
    public function Login($username, $password)
    {
        $loginResult = UserModel::GetUser($username, md5($password));
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