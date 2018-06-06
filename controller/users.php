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
 * @package	velliz/anywhere
 * @author	Didit Velliz
 * @link	https://github.com/velliz/anywhere
 * @since	Version 1.0.0
 *
 */
namespace controller;

use controller\auth\Authenticator;
use model\ImageModel;
use model\MailModel;
use model\PdfModel;
use pukoframework\auth\Session;
use pukoframework\middleware\View;

/**
 * Class users
 * @package controller
 *
 * #Auth true +
 * #ClearOutput false
 * #Master master-user.html
 */
class users extends View
{
    public function beranda()
    {
        $vars = Session::Get(Authenticator::Instance())->GetLoginData();
        $vars['PDFLists'] = PdfModel::GetPdfLists($vars['ID']);
        $vars['MAILLists'] = MailModel::GetMailLists($vars['ID']);
        $vars['IMAGELists'] = ImageModel::GetImageLists($vars['ID']);
        return $vars;
    }
    
    public function profil()
    {
        $vars = Session::Get(Authenticator::Instance())->GetLoginData();
        return $vars;
    }

    public function limitations()
    {
    }
}