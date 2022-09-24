<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class status extends Service
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
        if ($param['status'] === '') {
            throw new Exception($this->say('STATUS_REQUIRED'));
        }
        if ($param['description'] === '') {
            throw new Exception($this->say('DESCRIPTION_REQUIRED'));
        }
        if ($param['limitations'] === '') {
            throw new Exception($this->say('LIMITATIONS_REQUIRED'));
        }


        //validations: customize here

        //insert
        $status = new \plugins\model\primary\status();
        $status->id = $param['id'];
        $status->status = $param['status'];
        $status->description = $param['description'];
        $status->limitations = $param['limitations'];


        $status->save();

        //response
        $data['status'] = [
            'id' => $status->id,
        'status' => $status->status,
        'description' => $status->description,
        'limitations' => $status->limitations,

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
        if ($param['status'] === '') {
            throw new Exception($this->say('STATUS_REQUIRED'));
        }
        if ($param['description'] === '') {
            throw new Exception($this->say('DESCRIPTION_REQUIRED'));
        }
        if ($param['limitations'] === '') {
            throw new Exception($this->say('LIMITATIONS_REQUIRED'));
        }


        //validations: customize here

        //update
        $status = new \plugins\model\primary\status($id);
        $status->id = $param['id'];
        $status->status = $param['status'];
        $status->description = $param['description'];
        $status->limitations = $param['limitations'];


        $status->modify();

        //response
        $data['status'] = [
            'id' => $status->id,
        'status' => $status->status,
        'description' => $status->description,
        'limitations' => $status->limitations,

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
        $status = new \plugins\model\primary\status($id);

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

        return \model\primary\statusContracts::SearchDataPagination($keyword);
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

        $data['status'] = \model\primary\statusContracts::SearchData($keyword);
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

        return \model\primary\statusContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $status = new \plugins\model\primary\status($id);

        //response
        $data['status'] = [
            'id' => $status->id,
        'status' => $status->status,
        'description' => $status->description,
        'limitations' => $status->limitations,

        ];

        return $data;
    }

}
