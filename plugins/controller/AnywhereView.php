<?php

namespace plugins\controller;

use Exception;
use model\ConstantaModel;
use model\DigitalSignUserModel;
use plugins\auth\AnywhereAuthenticator;
use plugins\model\digitalsigns;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\middleware\View;
use pukoframework\Request;

/**
 * #Master master.html
 * #Value title Hello World
 */
class AnywhereView extends View
{

    public $vars = [];

    /**
     * AnywhereView constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        //because session class don't trigger this instance
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

            //pre-fill the data with logged in account
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
                    if ($val['uniquekey'] === $data) {
                        return $val['constantaval'];
                    }
                }
            }
        }
        if ($this->fn === 'sign') {
            if ($data !== null) {
                $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();

                $signs = DigitalSignUserModel::SearchData([
                    'email' => $data
                ]);
                if (sizeof($signs) === 0) {
                    return '';
                }
                foreach ($signs as $sign) {
                    $stamps = new digitalsigns();
                    $stamps->created = $this->GetServerDateTime();
                    $stamps->cuid = $session['ID'];
                    $stamps->userid = $session['ID'];

                    $stamps->digitalsignsecure = $this->GetRandomToken(4) . "=";
                    $stamps->digitalsignhash = md5($stamps->created . $stamps->digitalsignsecure);
                    $stamps->email = $sign['email'];

                    $documentname = Request::Header('X-DocName', null);
                    if ($documentname !== null) {
                        $stamps->documentname = $documentname;
                    }
                    $location = Request::Header('X-Loc', null);
                    if ($location !== null) {
                        $stamps->location = $location;
                    }
                    $reason = Request::Header('X-Reason', null);
                    if ($reason !== null) {
                        $stamps->reason = $reason;
                    }

                    if ((int)$sign['isverified'] === 1) {
                        $stamps->save();
                    }

                    return $sign['callbackurl'] . $stamps->digitalsignhash;
                }
            }
        }
        return '';

    }


}
