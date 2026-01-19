<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class log_images extends Service
{

    /**
     * @throws Exception
     * #Auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['images_id'] === '') {
            throw new Exception($this->say('IMAGES_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //insert
        $log_images = new \plugins\model\primary\log_images();
        $log_images->id = $param['id'];
        $log_images->images_id = $param['images_id'];
        $log_images->user_id = $param['user_id'];
        $log_images->processing_time = $param['processing_time'];


        $log_images->save();

        //response
        $data['log_images'] = [
            'id' => $log_images->id,
        'images_id' => $log_images->images_id,
        'user_id' => $log_images->user_id,
        'processing_time' => $log_images->processing_time,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * #Auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['images_id'] === '') {
            throw new Exception($this->say('IMAGES_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //update
        $log_images = new \plugins\model\primary\log_images($id);
        $log_images->id = $param['id'];
        $log_images->images_id = $param['images_id'];
        $log_images->user_id = $param['user_id'];
        $log_images->processing_time = $param['processing_time'];


        $log_images->modify();

        //response
        $data['log_images'] = [
            'id' => $log_images->id,
        'images_id' => $log_images->images_id,
        'user_id' => $log_images->user_id,
        'processing_time' => $log_images->processing_time,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @throws Exception
     * #Auth bearer true
     */
    public function delete($id = '')
    {
        $log_images = new \plugins\model\primary\log_images($id);

        //delete logic here

        return [
            'deleted' => true
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function explore()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here

        return \model\primary\log_imagesContracts::SearchDataPagination($keyword);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function search()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here

        $data['log_images'] = \model\primary\log_imagesContracts::SearchData($keyword);
        return $data;
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function table()
    {
        $keyword = [];

        //post addition filter here

        return \model\primary\log_imagesContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $log_images = new \plugins\model\primary\log_images($id);

        //response
        $data['log_images'] = [
            'id' => $log_images->id,
        'images_id' => $log_images->images_id,
        'user_id' => $log_images->user_id,
        'processing_time' => $log_images->processing_time,

        ];

        return $data;
    }

}
