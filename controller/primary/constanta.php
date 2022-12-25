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
class constanta extends Service
{

    use UserBearerData;

    /**
     * @throws Exception
     * @auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['unique_key'] === '') {
            throw new Exception($this->say('UNIQUE_KEY_REQUIRED'));
        }
        if ($param['constanta_val'] === '') {
            throw new Exception($this->say('CONSTANTA_VAL_REQUIRED'));
        }

        //validations: customize here

        //insert
        $constanta = new \plugins\model\primary\constanta();
        $constanta->created = $this->GetServerDateTime();
        $constanta->cuid = $this->user['id'];

        $constanta->user_id = $this->user['id'];
        $constanta->unique_key = trim($param['unique_key']);
        $constanta->constanta_val = trim($param['constanta_val']);

        $constanta->save();

        //response
        $data['constanta'] = [
            'id' => $constanta->id,
            'user' => usersContracts::GetById($constanta->user_id),
            'unique_key' => $constanta->unique_key,
            'constanta_val' => $constanta->constanta_val,
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
        if ($param['unique_key'] === '') {
            throw new Exception($this->say('UNIQUE_KEY_REQUIRED'));
        }
        if ($param['constanta_val'] === '') {
            throw new Exception($this->say('CONSTANTA_VAL_REQUIRED'));
        }

        //validations: customize here

        //update
        $constanta = new \plugins\model\primary\constanta($id);
        $constanta->modified = $this->GetServerDateTime();
        $constanta->muid = $this->user['id'];

        $constanta->unique_key = trim($param['unique_key']);
        $constanta->constanta_val = trim($param['constanta_val']);

        $constanta->modify();

        //response
        $data['constanta'] = [
            'id' => $constanta->id,
            'user_id' => $constanta->user_id,
            'unique_key' => $constanta->unique_key,
            'constanta_val' => $constanta->constanta_val,

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
        $constanta = new \plugins\model\primary\constanta($id);

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

        return \model\primary\constantaContracts::SearchDataPagination($keyword);
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

        $data['constanta'] = \model\primary\constantaContracts::SearchData($keyword);
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

        return \model\primary\constantaContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $constanta = new \plugins\model\primary\constanta($id);

        //response
        $data['constanta'] = [
            'id' => $constanta->id,
            'user_id' => $constanta->user_id,
            'unique_key' => $constanta->unique_key,
            'constanta_val' => $constanta->constanta_val,

        ];

        return $data;
    }

}
