<?php

namespace plugins;

use Exception;
use plugins\auth\AnywhereAuthenticator;
use pukoframework\auth\Bearer;
use pukoframework\Request;

/**
 * Trait UserData
 * @package plugins
 */
trait UserBearerData
{

    /**
     * @var array
     */
    public $user = [
        'id' => 0,
        'status_id' => 0,
        'name' => '',
        'username' => '',
        'email' => '',
        'api_key' => '',
    ];

    /**
     * @var array
     */
    public $permissions = [];

    /**
     * UserBearerData constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (Request::getBearerToken() !== null) {
            $bearer = Bearer::Get(AnywhereAuthenticator::Instance())->GetLoginData();

            $this->user = $bearer['user'];
            $this->permissions = $bearer['permissions'];
        }
    }

}
