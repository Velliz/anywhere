<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class digital_sign_users extends Service
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
        if ($param['is_verified'] === '') {
            throw new Exception($this->say('IS_VERIFIED_REQUIRED'));
        }
        if ($param['callback_url'] === '') {
            throw new Exception($this->say('CALLBACK_URL_REQUIRED'));
        }
        if ($param['is_speciment'] === '') {
            throw new Exception($this->say('IS_SPECIMENT_REQUIRED'));
        }


        //validations: customize here

        //insert
        $digital_sign_users = new \plugins\model\primary\digital_sign_users();
        $digital_sign_users->id = $param['id'];
        $digital_sign_users->user_id = $param['user_id'];
        $digital_sign_users->name = $param['name'];
        $digital_sign_users->phone = $param['phone'];
        $digital_sign_users->email = $param['email'];
        $digital_sign_users->type = $param['type'];
        $digital_sign_users->ktp = $param['ktp'];
        $digital_sign_users->npwp = $param['npwp'];
        $digital_sign_users->address = $param['address'];
        $digital_sign_users->city = $param['city'];
        $digital_sign_users->province = $param['province'];
        $digital_sign_users->gender = $param['gender'];
        $digital_sign_users->place_of_birth = $param['place_of_birth'];
        $digital_sign_users->date_of_birth = $param['date_of_birth'];
        $digital_sign_users->org_unit = $param['org_unit'];
        $digital_sign_users->work_unit = $param['work_unit'];
        $digital_sign_users->position = $param['position'];
        $digital_sign_users->is_verified = $param['is_verified'];
        $digital_sign_users->callback_url = $param['callback_url'];
        $digital_sign_users->is_speciment = $param['is_speciment'];


        $digital_sign_users->save();

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
        'user_id' => $digital_sign_users->user_id,
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
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
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
        if ($param['is_verified'] === '') {
            throw new Exception($this->say('IS_VERIFIED_REQUIRED'));
        }
        if ($param['callback_url'] === '') {
            throw new Exception($this->say('CALLBACK_URL_REQUIRED'));
        }
        if ($param['is_speciment'] === '') {
            throw new Exception($this->say('IS_SPECIMENT_REQUIRED'));
        }


        //validations: customize here

        //update
        $digital_sign_users = new \plugins\model\primary\digital_sign_users($id);
        $digital_sign_users->id = $param['id'];
        $digital_sign_users->user_id = $param['user_id'];
        $digital_sign_users->name = $param['name'];
        $digital_sign_users->phone = $param['phone'];
        $digital_sign_users->email = $param['email'];
        $digital_sign_users->type = $param['type'];
        $digital_sign_users->ktp = $param['ktp'];
        $digital_sign_users->npwp = $param['npwp'];
        $digital_sign_users->address = $param['address'];
        $digital_sign_users->city = $param['city'];
        $digital_sign_users->province = $param['province'];
        $digital_sign_users->gender = $param['gender'];
        $digital_sign_users->place_of_birth = $param['place_of_birth'];
        $digital_sign_users->date_of_birth = $param['date_of_birth'];
        $digital_sign_users->org_unit = $param['org_unit'];
        $digital_sign_users->work_unit = $param['work_unit'];
        $digital_sign_users->position = $param['position'];
        $digital_sign_users->is_verified = $param['is_verified'];
        $digital_sign_users->callback_url = $param['callback_url'];
        $digital_sign_users->is_speciment = $param['is_speciment'];


        $digital_sign_users->modify();

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
        'user_id' => $digital_sign_users->user_id,
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

        //response
        $data['digital_sign_users'] = [
            'id' => $digital_sign_users->id,
        'user_id' => $digital_sign_users->user_id,
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

}
