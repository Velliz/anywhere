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
namespace controller\api;

use Dompdf\Exception;
use model\ImageModel;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class api
 * @package controller
 */
class image extends Service
{

    #region image service
    /**
     * @return mixed
     * @throws Exception
     */
    public function placeholder()
    {
        $id = Request::Post('id', null);
        if ($id == null) throw new Exception('id not defined.');

        $type = Request::Post('type', null);
        if ($type == null) throw new Exception('type not defined.');
        if (!$_FILES) throw new Exception('attachment file not defined.');

        if ($type == 'placeholder') {

            $name = $_FILES['placeholderfile']['name'];
            $tmp_name = file_get_contents($_FILES['placeholderfile']['tmp_name']);

            $input = array(
                'placeholdername' => $name,
                'placeholderfile' => $tmp_name
            );

            $id = ImageModel::UpdateImagePage(array('IMAGEID' => $id), $input);
            $data['Image'] = ImageModel::GetImageAttribute($id);

            return $data;
        } elseif ($type == 'sample') {

            $name = $_FILES['samplefile']['name'];
            $tmp_name = file_get_contents($_FILES['samplefile']['tmp_name']);

            $input = array(
                'IMAGEID' => $id,
                'requestsamplename' => $name,
                'requestsamplefile' => $tmp_name
            );

            $id = ImageModel::UpdateImagePage(array('IMAGEID' => $id), $input);
            $data['Image'] = ImageModel::GetImageAttribute($id);

            return $data;
        } else {
            throw new Exception('upload type not defined.');
        }
    }

    public function getplaceholder($id, $type)
    {
        $avatar = ImageModel::GetImagePage($id)[0];
        header('Content-Type: image/jpeg');
        if ($type == 'placeholder') echo $avatar['placeholderfile'];
        if ($type == 'sample') echo $avatar['requestsamplefile'];
        die();
    }
    #end region image service

}