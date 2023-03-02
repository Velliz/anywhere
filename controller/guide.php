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

use Exception;
use Parsedown;
use pukoframework\Framework;
use pukoframework\middleware\View;

/**
 * Class guide
 * @package controller
 *
 * #Master master.html
 * #Value PageTitle Guide
 */
class guide extends View
{

    /**
     * #Value PageTitle Manual
     * @throws Exception
     */
    public function main()
    {
        $pdf = sprintf("%s/assets/tutorial/pdf.md", Framework::$factory->getRoot());
        if (!file_exists($pdf)) {
            die("pdf.md file not found!");
        }
        $file_pdf = file_get_contents($pdf);
        $data['pdf'] = Parsedown::instance()->text($file_pdf);

        $image = sprintf("%s/assets/tutorial/image.md", Framework::$factory->getRoot());
        if (!file_exists($image)) {
            die("image.md file not found!");
        }
        $file_image = file_get_contents($image);
        $data['image'] = Parsedown::instance()->text($file_image);

        $mail = sprintf("%s/assets/tutorial/mail.md", Framework::$factory->getRoot());
        if (!file_exists($mail)) {
            die("mail.md file not found!");
        }
        $file_mail = file_get_contents($mail);
        $data['mail'] = Parsedown::instance()->text($file_mail);

        $excel = sprintf("%s/assets/tutorial/excel.md", Framework::$factory->getRoot());
        if (!file_exists($excel)) {
            die("excel.md file not found!");
        }
        $file_excel = file_get_contents($excel);
        $data['excel'] = Parsedown::instance()->text($file_excel);

        $self_sign = sprintf("%s/assets/tutorial/self-sign.md", Framework::$factory->getRoot());
        if (!file_exists($self_sign)) {
            die("self-sign.md file not found!");
        }
        $file_self_sign = file_get_contents($self_sign);
        $data['self-sign'] = Parsedown::instance()->text($file_self_sign);

        return $data;
    }

    /**
     * #Value PageTitle Puko Template Engine
     */
    public function pte()
    {
    }
}
