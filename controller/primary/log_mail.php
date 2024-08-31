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
class log_mail extends Service
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
        if ($param['mail_id'] === '') {
            throw new Exception($this->say('MAIL_ID_REQUIRED'));
        }
        if ($param['sent_at'] === '') {
            throw new Exception($this->say('SENT_AT_REQUIRED'));
        }
        if ($param['json_data'] === '') {
            throw new Exception($this->say('JSON_DATA_REQUIRED'));
        }
        if ($param['result_data'] === '') {
            throw new Exception($this->say('RESULT_DATA_REQUIRED'));
        }
        if ($param['debug_info'] === '') {
            throw new Exception($this->say('DEBUG_INFO_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }

        //validations: customize here

        //insert
        $log_mail = new \plugins\model\primary\log_mail();
        $log_mail->created = $this->GetServerDateTime();
        $log_mail->cuid = $this->user['id'];

        $log_mail->user_id = $this->user['id'];

        $log_mail->mail_id = $param['mail_id'];
        $log_mail->sent_at = $param['sent_at'];
        $log_mail->json_data = $param['json_data'];
        $log_mail->result_data = $param['result_data'];
        $log_mail->debug_info = $param['debug_info'];
        $log_mail->processing_time = $param['processing_time'];

        $log_mail->save();

        //response
        $data['log_mail'] = [
            'id' => $log_mail->id,
            'mail_id' => $log_mail->mail_id,
            'user_id' => $log_mail->user_id,
            'sent_at' => $log_mail->sent_at,
            'json_data' => $log_mail->json_data,
            'result_data' => $log_mail->result_data,
            'debug_info' => $log_mail->debug_info,
            'processing_time' => $log_mail->processing_time,
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
        if ($param['mail_id'] === '') {
            throw new Exception($this->say('MAIL_ID_REQUIRED'));
        }
        if ($param['sent_at'] === '') {
            throw new Exception($this->say('SENT_AT_REQUIRED'));
        }
        if ($param['json_data'] === '') {
            throw new Exception($this->say('JSON_DATA_REQUIRED'));
        }
        if ($param['result_data'] === '') {
            throw new Exception($this->say('RESULT_DATA_REQUIRED'));
        }
        if ($param['debug_info'] === '') {
            throw new Exception($this->say('DEBUG_INFO_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }

        //validations: customize here

        //update
        $log_mail = new \plugins\model\primary\log_mail($id);
        $log_mail->modified = $this->GetServerDateTime();
        $log_mail->muid = $this->user['id'];

        $log_mail->user_id = $this->user['id'];

        $log_mail->mail_id = $param['mail_id'];
        $log_mail->sent_at = $param['sent_at'];
        $log_mail->json_data = $param['json_data'];
        $log_mail->result_data = $param['result_data'];
        $log_mail->debug_info = $param['debug_info'];
        $log_mail->processing_time = $param['processing_time'];

        $log_mail->modify();

        //response
        $data['log_mail'] = [
            'id' => $log_mail->id,
            'mail_id' => $log_mail->mail_id,
            'user_id' => $log_mail->user_id,
            'sent_at' => $log_mail->sent_at,
            'json_data' => $log_mail->json_data,
            'result_data' => $log_mail->result_data,
            'debug_info' => $log_mail->debug_info,
            'processing_time' => $log_mail->processing_time,
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
        $log_mail = new \plugins\model\primary\log_mail($id);
        $log_mail->modified = $this->GetServerDateTime();
        $log_mail->muid = $this->user['id'];

        //delete logic here
        $log_mail->dflag = 1;
        $log_mail->modify();

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
        if (isset($param['mail_id'])) {
            $keyword['mail_id'] = $param['mail_id'];
        }

        if (isset($param['range'])) {
            $range = explode(' - ', $param['range']);
            if (sizeof($range) !== 2) {
                throw new Exception($this->say('INVALID_RANGE'));
            }

            $start = DateTime::createFromFormat('d/m/Y', $range[0]);
            $end = DateTime::createFromFormat('d/m/Y', $range[1]);
            if (!$start instanceof DateTime) {
                throw new Exception($this->say('INVALID_RANGE'));
            }
            if (!$end instanceof DateTime) {
                throw new Exception($this->say('INVALID_RANGE'));
            }

            $keyword['*'] = " AND DATE(sent_at) BETWEEN DATE('{$start->format('Y-m-d')}') AND DATE('{$end->format('Y-m-d')}') ";
        }

        return \model\primary\log_mailContracts::SearchDataPagination($keyword);
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
        if (isset($param['mail_id'])) {
            $keyword['mail_id'] = $param['mail_id'];
        }

        if (isset($param['range'])) {
            $range = explode(' - ', $param['range']);
            if (sizeof($range) !== 2) {
                throw new Exception($this->say('INVALID_RANGE'));
            }

            $start = DateTime::createFromFormat('d/m/Y', $range[0]);
            $end = DateTime::createFromFormat('d/m/Y', $range[1]);
            if (!$start instanceof DateTime) {
                throw new Exception($this->say('INVALID_RANGE'));
            }
            if (!$end instanceof DateTime) {
                throw new Exception($this->say('INVALID_RANGE'));
            }

            $keyword['*'] = " AND DATE(sent_at) BETWEEN DATE('{$start->format('Y-m-d')}') AND DATE('{$end->format('Y-m-d')}') ";
        }

        $data['log_mail'] = \model\primary\log_mailContracts::SearchData($keyword);
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

        $mail_id = Request::Post('mail_id', '');
        if ($mail_id !== '') {
            $keyword['mail_id'] = $mail_id;
        }

        return \model\primary\log_mailContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $log_mail = new \plugins\model\primary\log_mail($id);

        //response
        $data['log_mail'] = [
            'id' => $log_mail->id,
            'mail_id' => $log_mail->mail_id,
            'user_id' => $log_mail->user_id,
            'sent_at' => $log_mail->sent_at,
            'json_data' => $log_mail->json_data,
            'result_data' => $log_mail->result_data,
            'debug_info' => $log_mail->debug_info,
            'processing_time' => $log_mail->processing_time,
        ];

        return $data;
    }

}
