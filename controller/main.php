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
 * @package    velliz/anywhere
 * @author    Didit Velliz
 * @link    https://github.com/velliz/anywhere
 * @since    Version 1.0.0
 *
 */
namespace controller;

use Exception;
use pukoframework\middleware\View;

/**
 * Class main
 * @package controller
 * #Master master.html
 * #Value PageTitle Welcome
 */
class main extends View
{

    /**
     * #Template master true
     * #Value PageTitle Welcome
     * @throws Exception
     */
    public function main()
    {
    }

    /**
     * #Template master true
     * #Value PageTitle Register
     * @throws Exception
     */
    public function register()
    {
    }

    /**
     * #Template master true
     * #Value PageTitle Login
     * #ClearOutput value true
     * @throws Exception
     */
    public function userlogin()
    {
    }

    /**
     * #Template html false
     * @throws Exception
     */
    public function userlogout()
    {
    }

    public function about()
    {
    }

    public function sorry()
    {
    }
}
