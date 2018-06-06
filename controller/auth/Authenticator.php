<?php
namespace controller\auth;

use model\UserModel;
use pukoframework\auth\Auth;

class Authenticator implements Auth
{

    /**
     * @var authenticator
     */
    static $authenticator;

    public static function Instance()
    {
        if (!self::$authenticator instanceof Authenticator) {
            self::$authenticator = new Authenticator();
        }
        return self::$authenticator;
    }

    public function Login($username, $password)
    {
        $loginResult = UserModel::GetUser($username, $password);
        return (isset($loginResult[0]['ID'])) ? $loginResult[0]['ID'] : false;
    }

    public function Logout()
    {
    }

    public function GetLoginData($id, $permission)
    {
        return UserModel::GetUserById($id)[0];
    }
}