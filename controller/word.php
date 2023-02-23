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

use Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use pukoframework\middleware\View;

/**
 * Class word
 * @package controller
 * #Auth session true
 * #Master master.html
 * #Value PageTitle Word Template
 */
class word extends View
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
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     * #Auth session true
     * #Master master-codes.html
     */
    public function update($id)
    {
    }

    /**
     * @param $api_key
     * @param $excelId
     * @throws Exception
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
