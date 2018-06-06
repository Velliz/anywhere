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

use controller\auth\Authenticator;
use pukoframework\auth\Session;
use pukoframework\middleware\View;
use pukoframework\Request;
use QRcode;

/**
 * Class qr
 * @package controller
 *
 * #Master master-qr.html
 */
class qr extends View
{

    /**
     * @return bool
     *
     * #Auth true
     */
    public function main()
    {
        $session = Session::Get(Authenticator::Instance())->GetLoginData();
        $dataQR = $session;

        return $dataQR;
    }

    /**
     * #Auth false
     */
    public function render()
    {
        if (!isset($_GET['data'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'get data [data] is not defined.';
            die(json_encode($data));
        }

        $size = 10;
        $margin = 2;
        $output = 'png';

        if (isset($_GET['size'])) $size = $_GET['size'];
        if (isset($_GET['margin'])) $size = $_GET['margin'];
        if (isset($_GET['output'])) $output = $_GET['output'];

        include(ROOT . '/libraries/phpqrcode/qrlib.php');

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");

        if ($output === 'png') {
            header('Content-Type: image/' . $output);
            QRcode::png($_GET['data'], false, QR_ECLEVEL_L, $size, $margin);
        }
        if ($output === 'svg') {
            header('Content-Type: image/' . $output);
            QRcode::svg($_GET['data'], false, QR_ECLEVEL_L, $size, $margin);
        }
        if ($output === 'jpg' || $output === 'jpeg') {
            header('Content-Type: image/' . $output);
            Request::OutputBufferStart();
            QRcode::png($_GET['data'], false, QR_ECLEVEL_L, $size, $margin);
            $ImagePng = Request::OutputBufferFlush();

            $ImageObject = imagecreatefromstring($ImagePng);

            Request::OutputBufferStart();
            imagejpeg($ImageObject, "qr" . $output, 75);
            $ImageResult = Request::OutputBufferFlush();
            imagedestroy($ImageObject);

            echo $ImageResult;
        }

        die();
    }
}