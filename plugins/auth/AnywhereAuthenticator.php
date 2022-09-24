<?php

namespace plugins\auth;

use Exception;
use model\primary\usersContracts;
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

    /**
     * @param $username
     * @param $password
     * @return PukoAuth
     * @throws Exception
     */
    public function Login($username, $password)
    {
        $res = usersContracts::GetUser($username, $password);
        $uid = (isset($res['id'])) ? $res['id'] : null;

        return new PukoAuth($uid, array());
    }

    public function Logout()
    {
    }

    /**
     * @param $data
     * @param $permission
     * @return array|mixed|null
     * @throws Exception
     */
    public function GetLoginData($data, $permission)
    {
        $u = usersContracts::GetById($data);

        return [
            'user' => $u,
            'permissions' => $permission,
        ];
    }
}
