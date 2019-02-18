<?php

namespace plugins\controller;

use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Hello World
 */
class AnywhereView extends View
{

    /**
     * AnywhereView constructor.
     */
    public function __construct()
    {
        parent::__construct();
        //todo: di tulis sementara disini karena dari Session class tidak ada instance-nya
        session_start();
    }

}