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

namespace controller\api;

use Exception;
use model\primary\imagesContracts;
use plugins\model\primary\images;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * Class api
 * @package controller
 */
class image extends Service
{

    use UserBearerData;

    /**
     * @return array
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

            $images = new images($id);
            $images->modified = $this->GetServerDateTime();
            $images->cuid = $this->user['id'];

            $images->placeholder_name = $name;
            $images->placeholder_file = $tmp_name;

            $images->modify();

            $data['Image'] = imagesContracts::GetById($id);

            return $data;
        } elseif ($type == 'sample') {

            $name = $_FILES['samplefile']['name'];
            $tmp_name = file_get_contents($_FILES['samplefile']['tmp_name']);

            $images = new images($id);
            $images->modified = $this->GetServerDateTime();
            $images->cuid = $this->user['id'];

            $images->request_sample_name = $name;
            $images->request_sample_file = $tmp_name;

            $images->modify();

            $data['Image'] = imagesContracts::GetById($id);

            return $data;
        } else {
            throw new Exception('upload type not defined.');
        }
    }

    /**
     * @param $id
     * @param $type
     * @return void
     * @throws Exception
     */
    public function getplaceholder($id, $type)
    {
        $avatar = imagesContracts::GetById($id);

        header('Content-Type: image/jpeg');

        if ($type == 'placeholder') {
            echo $avatar['placeholder_file'];
        }
        if ($type == 'sample') {
            echo $avatar['request_sample_file'];
        }

        die();
    }

}
