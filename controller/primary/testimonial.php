<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class testimonial extends Service
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
        if ($param['signature'] === '') {
            throw new Exception($this->say('SIGNATURE_REQUIRED'));
        }
        if ($param['subject'] === '') {
            throw new Exception($this->say('SUBJECT_REQUIRED'));
        }
        if ($param['testimonial'] === '') {
            throw new Exception($this->say('TESTIMONIAL_REQUIRED'));
        }
        if ($param['is_valid'] === '') {
            throw new Exception($this->say('IS_VALID_REQUIRED'));
        }
        if ($param['validation_date'] === '') {
            throw new Exception($this->say('VALIDATION_DATE_REQUIRED'));
        }


        //validations: customize here

        //insert
        $testimonial = new \plugins\model\primary\testimonial();
        $testimonial->id = $param['id'];
        $testimonial->user_id = $param['user_id'];
        $testimonial->signature = $param['signature'];
        $testimonial->subject = $param['subject'];
        $testimonial->testimonial = $param['testimonial'];
        $testimonial->is_valid = $param['is_valid'];
        $testimonial->validation_date = $param['validation_date'];


        $testimonial->save();

        //response
        $data['testimonial'] = [
            'id' => $testimonial->id,
        'user_id' => $testimonial->user_id,
        'signature' => $testimonial->signature,
        'subject' => $testimonial->subject,
        'testimonial' => $testimonial->testimonial,
        'is_valid' => $testimonial->is_valid,
        'validation_date' => $testimonial->validation_date,

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
        if ($param['signature'] === '') {
            throw new Exception($this->say('SIGNATURE_REQUIRED'));
        }
        if ($param['subject'] === '') {
            throw new Exception($this->say('SUBJECT_REQUIRED'));
        }
        if ($param['testimonial'] === '') {
            throw new Exception($this->say('TESTIMONIAL_REQUIRED'));
        }
        if ($param['is_valid'] === '') {
            throw new Exception($this->say('IS_VALID_REQUIRED'));
        }
        if ($param['validation_date'] === '') {
            throw new Exception($this->say('VALIDATION_DATE_REQUIRED'));
        }


        //validations: customize here

        //update
        $testimonial = new \plugins\model\primary\testimonial($id);
        $testimonial->id = $param['id'];
        $testimonial->user_id = $param['user_id'];
        $testimonial->signature = $param['signature'];
        $testimonial->subject = $param['subject'];
        $testimonial->testimonial = $param['testimonial'];
        $testimonial->is_valid = $param['is_valid'];
        $testimonial->validation_date = $param['validation_date'];


        $testimonial->modify();

        //response
        $data['testimonial'] = [
            'id' => $testimonial->id,
        'user_id' => $testimonial->user_id,
        'signature' => $testimonial->signature,
        'subject' => $testimonial->subject,
        'testimonial' => $testimonial->testimonial,
        'is_valid' => $testimonial->is_valid,
        'validation_date' => $testimonial->validation_date,

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
        $testimonial = new \plugins\model\primary\testimonial($id);

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

        return \model\primary\testimonialContracts::SearchDataPagination($keyword);
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

        $data['testimonial'] = \model\primary\testimonialContracts::SearchData($keyword);
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

        return \model\primary\testimonialContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $testimonial = new \plugins\model\primary\testimonial($id);

        //response
        $data['testimonial'] = [
            'id' => $testimonial->id,
        'user_id' => $testimonial->user_id,
        'signature' => $testimonial->signature,
        'subject' => $testimonial->subject,
        'testimonial' => $testimonial->testimonial,
        'is_valid' => $testimonial->is_valid,
        'validation_date' => $testimonial->validation_date,

        ];

        return $data;
    }

}
