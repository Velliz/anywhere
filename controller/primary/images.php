<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class images extends Service
{

    /**
     * @throws Exception
     * @auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['image_name'] === '') {
            throw new Exception($this->say('IMAGE_NAME_REQUIRED'));
        }
        if ($param['placeholder_name'] === '') {
            throw new Exception($this->say('PLACEHOLDER_NAME_REQUIRED'));
        }
        if ($param['placeholder_file'] === '') {
            throw new Exception($this->say('PLACEHOLDER_FILE_REQUIRED'));
        }
        if ($param['x'] === '') {
            throw new Exception($this->say('X_REQUIRED'));
        }
        if ($param['y'] === '') {
            throw new Exception($this->say('Y_REQUIRED'));
        }
        if ($param['x2'] === '') {
            throw new Exception($this->say('X2_REQUIRED'));
        }
        if ($param['y2'] === '') {
            throw new Exception($this->say('Y2_REQUIRED'));
        }
        if ($param['w'] === '') {
            throw new Exception($this->say('W_REQUIRED'));
        }
        if ($param['h'] === '') {
            throw new Exception($this->say('H_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['request_sample_name'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_NAME_REQUIRED'));
        }
        if ($param['request_sample_file'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_FILE_REQUIRED'));
        }


        //validations: customize here

        //insert
        $images = new \plugins\model\primary\images();
        $images->id = $param['id'];
        $images->user_id = $param['user_id'];
        $images->image_name = $param['image_name'];
        $images->placeholder_name = $param['placeholder_name'];
        $images->placeholder_file = $param['placeholder_file'];
        $images->x = $param['x'];
        $images->y = $param['y'];
        $images->x2 = $param['x2'];
        $images->y2 = $param['y2'];
        $images->w = $param['w'];
        $images->h = $param['h'];
        $images->request_type = $param['request_type'];
        $images->request_url = $param['request_url'];
        $images->request_sample = $param['request_sample'];
        $images->request_sample_name = $param['request_sample_name'];
        $images->request_sample_file = $param['request_sample_file'];


        $images->save();

        //response
        $data['images'] = [
            'id' => $images->id,
        'user_id' => $images->user_id,
        'image_name' => $images->image_name,
        'placeholder_name' => $images->placeholder_name,
        'placeholder_file' => $images->placeholder_file,
        'x' => $images->x,
        'y' => $images->y,
        'x2' => $images->x2,
        'y2' => $images->y2,
        'w' => $images->w,
        'h' => $images->h,
        'request_type' => $images->request_type,
        'request_url' => $images->request_url,
        'request_sample' => $images->request_sample,
        'request_sample_name' => $images->request_sample_name,
        'request_sample_file' => $images->request_sample_file,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * @auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['image_name'] === '') {
            throw new Exception($this->say('IMAGE_NAME_REQUIRED'));
        }
        if ($param['placeholder_name'] === '') {
            throw new Exception($this->say('PLACEHOLDER_NAME_REQUIRED'));
        }
        if ($param['placeholder_file'] === '') {
            throw new Exception($this->say('PLACEHOLDER_FILE_REQUIRED'));
        }
        if ($param['x'] === '') {
            throw new Exception($this->say('X_REQUIRED'));
        }
        if ($param['y'] === '') {
            throw new Exception($this->say('Y_REQUIRED'));
        }
        if ($param['x2'] === '') {
            throw new Exception($this->say('X2_REQUIRED'));
        }
        if ($param['y2'] === '') {
            throw new Exception($this->say('Y2_REQUIRED'));
        }
        if ($param['w'] === '') {
            throw new Exception($this->say('W_REQUIRED'));
        }
        if ($param['h'] === '') {
            throw new Exception($this->say('H_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['request_sample_name'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_NAME_REQUIRED'));
        }
        if ($param['request_sample_file'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_FILE_REQUIRED'));
        }


        //validations: customize here

        //update
        $images = new \plugins\model\primary\images($id);
        $images->id = $param['id'];
        $images->user_id = $param['user_id'];
        $images->image_name = $param['image_name'];
        $images->placeholder_name = $param['placeholder_name'];
        $images->placeholder_file = $param['placeholder_file'];
        $images->x = $param['x'];
        $images->y = $param['y'];
        $images->x2 = $param['x2'];
        $images->y2 = $param['y2'];
        $images->w = $param['w'];
        $images->h = $param['h'];
        $images->request_type = $param['request_type'];
        $images->request_url = $param['request_url'];
        $images->request_sample = $param['request_sample'];
        $images->request_sample_name = $param['request_sample_name'];
        $images->request_sample_file = $param['request_sample_file'];


        $images->modify();

        //response
        $data['images'] = [
            'id' => $images->id,
        'user_id' => $images->user_id,
        'image_name' => $images->image_name,
        'placeholder_name' => $images->placeholder_name,
        'placeholder_file' => $images->placeholder_file,
        'x' => $images->x,
        'y' => $images->y,
        'x2' => $images->x2,
        'y2' => $images->y2,
        'w' => $images->w,
        'h' => $images->h,
        'request_type' => $images->request_type,
        'request_url' => $images->request_url,
        'request_sample' => $images->request_sample,
        'request_sample_name' => $images->request_sample_name,
        'request_sample_file' => $images->request_sample_file,

        ];

        return $data;
    }

    /**
     * @param string $id
     * @throws Exception
     * @auth bearer true
     */
    public function delete($id = '')
    {
        $images = new \plugins\model\primary\images($id);

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

        return \model\primary\imagesContracts::SearchDataPagination($keyword);
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

        $data['images'] = \model\primary\imagesContracts::SearchData($keyword);
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

        return \model\primary\imagesContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $images = new \plugins\model\primary\images($id);

        //response
        $data['images'] = [
            'id' => $images->id,
        'user_id' => $images->user_id,
        'image_name' => $images->image_name,
        'placeholder_name' => $images->placeholder_name,
        'placeholder_file' => $images->placeholder_file,
        'x' => $images->x,
        'y' => $images->y,
        'x2' => $images->x2,
        'y2' => $images->y2,
        'w' => $images->w,
        'h' => $images->h,
        'request_type' => $images->request_type,
        'request_url' => $images->request_url,
        'request_sample' => $images->request_sample,
        'request_sample_name' => $images->request_sample_name,
        'request_sample_file' => $images->request_sample_file,

        ];

        return $data;
    }

}
