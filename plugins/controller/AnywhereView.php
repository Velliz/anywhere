<?php

namespace plugins\controller;

use Exception;
use model\primary\constantaContracts;
use model\primary\digital_signsContracts;
use model\primary\usersContracts;
use plugins\model\primary\digital_signs;
use pukoframework\Framework;
use pukoframework\middleware\View;

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
    }

    /**
     * @throws Exception
     */
    public function BeforeInitialize()
    {
        $this->vars = constantaContracts::SearchData();
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
                if ($val['unique_key'] === $data) {
                    return $val['constanta_val'];
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

            $digital_sign = (array)json_decode($_POST['digitalsign'], true);
            //scan data as identifier
            if (!isset($digital_sign[$data])) {
                return '';
            }
            $digital_sign = $digital_sign[$data];

            $user = usersContracts::SearchData([
                'api_key' => $digital_sign['apikey'],
            ]);
            if (sizeof($user) === 0) {
                return '';
            }
            $signs = digital_signsContracts::SearchData([
                'ds.email' => $digital_sign['email']
            ]);
            if (sizeof($signs) === 0) {
                return '';
            }
            foreach ($signs as $sign) {
                $stamps = new digital_signs();
                $stamps->created = $this->GetServerDateTime();
                $stamps->cuid = $user[0]['id'];
                $stamps->user_id = $user[0]['id'];

                $stamps->digital_sign_secure = $this->GetRandomToken(4) . "=";
                $stamps->digital_sign_hash = md5($stamps->created . $stamps->digital_sign_secure);
                $stamps->email = $sign['email'];

                $stamps->document_name = $digital_sign['docName'];
                $stamps->location = $digital_sign['location'];
                $stamps->reason = $digital_sign['reason'];

                if ((int)$sign['is_verified'] === 1) {
                    $stamps->save();
                }

                return $sign['callback_url'] . $stamps->digital_sign_hash;
            }
        }

        return '';
    }

}
