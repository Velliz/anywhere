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

use model\primary\imagesContracts;
use Exception;
use model\primary\log_imagesContracts;
use plugins\model\primary\log_images;
use pukoframework\middleware\View;
use pukoframework\Request;

/**
 * Class images
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 * #Value PageTitle Image Template
 */
class images extends View
{

    /**
     * @param $id_image
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function update($id_image)
    {
        $data['id_image'] = $id_image;
        $data['api_key'] = imagesContracts::GetApiKeyById($id_image);

        return $data;
    }

    /**
     * @param $api_key
     * @param $imageId
     * @throws Exception
     * #Template html false
     */
    public function render($api_key, $imageId)
    {
        $imageRender = imagesContracts::GetImageRender($api_key, $imageId);

        $imageName = $imageRender['image_name'];
        $placeholderFile = $imageRender['placeholder_file'];
        $requestFile = null;

        if ($imageRender['request_type'] == 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $coreData = (array)json_decode($_POST['jsondata']);
            $requestFile = file_get_contents($coreData['url'], 'rb');
        }

        if ($imageRender['request_type'] == 'URL') {
            $requestFile = file_get_contents($imageRender['request_url'], 'rb');
        }

        if ($imageRender['request_type'] == 'GET') {
            $url = Request::Get('request_url', null);
            if ($url == null) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                die(json_encode($data));
            }
            $requestFile = file_get_contents($url, 'rb');
        }

        $x = $imageRender['x'];
        $y = $imageRender['y'];
        $w = $imageRender['w'];
        $h = $imageRender['h'];

        $placeHolder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestFile);

        $sx = imagesx($sample);
        $sy = imagesy($sample);

        $sampleCrop = imagecreatetruecolor($w, $h);
        imagealphablending($sampleCrop, false);
        imagesavealpha($sampleCrop, true);

        imagecopyresized($sampleCrop, $sample, 0, 0, 0, 0, $w, $h, $sx, $sy);
        imagecopyresized($placeHolder, $sampleCrop, $x, $y, 0, 0, $w, $h, $w, $h);

        Request::OutputBufferStart();
        imagepng($placeHolder);
        $image = Request::OutputBufferClean();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        //save logs
        $log_excel = new log_images();
        $log_excel->created = $this->GetServerDateTime();
        $log_excel->cuid = $imageRender['user_id'];

        $log_excel->images_id = $imageId;
        $log_excel->user_id = $imageRender['user_id'];
        $log_excel->sent_at = $this->GetServerDateTime();
        $log_excel->result_data = $image;
        $log_excel->processing_time = 0.0;
        $log_excel->save();

        echo $image;

        exit();
    }

    /**
     * @param $api_key
     * @param $imageId
     * @throws Exception
     * #Template html false
     */
    public function coderender($api_key, $imageId)
    {
        $imageRender = imagesContracts::GetImageRender($api_key, $imageId);

        $imageName = $imageRender['image_name'];
        $placeholderFile = $imageRender['placeholder_file'];
        $requestSampleFile = $imageRender['request_sample_file'];

        $x = $imageRender['x'];
        $y = $imageRender['y'];
        $w = $imageRender['w'];
        $h = $imageRender['h'];

        $placeHolder = imagecreatefromstring($placeholderFile);
        $sample = imagecreatefromstring($requestSampleFile);

        $sx = imagesx($sample);
        $sy = imagesy($sample);

        $sampleCrop = imagecreatetruecolor($w, $h);
        imagealphablending($sampleCrop, false);
        imagesavealpha($sampleCrop, true);

        imagecopyresized($sampleCrop, $sample, 0, 0, 0, 0, $w, $h, $sx, $sy);
        imagecopyresized($placeHolder, $sampleCrop, $x, $y, 0, 0, $w, $h, $w, $h);

        Request::OutputBufferStart();
        imagepng($placeHolder);
        $image = Request::OutputBufferClean();
        imagedestroy($placeHolder);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageName . '.png"');

        echo $image;

        exit();
    }

    /**
     * @param $id_image
     * @return array
     * #Master master-codes.html
     */
    public function timeline($id_image = '')
    {
        $data['id_image'] = $id_image;
        $data['api_key'] = imagesContracts::GetApiKeyById($id_image);

        return $data;
    }

    /**
     * @param $logID
     * @param $api_key
     * @param $imagesId
     * @return void
     */
    public function timelinerender($logID, $api_key, $imageId)
    {
        $imageRender = imagesContracts::GetImageRender($api_key, $imageId);
        $logData = log_imagesContracts::GetById($logID);

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="' . $imageRender['image_name'] . '.png"');

        echo $logData['result_data'];

        exit();
    }

}
