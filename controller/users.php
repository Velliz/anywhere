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
use model\ConstantaModel;
use model\ExcelModel;
use plugins\auth\AnywhereAuthenticator;
use model\ImageModel;
use model\MailModel;
use model\PdfModel;
use plugins\controller\AnywhereView;
use plugins\model\constanta;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\Request;

/**
 * Class users
 * @package controller
 * #Master master.html
 */
class users extends AnywhereView
{

    /**
     * @return bool
     * #Auth session true
     * @throws \Exception
     * #Value PageTitle Beranda
     */
    public function beranda()
    {
        $vars = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (!isset($vars['ID'])) {
            $this->RedirectTo(Framework::$factory->getBase());
        }

        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case 'POST':
                $id = Request::Post('constID', '');
                $key = Request::Post('key', '');

                $val = Request::Post('val', '');
                if ($val === '') {
                    throw new Exception('val required!');
                }
                $action = Request::Post('action', '');

                if ($action === 'Save') {
                    if ($key === '') {
                        throw new Exception('key required!');
                    }

                    $exists = ConstantaModel::IsKeyExists($vars['ID'], $key);
                    if ($exists) {
                        throw new Exception("Global variable dengan nama {$key} sudah diinput sebelumnya.");
                    }
                    $constanta = new constanta();
                    $constanta->userID = $vars['ID'];
                    $constanta->uniquekey = $key;
                    $constanta->constantaval = $val;
                    $constanta->save();
                }
                if ($action === 'Update') {
                    if ($id === '') {
                        throw new Exception('id required!');
                    }

                    $constanta = new constanta($id);
                    $constanta->userID = $vars['ID'];
                    $constanta->uniquekey = $key;
                    $constanta->constantaval = $val;
                    $constanta->modify();
                }
                /*
                if ($action === 'Delete') {

                }
                */

                break;
            case 'GET':

                break;
            default:
                break;
        }

        $vars['CONSTLists'] = ConstantaModel::GetCollection($vars['ID']);
        $vars['PDFLists'] = PdfModel::GetPdfLists($vars['ID']);
        $vars['MAILLists'] = MailModel::GetMailLists($vars['ID']);
        $vars['IMAGELists'] = ImageModel::GetImageLists($vars['ID']);
        $vars['EXCELLists'] = ExcelModel::GetExcelLists($vars['ID']);

        $vars['LengthPDF'] = sizeof($vars['PDFLists']);
        $vars['LengthMAIL'] = sizeof($vars['MAILLists']);
        $vars['LengthIMAGE'] = sizeof($vars['IMAGELists']);
        $vars['LengthEXCEL'] = sizeof($vars['EXCELLists']);
        $vars['LengthCONST'] = sizeof($vars['CONSTLists']);

        $vars['tagvar'] = '{!var(KEY)}';

        return $vars;
    }

    /**
     * @return bool
     * #Auth session true
     * @throws \Exception
     * #Value PageTitle Profil
     */
    public function profil()
    {
        $vars = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        return $vars;
    }

    /**
     * #Value PageTitle Batas Template
     */
    public function limitations()
    {
    }
}