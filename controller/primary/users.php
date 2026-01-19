<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\statusContracts;
use model\primary\usersContracts;
use plugins\auth\AnywhereAuthenticator;
use plugins\UserBearerData;
use pukoframework\auth\Bearer;
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
     */
    public function create()
    {
        if ((int)$this->GetAppConstant('ALLOW_REGISTER') !== 1) {
            throw new Exception($this->say('REGISTRATION_MAINTENANCE'));
        }

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
        if ($param['password'] === '') {
            throw new Exception($this->say('PASSWORD_REQUIRED'));
        }

        //validations: customize here
        $param['name'] = trim($param['name']);
        $param['username'] = trim($param['username']);
        $param['email'] = trim($param['email']);

        //duplication check
        $username = usersContracts::GetDataSizeWhere([
            'username' => $param['username'],
        ]);
        if ($username > 0) {
            throw new Exception($this->say('USERNAME_EXIST', [$param['username']]));
        }
        $email = usersContracts::GetDataSizeWhere([
            'email' => $param['email'],
        ]);
        if ($email > 0) {
            throw new Exception($this->say('EMAIL_EXIST', [$param['username']]));
        }

        //insert
        $users = new \plugins\model\primary\users();
        $users->created = $this->GetServerDateTime();
        $users->cuid = $this->user['id'];

        $users->name = $param['name'];
        $users->username = $param['username'];
        $users->email = $param['email'];

        $users->api_key = md5($users->username . $users->email);
        $users->status_id = 1;

        $users->password = md5($param['password']);

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
     * #Auth bearer true
     */
    public function update($id = '')
    {
        if ($this->GetAppConstant('ALLOW_REGISTER') !== true) {
            throw new Exception($this->say('REGISTRATION_MAINTENANCE'));
        }

        $param = Request::JsonBody();

        //validations: empty check
        if ($param['name'] === '') {
            throw new Exception($this->say('NAME_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }

        //validations: customize here

        //update
        $users = new \plugins\model\primary\users($id);
        $users->modified = $this->GetServerDateTime();
        $users->muid = $this->user['id'];

        $users->name = trim($param['name']);
        $users->email = trim($param['email']);

        $users->modify();

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
     * @throws Exception
     * #Auth bearer true
     */
    public function delete($id = '')
    {
        if ($this->GetAppConstant('ALLOW_REGISTER') !== true) {
            throw new Exception($this->say('REGISTRATION_MAINTENANCE'));
        }

        $users = new \plugins\model\primary\users($id);
        $users->modified = $this->GetServerDateTime();
        $users->muid = $this->user['id'];

        //delete logic here
        $users->dflag = 1;
        $users->modify();

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
        if (isset($param['status_id'])) {
            $keyword['status_id'] = $param['status_id'];
        }

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
        if (isset($param['status_id'])) {
            $keyword['status_id'] = $param['status_id'];
        }

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
        $status_id = Request::Post('status_id', '');
        if ($status_id !== '') {
            $keyword['status_id'] = $status_id;
        }

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
            'status' => statusContracts::GetById($users->status_id),
            'name' => $users->name,
            'username' => $users->username,
            'email' => $users->email,
            'api_key' => $users->api_key,
        ];

        return $data;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function login()
    {
        $param = Request::JsonBody();
        if ($param['username'] === '') {
            throw new Exception($this->say('USERNAME_REQUIRED'));
        }
        if ($param['password'] === '') {
            throw new Exception($this->say('PASSWORD_REQUIRED'));
        }

        $login = Bearer::Get(AnywhereAuthenticator::Instance())->Login(
            $param['username'],
            md5($param['password'])
        );

        if (!$login) {
            return [
                'status' => 'error',
                'message' => $this->say('LOGIN_FAILED'),
                'data' => []
            ];
        }
        return [
            'status' => 'success',
            'message' => $this->say('LOGIN_SUCCESS'),
            'data' => [
                'bearer' => $login,
            ]
        ];
    }

    /**
     * @return array
     * @throws Exception
     * #Auth bearer true
     */
    public function data()
    {
        $data = Bearer::Get(AnywhereAuthenticator::Instance())->GetLoginData();

        return [
            'status' => 'success',
            'message' => 'Login valid',
            'data' => $data
        ];
    }

}
