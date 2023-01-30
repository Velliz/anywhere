<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\pdfContracts;
use model\primary\usersContracts;
use plugins\UserBearerData;
use pukoframework\Framework;
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
     * #Auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['report_name'] === '') {
            throw new Exception($this->say('REPORT_NAME_REQUIRED'));
        }

        //validations: customize here
        $limit = pdfContracts::GetDataSizeWhere([
            'user_id' => $this->user['id'],
        ]);
        if ($limit >= $this->GetAppConstant('LIMITATIONS')) {
            throw new Exception($this->say('QUOTA_LIMITATIONS'));
        }

        //insert
        $pdf = new \plugins\model\primary\pdf();
        $pdf->created = $this->GetServerDateTime();
        $pdf->cuid = $this->user['id'];

        $pdf->user_id = $this->user['id'];
        $pdf->report_name = trim($param['report_name']);

        $css = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.pdf.css');
        $html = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.pdf.html');
        $json = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.pdf.json');
        $php = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.pdf.php');

        $pdf->html = $html;
        $pdf->css = $css;
        $pdf->php_script = $php;
        $pdf->request_sample = $json;
        $pdf->css_external = '';

        $pdf->output_mode = 'Inline';
        $pdf->paper = 'A4';
        $pdf->orientation = 'portrait';
        $pdf->request_type = 'POST';

        $pdf->save();

        //response
        $data['pdf'] = [
            'id' => $pdf->id,
            'user' => usersContracts::GetById($pdf->user_id),
            'report_name' => $pdf->report_name,
            'output_mode' => $pdf->output_mode,
            'paper' => $pdf->paper,
            'orientation' => $pdf->orientation,
            'request_type' => $pdf->request_type,
            'request_url' => $pdf->request_url,
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
        if ($param['report_name'] === '') {
            throw new Exception($this->say('REPORT_NAME_REQUIRED'));
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

        //validations: customize here

        //update
        $pdf = new \plugins\model\primary\pdf($id);
        $pdf->modified = $this->GetServerDateTime();
        $pdf->muid = $this->user['id'];

        $pdf->report_name = trim($param['report_name']);
        $pdf->output_mode = $param['output_mode'];
        $pdf->paper = trim($param['paper']);
        $pdf->orientation = $param['orientation'];

        $pdf->modify();

        //response
        $data['pdf'] = [
            'id' => $pdf->id,
            'user' => usersContracts::GetById($pdf->user_id),
            'report_name' => $pdf->report_name,
            'output_mode' => $pdf->output_mode,
            'paper' => $pdf->paper,
            'orientation' => $pdf->orientation,
            'request_type' => $pdf->request_type,
            'request_url' => $pdf->request_url,
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
        $pdf->modified = $this->GetServerDateTime();
        $pdf->muid = $this->user['id'];

        //delete logic here
        $pdf->dflag = 1;
        $pdf->modify();

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
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

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
            'user' => usersContracts::GetById($pdf->user_id),
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
