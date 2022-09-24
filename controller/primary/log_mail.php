<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class log_mail extends Service
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
        if ($param['mail_id'] === '') {
            throw new Exception($this->say('MAIL_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
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
        $log_mail->id = $param['id'];
        $log_mail->mail_id = $param['mail_id'];
        $log_mail->user_id = $param['user_id'];
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
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['mail_id'] === '') {
            throw new Exception($this->say('MAIL_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
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
        $log_mail->id = $param['id'];
        $log_mail->mail_id = $param['mail_id'];
        $log_mail->user_id = $param['user_id'];
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
