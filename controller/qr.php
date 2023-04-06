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

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use PHPQRCode\QRcode;
use pukoframework\Framework;
use pukoframework\middleware\View;

/**
 * Class qr
 * @package controller
 * #Master master.html
 * #Value PageTitle QR Code
 */
class qr extends View
{

    /**
     * @throws Exception
     */
    public function main()
    {
    }

    public function render()
    {
        if (!isset($_GET['data'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'get data [data] is not defined.';
            die(json_encode($data));
        }

        $size = 300;
        if (isset($_GET['size'])) {
            $size = $_GET['size'];
        }

        //generate with new QR lib if with labels
        if (isset($_GET['label'])) {
            $label = $_GET['label'];
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($_GET['data'])
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size($size)
                ->margin(5)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->labelText($label)
                ->logoPath(Framework::$factory->getRoot() . '/logo100.png')
                ->labelFont(new NotoSans(14))
                ->foregroundColor(new Color(0, 102, 204))
                ->labelAlignment(new LabelAlignmentCenter())
                ->validateResult(false)
                ->build();

            header('Content-Type: ' . $result->getMimeType());
            echo $result->getString();
            die();
        } else {
            $output = 'png';
            $margin = 2;

            header('Content-Type: image/' . $output);
            QRcode::png($_GET['data'], false, 'L', $size, $margin);
        }

        die($this->say('QR_FAILED'));
    }
}
