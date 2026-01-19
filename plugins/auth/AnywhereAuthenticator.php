<?php

namespace plugins\auth;

use Exception;
use model\primary\statusContracts;
use model\primary\usersContracts;
use pukoframework\auth\Auth;
use pukoframework\auth\PukoAuth;

class AnywhereAuthenticator implements Auth
{

    /**
     * @var AnywhereAuthenticator
     */
    static $authenticator;

    public static function Instance(): AnywhereAuthenticator
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
    public function Login($username, $password): PukoAuth
    {
        $res = usersContracts::GetUser($username, $password);
        $uid = (isset($res['id'])) ? $res['id'] : null;

        return new PukoAuth($uid, []);
    }

    public function Logout()
    {
    }

    /**
     * @param $data
     * @param $permission
     * @return array
     * @throws Exception
     */
    public function GetLoginData($data, $permission): array
    {
        $user = usersContracts::GetById($data);

        return [
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'email' => $user['email'],
                'api_key' => $user['api_key'],
                'status' => statusContracts::GetById($user['status_id']),
            ],
            'permissions' => $permission,
        ];
    }
}
