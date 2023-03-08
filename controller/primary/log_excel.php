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
class log_excel extends Service
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
        $log_excel->created = $this->GetServerDateTime();
        $log_excel->cuid = $this->user['id'];

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
        $log_excel->modified = $this->GetServerDateTime();
        $log_excel->muid = $this->user['id'];

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
        $log_excel->modified = $this->GetServerDateTime();
        $log_excel->muid = $this->user['id'];

        //delete logic here
        $log_excel->dflag = 1;
        $log_excel->modify();

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
        if (isset($param['excel_id'])) {
            $keyword['excel_id'] = $param['excel_id'];
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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }
        if (isset($param['excel_id'])) {
            $keyword['excel_id'] = $param['excel_id'];
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
        $keyword['user_id'] = $this->user['id'];

        $excel_id = Request::Post('excel_id', '');
        if ($excel_id !== '') {
            $keyword['excel_id'] = $excel_id;
        }

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
