<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class log_excel extends Service
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
        if ($param['excel_id'] === '') {
            throw new Exception($this->say('EXCEL_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['json_data'] === '') {
            throw new Exception($this->say('JSON_DATA_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //insert
        $log_excel = new \plugins\model\primary\log_excel();
        $log_excel->id = $param['id'];
        $log_excel->excel_id = $param['excel_id'];
        $log_excel->user_id = $param['user_id'];
        $log_excel->json_data = $param['json_data'];
        $log_excel->processing_time = $param['processing_time'];


        $log_excel->save();

        //response
        $data['log_excel'] = [
            'id' => $log_excel->id,
        'excel_id' => $log_excel->excel_id,
        'user_id' => $log_excel->user_id,
        'json_data' => $log_excel->json_data,
        'processing_time' => $log_excel->processing_time,

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
        if ($param['excel_id'] === '') {
            throw new Exception($this->say('EXCEL_ID_REQUIRED'));
        }
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['json_data'] === '') {
            throw new Exception($this->say('JSON_DATA_REQUIRED'));
        }
        if ($param['processing_time'] === '') {
            throw new Exception($this->say('PROCESSING_TIME_REQUIRED'));
        }


        //validations: customize here

        //update
        $log_excel = new \plugins\model\primary\log_excel($id);
        $log_excel->id = $param['id'];
        $log_excel->excel_id = $param['excel_id'];
        $log_excel->user_id = $param['user_id'];
        $log_excel->json_data = $param['json_data'];
        $log_excel->processing_time = $param['processing_time'];


        $log_excel->modify();

        //response
        $data['log_excel'] = [
            'id' => $log_excel->id,
        'excel_id' => $log_excel->excel_id,
        'user_id' => $log_excel->user_id,
        'json_data' => $log_excel->json_data,
        'processing_time' => $log_excel->processing_time,

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
        $log_excel = new \plugins\model\primary\log_excel($id);

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

        return \model\primary\log_excelContracts::SearchDataPagination($keyword);
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

        $data['log_excel'] = \model\primary\log_excelContracts::SearchData($keyword);
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

        return \model\primary\log_excelContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $log_excel = new \plugins\model\primary\log_excel($id);

        //response
        $data['log_excel'] = [
            'id' => $log_excel->id,
        'excel_id' => $log_excel->excel_id,
        'user_id' => $log_excel->user_id,
        'json_data' => $log_excel->json_data,
        'processing_time' => $log_excel->processing_time,

        ];

        return $data;
    }

}
