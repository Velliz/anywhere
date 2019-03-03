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

use model\ExcelModel;
use plugins\auth\AnywhereAuthenticator;
use model\ImageModel;
use model\MailModel;
use model\PdfModel;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;

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
     */
    public function beranda()
    {
        $vars = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        $vars['PDFLists'] = PdfModel::GetPdfLists($vars['ID']);
        $vars['MAILLists'] = MailModel::GetMailLists($vars['ID']);
        $vars['IMAGELists'] = ImageModel::GetImageLists($vars['ID']);
        $vars['EXCELLists'] = ExcelModel::GetExcelLists($vars['ID']);
        return $vars;
    }

    /**
     * @return bool
     * #Auth session true
     * @throws \Exception
     */
    public function profil()
    {
        $vars = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        return $vars;
    }

    public function limitations()
    {
    }
}