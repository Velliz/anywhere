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

use controller\auth\Authenticator;
use pukoframework\auth\Session;
use pukoframework\middleware\View;

/**
 * Class guide
 * @package controller
 *
 * #Master master-guide.html
 */
class guide extends View
{

    /**
     * #Value PageTitle Manual
     */
    public function main()
    {
        if (Session::Is()) {
            $session = Session::Get(Authenticator::Instance())->GetLoginData();
            $session['IsLoginBlock'] = true;
            $session['IsSessionBlock'] = false;
            return $session;
        }
        return array('IsLoginBlock' => false, 'IsSessionBlock' => true);
    }

    /**
     * #Value PageTitle Puko Template Engine
     */
    public function pte()
    {
    }
}