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
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
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
            if ((int)$result['result'] >= $session['limitations']) {
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

    /**
     * @param $api_key
     * @param $excelId
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function render($api_key, $excelId)
    {
        $wordRender = WordModel::GetWordRender($api_key, $excelId)[0];

        $this->wordname = $wordRender['wordname'];
        $this->columnspecs = json_decode($wordRender['columnspecs'], true);
        $this->dataspecs = json_decode($wordRender['dataspecs'], true);
        $this->requesttype = $wordRender['requesttype'];

        $phpWord = new PhpWord();

        //todo: generate word files

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($this->wordname . '.docx');
    }

    public function coderender($api_key, $excelId)
    {
        $wordRender = WordModel::GetWordRender($api_key, $excelId)[0];

        $this->wordname = $wordRender['wordname'];
        $this->columnspecs = json_decode($wordRender['columnspecs'], true);
        $this->dataspecs = json_decode($wordRender['dataspecs'], true);
        $this->requesttype = $wordRender['requesttype'];

        $phpWord = new PhpWord();

        //todo: generate test word files

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($this->wordname . '.docx');
    }

}