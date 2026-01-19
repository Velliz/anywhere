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
class testimonial extends Service
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
        $testimonial->created = $this->GetServerDateTime();
        $testimonial->cuid = $this->user['id'];

        $testimonial->user_id = $this->user['id'];

        $testimonial->signature = trim($param['signature']);
        $testimonial->subject = trim($param['subject']);
        $testimonial->testimonial = trim($param['testimonial']);

        $testimonial->save();

        //response
        $data['testimonial'] = [
            'id' => $testimonial->id,
            'user' => usersContracts::GetById($testimonial->user_id),
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
     * #Auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
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
        $testimonial->modified = $this->GetServerDateTime();
        $testimonial->muid = $this->user['id'];

        $testimonial->user_id = $this->user['id'];

        $testimonial->signature = trim($param['signature']);
        $testimonial->subject = trim($param['subject']);
        $testimonial->testimonial = trim($param['testimonial']);

        $testimonial->modify();

        //response
        $data['testimonial'] = [
            'id' => $testimonial->id,
            'user' => usersContracts::GetById($testimonial->user_id),
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
     * #Auth bearer true
     */
    public function delete($id = '')
    {
        $testimonial = new \plugins\model\primary\testimonial($id);
        $testimonial->modified = $this->GetServerDateTime();
        $testimonial->muid = $this->user['id'];

        //delete logic here
        $testimonial->dflag = 1;
        $testimonial->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $keyword['user_id'] = $this->user['id'];

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
            'user' => usersContracts::GetById($testimonial->user_id),
            'signature' => $testimonial->signature,
            'subject' => $testimonial->subject,
            'testimonial' => $testimonial->testimonial,
            'is_valid' => $testimonial->is_valid,
            'validation_date' => $testimonial->validation_date,

        ];

        return $data;
    }

}
