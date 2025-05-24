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
class log_word extends Service
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
        if ($param['id'] === '') {
            throw new Exception($this->say('ID_REQUIRED'));
        }
        if ($param['word_id'] === '') {
            throw new Exception($this->say('WORD_ID_REQUIRED'));
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
        if ($param['creator_info'] === '') {
            throw new Exception($this->say('CREATOR_INFO_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //insert
        $log_word = new \plugins\model\primary\log_word();
        $log_word->id = $param['id'];
        $log_word->word_id = $param['word_id'];
        $log_word->user_id = $param['user_id'];
        $log_word->sent_at = $param['sent_at'];
        $log_word->json_data = $param['json_data'];
        $log_word->creator_info = $param['creator_info'];
        $log_word->processing_time = $param['processing_time'];


        $log_word->save();

        //response
        $data['log_word'] = [
            'id' => $log_word->id,
            'word_id' => $log_word->word_id,
            'user_id' => $log_word->user_id,
            'sent_at' => $log_word->sent_at,
            'json_data' => $log_word->json_data,
            'creator_info' => $log_word->creator_info,
            'processing_time' => $log_word->processing_time,

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
        if ($param['word_id'] === '') {
            throw new Exception($this->say('WORD_ID_REQUIRED'));
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
        if ($param['creator_info'] === '') {
            throw new Exception($this->say('CREATOR_INFO_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //update
        $log_word = new \plugins\model\primary\log_word($id);
        $log_word->id = $param['id'];
        $log_word->word_id = $param['word_id'];
        $log_word->user_id = $param['user_id'];
        $log_word->sent_at = $param['sent_at'];
        $log_word->json_data = $param['json_data'];
        $log_word->creator_info = $param['creator_info'];
        $log_word->processing_time = $param['processing_time'];


        $log_word->modify();

        //response
        $data['log_word'] = [
            'id' => $log_word->id,
            'word_id' => $log_word->word_id,
            'user_id' => $log_word->user_id,
            'sent_at' => $log_word->sent_at,
            'json_data' => $log_word->json_data,
            'creator_info' => $log_word->creator_info,
            'processing_time' => $log_word->processing_time,

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
        $log_word = new \plugins\model\primary\log_word($id);

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
        $param = Request::JsonBody();
        //post addition filter here
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }
        if (isset($param['word_id'])) {
            $keyword['word_id'] = $param['word_id'];
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

        return \model\primary\log_wordContracts::SearchDataPagination($keyword);
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
        if (isset($param['word_id'])) {
            $keyword['word_id'] = $param['word_id'];
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

        $data['log_word'] = \model\primary\log_wordContracts::SearchData($keyword);
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

        $word_id = Request::Post('word_id', '');
        if ($word_id !== '') {
            $keyword['word_id'] = $word_id;
        }

        return \model\primary\log_wordContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $log_word = new \plugins\model\primary\log_word($id);

        //response
        $data['log_word'] = [
            'id' => $log_word->id,
            'word_id' => $log_word->word_id,
            'user_id' => $log_word->user_id,
            'sent_at' => $log_word->sent_at,
            'json_data' => $log_word->json_data,
            'creator_info' => $log_word->creator_info,
            'processing_time' => $log_word->processing_time,

        ];

        return $data;
    }

}
