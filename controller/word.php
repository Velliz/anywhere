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

use model\WordModel;
use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\Request;

/**
 * Class word
 * @package controller
 * #Auth session true
 * #Master master.html
 * #Value PageTitle Word Template
 */
class word extends AnywhereView
{

    /**
     * @var string
     */
    var $wordname = "";

    /**
     * @var array
     */
    var $columnspecs = array();

    /**
     * @var array
     */
    var $dataspecs = array();

    /**
     * @var string
     */
    var $requesttype = 'POST';

    /**
     * @throws \Exception
     */
    public function main()
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (!isset($session['ID'])) {
            $this->RedirectTo(Framework::$factory->getBase());
        }

        if ((int)$session['statusID'] == 1) {
            $result = WordModel::CountWordUser($session['ID'])[0];
            if ((int)$result['result'] >= $this->GetAppConstant('LIMITATIONS')) {
                $this->RedirectTo('limitations');
            }
        }

        $snap_shoot = date('d-m-Y-His');

        $arrayData = array(
            'userID' => $session['ID'],
            'wordname' => 'WORD-' . $snap_shoot . '.docx',
            'requesttype' => 'POST',
            'columnspecs' => json_encode(array(), JSON_PRETTY_PRINT),
            'dataspecs' => json_encode(array(), JSON_PRETTY_PRINT),
        );

        $wordID = WordModel::NewWordPage($arrayData);
        $dataWORD = WordModel::GetWordPage($wordID)[0];

        $this->RedirectTo('update/' . $dataWORD['WORDID']);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     * #Auth session true
     * #Master master-codes.html
     */
    public function update($id)
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (isset($_POST['wordid'])) {
            $arrayID = array('WORDID' => Request::Post('wordid', 0));
            $arrayData = array(
                'WORDID' => Request::Post('wordid', 0),
                'excelname' => Request::Post('wordname', ''),
                'columnspecs' => Request::Post('columnspecs', ''),
                'dataspecs' => Request::Post('dataspecs', ''),
                'requesttype' => Request::Post('requesttype', ''),
            );
            $resultUpdate = WordModel::UpdateWordPage($arrayID, $arrayData);
            if ($resultUpdate) {
                $this->RedirectTo(Framework::$factory->getBase() . 'beranda');
            }
            $this->RedirectTo(Framework::$factory->getBase() . 'sorry');
        }
        $dataWORD = $session;

        $dataWORD['word'] = WordModel::GetWordAttribute($id);
        foreach ($dataWORD['word'] as $key => $value) {
            $dataWORD['excel'][$key]['apikey'] = $session['apikey'];
            switch ($value['requesttype']) {
                case 'POST':
                    $dataWORD['word'][$key]['POST'] = 'checked';
                    break;
                case 'URL':
                    $dataWORD['word'][$key]['URL'] = 'checked';
                    break;
            }
        }

        return $dataWORD;
    }

    public function render($api_key, $excelId)
    {

    }

    public function coderender($api_key, $excelId)
    {

    }

}