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
class feedback extends Service
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
        if ($param['signature'] === '') {
            throw new Exception($this->say('SIGNATURE_REQUIRED'));
        }
        if ($param['subject'] === '') {
            throw new Exception($this->say('SUBJECT_REQUIRED'));
        }
        if ($param['feedback'] === '') {
            throw new Exception($this->say('FEEDBACK_REQUIRED'));
        }
        if ($param['feedback_responds'] === '') {
            throw new Exception($this->say('FEEDBACK_RESPONDS_REQUIRED'));
        }

        //validations: customize here

        //insert
        $feedback = new \plugins\model\primary\feedback();
        $feedback->created = $this->GetServerDateTime();
        $feedback->cuid = $this->user['id'];

        $feedback->user_id = $this->user['id'];

        $feedback->signature = trim($param['signature']);
        $feedback->subject = trim($param['subject']);
        $feedback->feedback = trim($param['feedback']);
        $feedback->feedback_responds = trim($param['feedback_responds']);

        $feedback->save();

        //response
        $data['feedback'] = [
            'id' => $feedback->id,
            'user' => usersContracts::GetById($feedback->user_id),
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
        $feedback->modified = $this->GetServerDateTime();
        $feedback->muid = $this->user['id'];

        $feedback->user_id = $this->user['id'];

        $feedback->signature = trim($param['signature']);
        $feedback->subject = trim($param['subject']);
        $feedback->feedback = trim($param['feedback']);
        $feedback->feedback_responds = trim($param['feedback_responds']);

        $feedback->modify();

        //response
        $data['feedback'] = [
            'id' => $feedback->id,
            'user' => usersContracts::GetById($feedback->user_id),
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
        $feedback->modified = $this->GetServerDateTime();
        $feedback->muid = $this->user['id'];

        //delete logic here
        $feedback->dflag = 1;
        $feedback->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $keyword['user_id'] = $this->user['id'];

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
            'user' => usersContracts::GetById($feedback->user_id),
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
