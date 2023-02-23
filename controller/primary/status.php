<?php

namespace controller\primary;

use DateTime;
use Exception;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class status extends Service
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
        $status->created = $this->GetServerDateTime();
        $status->cuid = $this->user['id'];

        $status->status = trim($param['status']);
        $status->description = trim($param['description']);
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
        $status->modified = $this->GetServerDateTime();
        $status->muid = $this->user['id'];

        $status->status = trim($param['status']);
        $status->description = trim($param['description']);
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
        $status->modified = $this->GetServerDateTime();
        $status->muid = $this->user['id'];

        //delete logic here
        $status->dflag = 1;
        $status->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $keyword['user_id'] = $this->user['id'];

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
