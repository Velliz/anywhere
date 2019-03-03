<?php
/**
 * Anywhere
 *
 * Anywhere is output-as-a-service (OAAS) platform.
 *
 * This content is released under the Apache License Version 2.0, January 2004
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright (c) 2016, Didit Velliz
 *
 * @package	velliz/anywhere
 * @author	Didit Velliz
 * @link	https://github.com/velliz/anywhere
 * @since	Version 1.0.0
 *
 */
namespace controller;

use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;

/**
 * Class guide
 * @package controller
 *
 * #Master master.html
 */
class guide extends AnywhereView
{

    /**
     * #Value PageTitle Manual
     * @throws \Exception
     */
    public function main()
    {
        if (Session::Is()) {
            $data['IsSessionBlock'] = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        } else {
            $data['IsLoginBlock'] = array(
                'login' => false
            );
        }
        return $data;
    }

    /**
     * #Value PageTitle Puko Template Engine
     */
    public function pte()
    {
    }
}