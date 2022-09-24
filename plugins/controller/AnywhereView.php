<?php

namespace plugins\controller;

use Exception;
use model\primary\constantaContracts;
use plugins\auth\AnywhereAuthenticator;
use plugins\model\primary\digital_signs;
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
     * @return array
     * @throws Exception
     */
    public function BeforeInitialize()
    {
        if (Session::Is()) {
            $data['IsSessionBlock'] = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();

            //pre-fill the data with logged in account
            $this->vars = constantaContracts::SearchData([
                'user_id' => $data['IsSessionBlock']['id'],
            ]);
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
            foreach ($this->vars as $val) {
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

            $user = UserModel::UserIdByApiKey($digitalsign['api_key']);
            $signs = DigitalSignUserModel::SearchData([
                'email' => $digitalsign['email']
            ]);
            if (sizeof($signs) === 0) {
                return '';
            }
            foreach ($signs as $sign) {
                $stamps = new digital_signs();
                $stamps->created = $this->GetServerDateTime();
                $stamps->cuid = $user;
                $stamps->user_id = $user;

                $stamps->digital_sign_secure = $this->GetRandomToken(4) . "=";
                $stamps->digital_sign_hash = md5($stamps->created . $stamps->digital_sign_secure);
                $stamps->email = $sign['email'];

                $stamps->document_name = $digitalsign['doc_name'];
                $stamps->location = $digitalsign['location'];
                $stamps->reason = $digitalsign['reason'];

                if ((int)$sign['isverified'] === 1) {
                    $stamps->save();
                }

                return $sign['callbackurl'] . $stamps->digital_sign_hash;
            }
        }

        return '';
    }


}
