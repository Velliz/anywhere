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
class pdf extends Service
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
        if ($param['user_id'] === '') {
            throw new Exception($this->say('USER_ID_REQUIRED'));
        }
        if ($param['report_name'] === '') {
            throw new Exception($this->say('REPORT_NAME_REQUIRED'));
        }
        if ($param['html'] === '') {
            throw new Exception($this->say('HTML_REQUIRED'));
        }
        if ($param['css'] === '') {
            throw new Exception($this->say('CSS_REQUIRED'));
        }
        if ($param['php_script'] === '') {
            throw new Exception($this->say('PHP_SCRIPT_REQUIRED'));
        }
        if ($param['output_mode'] === '') {
            throw new Exception($this->say('OUTPUT_MODE_REQUIRED'));
        }
        if ($param['paper'] === '') {
            throw new Exception($this->say('PAPER_REQUIRED'));
        }
        if ($param['orientation'] === '') {
            throw new Exception($this->say('ORIENTATION_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['css_external'] === '') {
            throw new Exception($this->say('CSS_EXTERNAL_REQUIRED'));
        }


        //validations: customize here

        //insert
        $pdf = new \plugins\model\primary\pdf();
        $pdf->id = $param['id'];
        $pdf->user_id = $param['user_id'];
        $pdf->report_name = $param['report_name'];
        $pdf->html = $param['html'];
        $pdf->css = $param['css'];
        $pdf->php_script = $param['php_script'];
        $pdf->output_mode = $param['output_mode'];
        $pdf->paper = $param['paper'];
        $pdf->orientation = $param['orientation'];
        $pdf->request_type = $param['request_type'];
        $pdf->request_url = $param['request_url'];
        $pdf->request_sample = $param['request_sample'];
        $pdf->css_external = $param['css_external'];


        $pdf->save();

        //response
        $data['pdf'] = [
            'id' => $pdf->id,
            'user_id' => $pdf->user_id,
            'report_name' => $pdf->report_name,
            'html' => $pdf->html,
            'css' => $pdf->css,
            'php_script' => $pdf->php_script,
            'output_mode' => $pdf->output_mode,
            'paper' => $pdf->paper,
            'orientation' => $pdf->orientation,
            'request_type' => $pdf->request_type,
            'request_url' => $pdf->request_url,
            'request_sample' => $pdf->request_sample,
            'css_external' => $pdf->css_external,

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
        if ($param['report_name'] === '') {
            throw new Exception($this->say('REPORT_NAME_REQUIRED'));
        }
        if ($param['html'] === '') {
            throw new Exception($this->say('HTML_REQUIRED'));
        }
        if ($param['css'] === '') {
            throw new Exception($this->say('CSS_REQUIRED'));
        }
        if ($param['php_script'] === '') {
            throw new Exception($this->say('PHP_SCRIPT_REQUIRED'));
        }
        if ($param['output_mode'] === '') {
            throw new Exception($this->say('OUTPUT_MODE_REQUIRED'));
        }
        if ($param['paper'] === '') {
            throw new Exception($this->say('PAPER_REQUIRED'));
        }
        if ($param['orientation'] === '') {
            throw new Exception($this->say('ORIENTATION_REQUIRED'));
        }
        if ($param['request_type'] === '') {
            throw new Exception($this->say('REQUEST_TYPE_REQUIRED'));
        }
        if ($param['request_url'] === '') {
            throw new Exception($this->say('REQUEST_URL_REQUIRED'));
        }
        if ($param['request_sample'] === '') {
            throw new Exception($this->say('REQUEST_SAMPLE_REQUIRED'));
        }
        if ($param['css_external'] === '') {
            throw new Exception($this->say('CSS_EXTERNAL_REQUIRED'));
        }


        //validations: customize here

        //update
        $pdf = new \plugins\model\primary\pdf($id);
        $pdf->id = $param['id'];
        $pdf->user_id = $param['user_id'];
        $pdf->report_name = $param['report_name'];
        $pdf->html = $param['html'];
        $pdf->css = $param['css'];
        $pdf->php_script = $param['php_script'];
        $pdf->output_mode = $param['output_mode'];
        $pdf->paper = $param['paper'];
        $pdf->orientation = $param['orientation'];
        $pdf->request_type = $param['request_type'];
        $pdf->request_url = $param['request_url'];
        $pdf->request_sample = $param['request_sample'];
        $pdf->css_external = $param['css_external'];


        $pdf->modify();

        //response
        $data['pdf'] = [
            'id' => $pdf->id,
            'user_id' => $pdf->user_id,
            'report_name' => $pdf->report_name,
            'html' => $pdf->html,
            'css' => $pdf->css,
            'php_script' => $pdf->php_script,
            'output_mode' => $pdf->output_mode,
            'paper' => $pdf->paper,
            'orientation' => $pdf->orientation,
            'request_type' => $pdf->request_type,
            'request_url' => $pdf->request_url,
            'request_sample' => $pdf->request_sample,
            'css_external' => $pdf->css_external,

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
        $pdf = new \plugins\model\primary\pdf($id);

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

        return \model\primary\pdfContracts::SearchDataPagination($keyword);
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

        $data['pdf'] = \model\primary\pdfContracts::SearchData($keyword);
        return $data;
    }

    /**
     * @return array
     * @throws Exception
     * #Auth bearer true
     */
    public function table()
    {
        $keyword = [];

        //post addition filter here
        $keyword['user_id'] = $this->user['id'];

        return \model\primary\pdfContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $pdf = new \plugins\model\primary\pdf($id);

        //response
        $data['pdf'] = [
            'id' => $pdf->id,
            'user_id' => $pdf->user_id,
            'report_name' => $pdf->report_name,
            'html' => $pdf->html,
            'css' => $pdf->css,
            'php_script' => $pdf->php_script,
            'output_mode' => $pdf->output_mode,
            'paper' => $pdf->paper,
            'orientation' => $pdf->orientation,
            'request_type' => $pdf->request_type,
            'request_url' => $pdf->request_url,
            'request_sample' => $pdf->request_sample,
            'css_external' => $pdf->css_external,

        ];

        return $data;
    }

}
