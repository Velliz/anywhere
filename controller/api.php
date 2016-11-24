<?php

namespace controller;

use Dompdf\Exception;
use model\ImageModel;
use pukoframework\pte\Service;
use pukoframework\Request;

class api extends Service
{

    #region image service
    public function placeholder()
    {
        $id = Request::Post('id', null);
        if ($id == null) throw new Exception('id not defined.');

        $type = Request::Post('type', null);
        if ($type == null) throw new Exception('type not defined.');

        if (!$_FILES) throw new Exception('attachment file not defined.');

        /*
        $name = $_FILES['placeholderfile']['name'];
        $type = $_FILES['attachment']['type'];
        $error = $_FILES['attachment']['error'];
        $size = $_FILES['attachment']['size'];
        */

        if ($type == 'placeholder') {

            $name = $_FILES['placeholderfile']['name'];
            $tmp_name = $_FILES['placeholderfile']['tmp_name'];

            $input = array(
                'placeholdername' => $name,
                'placeholderfile' => $tmp_name
            );

            $id = ImageModel::UpdateImagePage(array('IMAGEID' => $id), $input);
            $data['Image'] = ImageModel::GetImageAttribute($id);

            return $data;
        } elseif ($type == 'sample') {

            $name = $_FILES['samplefile']['name'];
            $tmp_name = $_FILES['samplefile']['tmp_name'];

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