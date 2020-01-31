<?php

namespace controller;

use model\ConstantaModel;
use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;
use pukoframework\Framework;

/**
 * #Master master.html
 * #Value PageTitle Constant Editor
 */
class constant extends AnywhereView
{

    /**
     * @throws \Exception
     */
    public function manage()
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (!isset($session['ID'])) {
            $this->RedirectTo(Framework::$factory->getBase());
        }

        $data['constanta'] = ConstantaModel::GetCollection($session['ID']);
        $data['total'] = sizeof($data['constanta']);

        return $data;
    }

}