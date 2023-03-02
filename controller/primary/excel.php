<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\usersContracts;
use plugins\UserBearerData;
use pukoframework\Framework;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class excel extends Service
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
        if ($param['excel_name'] === '') {
            throw new Exception($this->say('EXCEL_NAME_REQUIRED'));
        }

        //validations: customize here

        //insert
        $excel = new \plugins\model\primary\excel();
        $excel->created = $this->GetServerDateTime();
        $excel->cuid = $this->user['id'];

        $excel->user_id = $this->user['id'];
        $excel->excel_name = $param['excel_name'];

        $excel->request_type = 'POST';

        $column_specs = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.excel.columnspecs.json');
        $data_specs = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.excel.dataspecs.json');

        $excel->column_specs = $column_specs;
        $excel->data_specs = $data_specs;

        $excel->save();

        //response
        $data['excel'] = [
            'id' => $excel->id,
            'user' => usersContracts::GetById($excel->user_id),
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
        $excel->modified = $this->GetServerDateTime();
        $excel->muid = $this->user['id'];

        $excel->excel_name = $param['excel_name'];
        $excel->column_specs = $param['column_specs'];
        $excel->data_specs = $param['data_specs'];
        $excel->request_type = $param['request_type'];

        $excel->modify();

        //response
        $data['excel'] = [
            'id' => $excel->id,
            'user' => usersContracts::GetById($excel->user_id),
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
        $excel->modified = $this->GetServerDateTime();
        $excel->muid = $this->user['id'];

        //delete logic here
        $excel->dflag = 1;

        $excel->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
        $user_id = Request::Post('user_id', '');
        if ($user_id !== '') {
            $keyword['user_id'] = $user_id;
        }

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
            'user' => usersContracts::GetById($excel->user_id),
            'excel_name' => $excel->excel_name,
            'column_specs' => $excel->column_specs,
            'data_specs' => $excel->data_specs,
            'request_type' => $excel->request_type,
        ];

        return $data;
    }

}
