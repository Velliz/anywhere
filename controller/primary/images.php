<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\usersContracts;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class images extends Service
{

    use UserBearerData;

    /**
     * @throws Exception
     * #Auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['image_name'] === '') {
            throw new Exception($this->say('IMAGE_NAME_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }

        //validations: customize here

        //insert
        $images = new \plugins\model\primary\images();
        $images->created = $this->GetServerDateTime();
        $images->cuid = $this->user['id'];

        $images->user_id = $this->user['id'];

        $images->image_name = trim($param['image_name']);
        $images->request_type = trim($param['request_type']);
        $images->request_url = trim($param['request_url']);

        if (isset($param['request_sample'])) {
            $images->request_sample = trim($param['request_sample']);
        }

        if (isset($param['x'])) {
            $images->x = trim($param['x']);
        }
        if (isset($param['y'])) {
            $images->y = trim($param['y']);
        }
        if (isset($param['x2'])) {
            $images->x2 = trim($param['x2']);
        }
        if (isset($param['y2'])) {
            $images->y2 = trim($param['y2']);
        }
        if (isset($param['w'])) {
            $images->w = trim($param['w']);
        }
        if (isset($param['h'])) {
            $images->h = trim($param['h']);
        }

        $images->save();

        //response
        $data['images'] = [
            'id' => $images->id,
            'user' => usersContracts::GetById($images->user_id),
            'image_name' => $images->image_name,
            'placeholder_name' => $images->placeholder_name,
            'request_type' => $images->request_type,
            'request_url' => $images->request_url,
            'request_sample' => $images->request_sample,
            'request_sample_name' => $images->request_sample_name,
            'x' => $images->x,
            'y' => $images->y,
            'x2' => $images->x2,
            'y2' => $images->y2,
            'w' => $images->w,
            'h' => $images->h,
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
        if ($param['image_name'] === '') {
            throw new Exception($this->say('IMAGE_NAME_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }

        //validations: customize here

        //update
        $images = new \plugins\model\primary\images($id);
        $images->modified = $this->GetServerDateTime();
        $images->muid = $this->user['id'];

        $images->user_id = $this->user['id'];

        $images->image_name = trim($param['image_name']);
        $images->request_type = trim($param['request_type']);
        $images->request_url = trim($param['request_url']);

        if (isset($param['request_sample'])) {
            $images->request_sample = trim($param['request_sample']);
        }

        if (isset($param['x'])) {
            $images->x = trim($param['x']);
        }
        if (isset($param['y'])) {
            $images->y = trim($param['y']);
        }
        if (isset($param['x2'])) {
            $images->x2 = trim($param['x2']);
        }
        if (isset($param['y2'])) {
            $images->y2 = trim($param['y2']);
        }
        if (isset($param['w'])) {
            $images->w = trim($param['w']);
        }
        if (isset($param['h'])) {
            $images->h = trim($param['h']);
        }

        $images->modify();

        //response
        $data['images'] = [
            'id' => $images->id,
            'user' => usersContracts::GetById($images->user_id),
            'image_name' => $images->image_name,
            'placeholder_name' => $images->placeholder_name,
            'request_type' => $images->request_type,
            'request_url' => $images->request_url,
            'request_sample' => $images->request_sample,
            'request_sample_name' => $images->request_sample_name,
            'x' => $images->x,
            'y' => $images->y,
            'x2' => $images->x2,
            'y2' => $images->y2,
            'w' => $images->w,
            'h' => $images->h,
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
        $images = new \plugins\model\primary\images($id);
        $images->modified = $this->GetServerDateTime();
        $images->muid = $this->user['id'];

        //delete logic here
        $images->dflag = 1;
        $images->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $keyword['user_id'] = $this->user['id'];

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
            'user' => usersContracts::GetById($images->user_id),
            'image_name' => $images->image_name,
            'placeholder_name' => $images->placeholder_name,
            'request_type' => $images->request_type,
            'request_url' => $images->request_url,
            'request_sample' => $images->request_sample,
            'request_sample_name' => $images->request_sample_name,
            'x' => $images->x,
            'y' => $images->y,
            'x2' => $images->x2,
            'y2' => $images->y2,
            'w' => $images->w,
            'h' => $images->h,
        ];

        return $data;
    }

}
