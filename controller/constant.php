<?php

namespace controller;

use Exception;
use model\ConstantaModel;
use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use plugins\model\constanta;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\Request;

/**
 * #ClearOutput false
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

        $data = [];

        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case 'POST':

                $key = Request::Post('key', '');
                if ($key === '') {
                    throw new Exception('key required!');
                }
                $val = Request::Post('val', '');
                if ($val === '') {
                    throw new Exception('val required!');
                }
                $action = Request::Post('action', '');

                if ($action === 'Save') {

                    $exists = ConstantaModel::IsKeyExists($session['ID'], $key);
                    if ($exists) {
                        throw new Exception("Global variable dengan nama {$key} sudah diinput sebelumnya.");
                    }
                    $constanta = new constanta();
                    $constanta->userID = $session['ID'];
                    $constanta->keys = $key;
                    $constanta->values = $val;
                    $constanta->save();
                }
                if ($action === 'Update') {

                }
                if ($action === 'Delete') {

                }

                break;
            case 'GET':

                break;
            default:
                break;
        }

        $data['constanta'] = ConstantaModel::GetCollection($session['ID']);
        $data['total'] = sizeof($data['constanta']);

        return $data;
    }

}