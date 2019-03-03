<?php

namespace plugins\controller;

use plugins\auth\AnywhereAuthenticator;
use pukoframework\auth\Session;
use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Hello World
 */
class AnywhereView extends View
{

    /**
     * AnywhereView constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        //todo: di tulis sementara disini karena dari Session class tidak ada instance-nya
        session_start();
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function BeforeInitialize()
    {
        if (Session::Is()) {
            $data['IsSessionBlock'] = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        } else {
            $data['IsLoginBlock'] = array(
                'login' => true
            );
        }
        return $data;
    }


}