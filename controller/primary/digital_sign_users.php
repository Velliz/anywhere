<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\usersContracts;
use plugins\UserBearerData;
use pukoframework\Framework;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class digital_sign_users extends Service
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
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }

        //insert
        $digital_sign_users = new \plugins\model\primary\digital_sign_users();
        $digital_sign_users->created = $this->GetServerDateTime();
        $digital_sign_users->cuid = $this->user['id'];

        $digital_sign_users->user_id = $this->user['id'];

        $digital_sign_users->name = trim($param['name']);
        $digital_sign_users->email = trim($param['email']);
        $digital_sign_users->type = 'INDIVIDUAL';

        $digital_sign_users->ktp = '0000000000000000';
        $digital_sign_users->npwp = '0000000000';

        $digital_sign_users->address = '-';
        $digital_sign_users->city = '-';
        $digital_sign_users->province = '-';

        $digital_sign_users->gender = 'M';

        $digital_sign_users->place_of_birth = '-';
        $digital_sign_users->date_of_birth = '0000-00-00';

        $digital_sign_users->org_unit = '-';
        $digital_sign_users->work_unit = '-';
        $digital_sign_users->position = '-';

        $digital_sign_users->is_verified = 0;

        $digital_sign_users->callback_url = Framework::$factory->getBase() . "digitalsigns/verify/";

        $digital_sign_users->save();

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
            'user' => usersContracts::GetById($digital_sign_users->user_id),
            'name' => $digital_sign_users->name,
            'phone' => $digital_sign_users->phone,
            'email' => $digital_sign_users->email,
            'type' => $digital_sign_users->type,
            'ktp' => $digital_sign_users->ktp,
            'npwp' => $digital_sign_users->npwp,
            'address' => $digital_sign_users->address,
            'city' => $digital_sign_users->city,
            'province' => $digital_sign_users->province,
            'gender' => $digital_sign_users->gender,
            'place_of_birth' => $digital_sign_users->place_of_birth,
            'date_of_birth' => $digital_sign_users->date_of_birth,
            'org_unit' => $digital_sign_users->org_unit,
            'work_unit' => $digital_sign_users->work_unit,
            'position' => $digital_sign_users->position,
            'is_verified' => $digital_sign_users->is_verified,
            'callback_url' => $digital_sign_users->callback_url,
            'is_speciment' => $digital_sign_users->is_speciment,
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
        if ($param['name'] === '') {
            throw new Exception($this->say('NAME_REQUIRED'));
        }
        if ($param['phone'] === '') {
            throw new Exception($this->say('PHONE_REQUIRED'));
        }
        if ($param['email'] === '') {
            throw new Exception($this->say('EMAIL_REQUIRED'));
        }
        if ($param['type'] === '') {
            throw new Exception($this->say('TYPE_REQUIRED'));
        }
        if ($param['ktp'] === '') {
            throw new Exception($this->say('KTP_REQUIRED'));
        }
        if ($param['npwp'] === '') {
            throw new Exception($this->say('NPWP_REQUIRED'));
        }
        if ($param['address'] === '') {
            throw new Exception($this->say('ADDRESS_REQUIRED'));
        }
        if ($param['city'] === '') {
            throw new Exception($this->say('CITY_REQUIRED'));
        }
        if ($param['province'] === '') {
            throw new Exception($this->say('PROVINCE_REQUIRED'));
        }
        if ($param['gender'] === '') {
            throw new Exception($this->say('GENDER_REQUIRED'));
        }
        if ($param['place_of_birth'] === '') {
            throw new Exception($this->say('PLACE_OF_BIRTH_REQUIRED'));
        }
        if ($param['date_of_birth'] === '') {
            throw new Exception($this->say('DATE_OF_BIRTH_REQUIRED'));
        }
        if ($param['org_unit'] === '') {
            throw new Exception($this->say('ORG_UNIT_REQUIRED'));
        }
        if ($param['work_unit'] === '') {
            throw new Exception($this->say('WORK_UNIT_REQUIRED'));
        }
        if ($param['position'] === '') {
            throw new Exception($this->say('POSITION_REQUIRED'));
        }

        //validations: customize here
        $date_of_birth = DateTime::createFromFormat('d/m/Y', $param['date_of_birth']);
        if (!$date_of_birth instanceof DateTime) {
            throw new Exception($this->say('DATE_OF_BIRTH_INVALID'));
        }

        //update
        $digital_sign_users = new \plugins\model\primary\digital_sign_users($id);
        $digital_sign_users->modified = $this->GetServerDateTime();
        $digital_sign_users->muid = $this->user['id'];

        $digital_sign_users->user_id = $this->user['id'];

        $digital_sign_users->name = trim($param['name']);
        $digital_sign_users->phone = trim($param['phone']);
        $digital_sign_users->email = trim($param['email']);
        $digital_sign_users->type = trim($param['type']);

        $digital_sign_users->ktp = trim($param['ktp']);
        $digital_sign_users->npwp = trim($param['npwp']);

        $digital_sign_users->address = trim($param['address']);
        $digital_sign_users->city = trim($param['city']);
        $digital_sign_users->province = trim($param['province']);

        $digital_sign_users->gender = trim($param['gender']);

        $digital_sign_users->place_of_birth = trim($param['place_of_birth']);
        $digital_sign_users->date_of_birth = $date_of_birth->format('Y-m-d');

        $digital_sign_users->org_unit = trim($param['org_unit']);
        $digital_sign_users->work_unit = trim($param['work_unit']);
        $digital_sign_users->position = trim($param['position']);

        $digital_sign_users->is_verified = 1;

        $digital_sign_users->callback_url = Framework::$factory->getBase() . "digitalsigns/verify/";

        $digital_sign_users->modify();

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
            'user' => usersContracts::GetById($digital_sign_users->user_id),
            'name' => $digital_sign_users->name,
            'phone' => $digital_sign_users->phone,
            'email' => $digital_sign_users->email,
            'type' => $digital_sign_users->type,
            'ktp' => $digital_sign_users->ktp,
            'npwp' => $digital_sign_users->npwp,
            'address' => $digital_sign_users->address,
            'city' => $digital_sign_users->city,
            'province' => $digital_sign_users->province,
            'gender' => $digital_sign_users->gender,
            'place_of_birth' => $digital_sign_users->place_of_birth,
            'date_of_birth' => $digital_sign_users->date_of_birth,
            'org_unit' => $digital_sign_users->org_unit,
            'work_unit' => $digital_sign_users->work_unit,
            'position' => $digital_sign_users->position,
            'is_verified' => $digital_sign_users->is_verified,
            'callback_url' => $digital_sign_users->callback_url,
            'is_speciment' => $digital_sign_users->is_speciment,
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
        $digital_sign_users = new \plugins\model\primary\digital_sign_users($id);
        $digital_sign_users->modified = $this->GetServerDateTime();
        $digital_sign_users->muid = $this->user['id'];

        //delete logic here
        $digital_sign_users->dflag = 1;
        $digital_sign_users->modify();

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

        return \model\primary\digital_sign_usersContracts::SearchDataPagination($keyword);
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

        $data['digital_sign_users'] = \model\primary\digital_sign_usersContracts::SearchData($keyword);
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

        return \model\primary\digital_sign_usersContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $digital_sign_users = new \plugins\model\primary\digital_sign_users($id);

        $date_of_birth = DateTime::createFromFormat('Y-m-d', $digital_sign_users->date_of_birth);
        if ($date_of_birth instanceof DateTime) {
            $date_of_birth = $date_of_birth->format('d/m/Y');
        }

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
            'user' => usersContracts::GetById($digital_sign_users->user_id),
            'name' => $digital_sign_users->name,
            'phone' => $digital_sign_users->phone,
            'email' => $digital_sign_users->email,
            'type' => $digital_sign_users->type,
            'ktp' => $digital_sign_users->ktp,
            'npwp' => $digital_sign_users->npwp,
            'address' => $digital_sign_users->address,
            'city' => $digital_sign_users->city,
            'province' => $digital_sign_users->province,
            'gender' => $digital_sign_users->gender,
            'place_of_birth' => $digital_sign_users->place_of_birth,
            'date_of_birth' => $date_of_birth,
            'org_unit' => $digital_sign_users->org_unit,
            'work_unit' => $digital_sign_users->work_unit,
            'position' => $digital_sign_users->position,
            'is_verified' => $digital_sign_users->is_verified,
            'callback_url' => $digital_sign_users->callback_url,
            'is_speciment' => $digital_sign_users->is_speciment,
        ];

        return $data;
    }

}
