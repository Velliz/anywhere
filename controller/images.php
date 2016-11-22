<?php

namespace controller;

use pukoframework\auth\Auth;
use pukoframework\pte\View;

/**
 * Class images
 * @package controller
 *
 * #ClearOutput true
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