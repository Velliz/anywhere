<?php

namespace plugins\auth;

use model\UserModel;
use pukoframework\auth\Auth;
use pukoframework\auth\PukoAuth;

class AnywhereAuthenticator implements Auth
{

    /**
     * @var AnywhereAuthenticator
     */
    static $authenticator;

    public static function Instance()
    {
        if (!self::$authenticator instanceof AnywhereAuthenticator) {
            self::$authenticator = new AnywhereAuthenticator();
        }
        return self::$authenticator;
    }

    public function Login($username, $password)
    {
        $loginResult = UserModel::GetUser($username, $password);
        $uid = (isset($loginResult[0]['ID'])) ? $loginResult[0]['ID'] : null;

        return new PukoAuth($uid, array());
    }

    public function Logout()
    {
        session_destroy();
    }

    public function GetLoginData($id, $permission)
    {
        return UserModel::GetUserById($id)[0];
    }
}