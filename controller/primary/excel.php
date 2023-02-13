<?php

namespace controller\primary;

use DateTime;
use Exception;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class excel extends Service
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
        if ($param['excel_name'] === '') {
            throw new Exception($this->say('EXCEL_NAME_REQUIRED'));
        }
        if ($param['column_specs'] === '') {
            throw new Exception($this->say('COLUMN_SPECS_REQUIRED'));
        }
        if ($param['data_specs'] === '') {
            throw new Exception($this->say('DATA_SPECS_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }


        //validations: customize here

        //insert
        $excel = new \plugins\model\primary\excel();
        $excel->id = $param['id'];
        $excel->user_id = $param['user_id'];
        $excel->excel_name = $param['excel_name'];
        $excel->column_specs = $param['column_specs'];
        $excel->data_specs = $param['data_specs'];
        $excel->request_type = $param['request_type'];


        $excel->save();

        //response
        $data['excel'] = [
            'id' => $excel->id,
            'user_id' => $excel->user_id,
            'excel_name' => $excel->excel_name,
            'column_specs' => $excel->column_specs,
            'data_specs' => $excel->data_specs,
            'request_type' => $excel->request_type,
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
        if ($param['excel_name'] === '') {
            throw new Exception($this->say('EXCEL_NAME_REQUIRED'));
        }
        if ($param['column_specs'] === '') {
            throw new Exception($this->say('COLUMN_SPECS_REQUIRED'));
        }
        if ($param['data_specs'] === '') {
            throw new Exception($this->say('DATA_SPECS_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }


        //validations: customize here

        //update
        $excel = new \plugins\model\primary\excel($id);
        $excel->id = $param['id'];
        $excel->user_id = $param['user_id'];
        $excel->excel_name = $param['excel_name'];
        $excel->column_specs = $param['column_specs'];
        $excel->data_specs = $param['data_specs'];
        $excel->request_type = $param['request_type'];


        $excel->modify();

        //response
        $data['excel'] = [
            'id' => $excel->id,
            'user_id' => $excel->user_id,
            'excel_name' => $excel->excel_name,
            'column_specs' => $excel->column_specs,
            'data_specs' => $excel->data_specs,
            'request_type' => $excel->request_type,
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
        $excel = new \plugins\model\primary\excel($id);

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

        return \model\primary\excelContracts::SearchDataPagination($keyword);
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

        $data['excel'] = \model\primary\excelContracts::SearchData($keyword);
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

        return \model\primary\excelContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $excel = new \plugins\model\primary\excel($id);

        //response
        $data['excel'] = [
            'id' => $excel->id,
            'user_id' => $excel->user_id,
            'excel_name' => $excel->excel_name,
            'column_specs' => $excel->column_specs,
            'data_specs' => $excel->data_specs,
            'request_type' => $excel->request_type,
        ];

        return $data;
    }

}
