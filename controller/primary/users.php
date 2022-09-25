<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\statusContracts;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class users extends Service
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
        if ($param['name'] === '') {
            throw new Exception($this->say('NAME_REQUIRED'));
        }
        if ($param['username'] === '') {
            throw new Exception($this->say('USERNAME_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }
        if ($param['api_key'] === '') {
            throw new Exception($this->say('API_KEY_REQUIRED'));
        }

        //validations: customize here
        $param['name'] = trim($param['name']);
        $param['username'] = trim($param['username']);
        $param['email'] = trim($param['email']);

        //insert
        $users = new \plugins\model\primary\users();
        $users->created = $this->GetServerDateTime();
        $users->cuid = $this->user['id'];

        $users->name = $param['name'];
        $users->username = $param['username'];
        $users->email = $param['email'];

        $users->api_key = md5($users->username . $users->email);
        $users->status_id = 0;

        $users->save();

        //response
        $data['users'] = [
            'id' => $users->id,
            'status' => statusContracts::GetById($users->status_id),
            'name' => $users->name,
            'username' => $users->username,
            'email' => $users->email,
            'api_key' => $users->api_key,
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
        if ($param['status_id'] === '') {
            throw new Exception($this->say('STATUS_ID_REQUIRED'));
        }
        if ($param['name'] === '') {
            throw new Exception($this->say('NAME_REQUIRED'));
        }
        if ($param['username'] === '') {
            throw new Exception($this->say('USERNAME_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }
        if ($param['api_key'] === '') {
            throw new Exception($this->say('API_KEY_REQUIRED'));
        }


        //validations: customize here

        //update
        $users = new \plugins\model\primary\users($id);
        $users->id = $param['id'];
        $users->status_id = $param['status_id'];
        $users->name = $param['name'];
        $users->username = $param['username'];
        $users->email = $param['email'];
        $users->api_key = $param['api_key'];


        $users->modify();

        //response
        $data['users'] = [
            'id' => $users->id,
            'status_id' => $users->status_id,
            'name' => $users->name,
            'username' => $users->username,
            'email' => $users->email,
            'api_key' => $users->api_key,

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
        $users = new \plugins\model\primary\users($id);

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

        return \model\primary\usersContracts::SearchDataPagination($keyword);
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

        $data['users'] = \model\primary\usersContracts::SearchData($keyword);
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

        return \model\primary\usersContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $users = new \plugins\model\primary\users($id);

        //response
        $data['users'] = [
            'id' => $users->id,
            'status_id' => $users->status_id,
            'name' => $users->name,
            'username' => $users->username,
            'email' => $users->email,
            'api_key' => $users->api_key,

        ];

        return $data;
    }

}
