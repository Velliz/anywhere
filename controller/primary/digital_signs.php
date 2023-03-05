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
class digital_signs extends Service
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
        if ($param['document_name'] === '') {
            throw new Exception($this->say('DOCUMENT_NAME_REQUIRED'));
        }
        if ($param['digital_sign_hash'] === '') {
            throw new Exception($this->say('DIGITAL_SIGN_HASH_REQUIRED'));
        }
        if ($param['digital_sign_secure'] === '') {
            throw new Exception($this->say('DIGITAL_SIGN_SECURE_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }
        if ($param['location'] === '') {
            throw new Exception($this->say('LOCATION_REQUIRED'));
        }
        if ($param['reason'] === '') {
            throw new Exception($this->say('REASON_REQUIRED'));
        }

        //validations: customize here

        //insert
        $digital_signs = new \plugins\model\primary\digital_signs();
        $digital_signs->created = $this->GetServerDateTime();
        $digital_signs->cuid = $this->user['id'];

        $digital_signs->user_id = $this->user['id'];

        $digital_signs->document_name = trim($param['document_name']);
        $digital_signs->digital_sign_hash = trim($param['digital_sign_hash']);
        $digital_signs->digital_sign_secure = trim($param['digital_sign_secure']);
        $digital_signs->email = trim($param['email']);
        $digital_signs->location = trim($param['location']);
        $digital_signs->reason = trim($param['reason']);

        $digital_signs->save();

        //response
        $data['digital_signs'] = [
            'id' => $digital_signs->id,
            'user' => usersContracts::GetById($digital_signs->user_id),
            'document_name' => $digital_signs->document_name,
            'digital_sign_hash' => $digital_signs->digital_sign_hash,
            'digital_sign_secure' => $digital_signs->digital_sign_secure,
            'email' => $digital_signs->email,
            'location' => $digital_signs->location,
            'reason' => $digital_signs->reason,
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
        if ($param['document_name'] === '') {
            throw new Exception($this->say('DOCUMENT_NAME_REQUIRED'));
        }
        if ($param['digital_sign_hash'] === '') {
            throw new Exception($this->say('DIGITAL_SIGN_HASH_REQUIRED'));
        }
        if ($param['digital_sign_secure'] === '') {
            throw new Exception($this->say('DIGITAL_SIGN_SECURE_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }
        if ($param['location'] === '') {
            throw new Exception($this->say('LOCATION_REQUIRED'));
        }
        if ($param['reason'] === '') {
            throw new Exception($this->say('REASON_REQUIRED'));
        }

        //validations: customize here

        //update
        $digital_signs = new \plugins\model\primary\digital_signs($id);
        $digital_signs->modified = $this->GetServerDateTime();
        $digital_signs->muid = $this->user['id'];

        $digital_signs->user_id = $this->user['id'];

        $digital_signs->document_name = trim($param['document_name']);
        $digital_signs->digital_sign_hash = trim($param['digital_sign_hash']);
        $digital_signs->digital_sign_secure = trim($param['digital_sign_secure']);
        $digital_signs->email = trim($param['email']);
        $digital_signs->location = trim($param['location']);
        $digital_signs->reason = trim($param['reason']);

        $digital_signs->modify();

        //response
        $data['digital_signs'] = [
            'id' => $digital_signs->id,
            'user' => usersContracts::GetById($digital_signs->user_id),
            'document_name' => $digital_signs->document_name,
            'digital_sign_hash' => $digital_signs->digital_sign_hash,
            'digital_sign_secure' => $digital_signs->digital_sign_secure,
            'email' => $digital_signs->email,
            'location' => $digital_signs->location,
            'reason' => $digital_signs->reason,
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
        $digital_signs = new \plugins\model\primary\digital_signs($id);
        $digital_signs->modified = $this->GetServerDateTime();
        $digital_signs->muid = $this->user['id'];

        //delete logic here
        $digital_signs->dflag = 1;
        $digital_signs->modify();

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
            $keyword['ds.user_id'] = $param['user_id'];
        }

        return \model\primary\digital_signsContracts::SearchDataPagination($keyword);
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
            $keyword['ds.user_id'] = $param['user_id'];
        }

        $data['digital_signs'] = \model\primary\digital_signsContracts::SearchData($keyword);
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
        $keyword['ds.user_id'] = $this->user['id'];

        $email = Request::Post('email', '');
        if ($email !== '') {
            $keyword['ds.email'] = $email;
        }

        return \model\primary\digital_signsContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $digital_signs = new \plugins\model\primary\digital_signs($id);

        //response
        $data['digital_signs'] = [
            'id' => $digital_signs->id,
            'user' => usersContracts::GetById($digital_signs->user_id),
            'document_name' => $digital_signs->document_name,
            'digital_sign_hash' => $digital_signs->digital_sign_hash,
            'digital_sign_secure' => $digital_signs->digital_sign_secure,
            'email' => $digital_signs->email,
            'location' => $digital_signs->location,
            'reason' => $digital_signs->reason,
        ];

        return $data;
    }

}
