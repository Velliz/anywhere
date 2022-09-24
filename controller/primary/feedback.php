<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class feedback extends Service
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
        if ($param['feedback'] === '') {
            throw new Exception($this->say('FEEDBACK_REQUIRED'));
        }
        if ($param['is_approved'] === '') {
            throw new Exception($this->say('IS_APPROVED_REQUIRED'));
        }
        if ($param['approved_date'] === '') {
            throw new Exception($this->say('APPROVED_DATE_REQUIRED'));
        }
        if ($param['feedback_responds'] === '') {
            throw new Exception($this->say('FEEDBACK_RESPONDS_REQUIRED'));
        }


        //validations: customize here

        //insert
        $feedback = new \plugins\model\primary\feedback();
        $feedback->id = $param['id'];
        $feedback->user_id = $param['user_id'];
        $feedback->signature = $param['signature'];
        $feedback->subject = $param['subject'];
        $feedback->feedback = $param['feedback'];
        $feedback->is_approved = $param['is_approved'];
        $feedback->approved_date = $param['approved_date'];
        $feedback->feedback_responds = $param['feedback_responds'];


        $feedback->save();

        //response
        $data['feedback'] = [
            'id' => $feedback->id,
        'user_id' => $feedback->user_id,
        'signature' => $feedback->signature,
        'subject' => $feedback->subject,
        'feedback' => $feedback->feedback,
        'is_approved' => $feedback->is_approved,
        'approved_date' => $feedback->approved_date,
        'feedback_responds' => $feedback->feedback_responds,

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
        if ($param['feedback'] === '') {
            throw new Exception($this->say('FEEDBACK_REQUIRED'));
        }
        if ($param['is_approved'] === '') {
            throw new Exception($this->say('IS_APPROVED_REQUIRED'));
        }
        if ($param['approved_date'] === '') {
            throw new Exception($this->say('APPROVED_DATE_REQUIRED'));
        }
        if ($param['feedback_responds'] === '') {
            throw new Exception($this->say('FEEDBACK_RESPONDS_REQUIRED'));
        }


        //validations: customize here

        //update
        $feedback = new \plugins\model\primary\feedback($id);
        $feedback->id = $param['id'];
        $feedback->user_id = $param['user_id'];
        $feedback->signature = $param['signature'];
        $feedback->subject = $param['subject'];
        $feedback->feedback = $param['feedback'];
        $feedback->is_approved = $param['is_approved'];
        $feedback->approved_date = $param['approved_date'];
        $feedback->feedback_responds = $param['feedback_responds'];


        $feedback->modify();

        //response
        $data['feedback'] = [
            'id' => $feedback->id,
        'user_id' => $feedback->user_id,
        'signature' => $feedback->signature,
        'subject' => $feedback->subject,
        'feedback' => $feedback->feedback,
        'is_approved' => $feedback->is_approved,
        'approved_date' => $feedback->approved_date,
        'feedback_responds' => $feedback->feedback_responds,

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
        $feedback = new \plugins\model\primary\feedback($id);

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

        return \model\primary\feedbackContracts::SearchDataPagination($keyword);
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

        $data['feedback'] = \model\primary\feedbackContracts::SearchData($keyword);
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

        return \model\primary\feedbackContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $feedback = new \plugins\model\primary\feedback($id);

        //response
        $data['feedback'] = [
            'id' => $feedback->id,
        'user_id' => $feedback->user_id,
        'signature' => $feedback->signature,
        'subject' => $feedback->subject,
        'feedback' => $feedback->feedback,
        'is_approved' => $feedback->is_approved,
        'approved_date' => $feedback->approved_date,
        'feedback_responds' => $feedback->feedback_responds,

        ];

        return $data;
    }

}
