<?php

namespace plugins\controller;

use Exception;
use model\ConstantaModel;
use model\DigitalSignUserModel;
use model\UserModel;
use plugins\auth\AnywhereAuthenticator;
use plugins\model\digitalsigns;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\middleware\View;

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
            if (!isset($this->const[$this->param])) {
                return '';
            }
            return $this->const[$this->param];
        }
        if ($this->fn === 'var') {
            if ($data === null) {
                return '';
            }
            foreach ($this->vars as $key => $val) {
                if ($val['uniquekey'] === $data) {
                    return $val['constantaval'];
                }
            }
        }
        if ($this->fn === 'sign') {
            if (!isset($_POST['digitalsign'])) {
                return '';
            }
            if ($data === null) {
                return '';
            }

            $digitalsign = (array)json_decode($_POST['digitalsign'], true);
            //scan data as identifier
            if (!isset($digitalsign[$data])) {
                return '';
            }
            $digitalsign = $digitalsign[$data];

            $user = UserModel::UserIdByApiKey($digitalsign['apikey']);
            $signs = DigitalSignUserModel::SearchData([
                'email' => $digitalsign['email']
            ]);
            if (sizeof($signs) === 0) {
                return '';
            }
            foreach ($signs as $sign) {
                $stamps = new digitalsigns();
                $stamps->created = $this->GetServerDateTime();
                $stamps->cuid = $user;
                $stamps->userid = $user;

                $stamps->digitalsignsecure = $this->GetRandomToken(4) . "=";
                $stamps->digitalsignhash = md5($stamps->created . $stamps->digitalsignsecure);
                $stamps->email = $sign['email'];

                $stamps->documentname = $digitalsign['docName'];
                $stamps->location = $digitalsign['location'];
                $stamps->reason = $digitalsign['reason'];

                if ((int)$sign['isverified'] === 1) {
                    $stamps->save();
                }

                return $sign['callbackurl'] . $stamps->digitalsignhash;
            }
        }

        return '';
    }


}
