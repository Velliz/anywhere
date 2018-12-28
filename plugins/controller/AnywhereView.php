<?php

namespace plugins\controller;

use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Hello World
 */
class AnywhereView extends View
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

}