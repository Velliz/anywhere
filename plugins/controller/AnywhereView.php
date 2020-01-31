<?php

namespace plugins\controller;

use Exception;
use model\ConstantaModel;
use plugins\auth\AnywhereAuthenticator;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\middleware\View;

/**
 * #Master master.html
 * #Value title Hello World
 */
class AnywhereView extends View
{

    var $vars = [];

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
            $this->vars = ConstantaModel::GetCollection($data['IsSessionBlock']['ID']);
        } else {
            $data['IsLoginBlock'] = array(
                'login' => true
            );
        }
        return $data;
    }

    /**
     * @param null $data
     * @param string $template
     * @param bool $templateBinary
     * @return string|null
     * @throws Exception
     */
    public function Parse($data = null, $template = '', $templateBinary = false)
    {
        if ($this->fn === 'url') {
            return Framework::$factory->getBase() . $this->param;
        }
        if ($this->fn === 'const') {
            return $this->const[$this->param];
        }
        if ($this->fn === 'var') {
            if ($data !== null) {
                foreach ($this->vars as $key => $val) {
                    if ($val['keys'] === $data) {
                        return $val['values'];
                    }
                }
            }
        }
        return '';

    }


}