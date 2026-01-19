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
class log_pdf extends Service
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
        if ($param['pdf_id'] === '') {
            throw new Exception($this->say('PDF_ID_REQUIRED'));
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
        $log_pdf = new \plugins\model\primary\log_pdf();
        $log_pdf->created = $this->GetServerDateTime();
        $log_pdf->cuid = $this->user['id'];

        $log_pdf->user_id = $this->user['id'];

        $log_pdf->pdf_id = $param['pdf_id'];
        $log_pdf->sent_at = $param['sent_at'];
        $log_pdf->json_data = $param['json_data'];
        $log_pdf->creator_info = $param['creator_info'];
        $log_pdf->processing_time = $param['processing_time'];

        $log_pdf->save();

        //response
        $data['log_pdf'] = [
            'id' => $log_pdf->id,
            'pdf_id' => $log_pdf->pdf_id,
            'user_id' => $log_pdf->user_id,
            'sent_at' => $log_pdf->sent_at,
            'json_data' => $log_pdf->json_data,
            'creator_info' => $log_pdf->creator_info,
            'processing_time' => $log_pdf->processing_time,
        ];

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * #Auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['pdf_id'] === '') {
            throw new Exception($this->say('PDF_ID_REQUIRED'));
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
        $log_pdf = new \plugins\model\primary\log_pdf($id);
        $log_pdf->modified = $this->GetServerDateTime();
        $log_pdf->muid = $this->user['id'];

        $log_pdf->user_id = $this->user['id'];

        $log_pdf->pdf_id = $param['pdf_id'];
        $log_pdf->sent_at = $param['sent_at'];
        $log_pdf->json_data = $param['json_data'];
        $log_pdf->creator_info = $param['creator_info'];
        $log_pdf->processing_time = $param['processing_time'];

        $log_pdf->modify();

        //response
        $data['log_pdf'] = [
            'id' => $log_pdf->id,
            'pdf_id' => $log_pdf->pdf_id,
            'user_id' => $log_pdf->user_id,
            'sent_at' => $log_pdf->sent_at,
            'json_data' => $log_pdf->json_data,
            'creator_info' => $log_pdf->creator_info,
            'processing_time' => $log_pdf->processing_time,
        ];

        return $data;
    }

    /**
     * @param string $id
     * @throws Exception
     * #Auth bearer true
     */
    public function delete($id = '')
    {
        $log_pdf = new \plugins\model\primary\log_pdf($id);
        $log_pdf->modified = $this->GetServerDateTime();
        $log_pdf->muid = $this->user['id'];

        //delete logic here
        $log_pdf->dflag = 1;
        $log_pdf->modify();

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
        if (isset($param['pdf_id'])) {
            $keyword['pdf_id'] = $param['pdf_id'];
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

        return \model\primary\log_pdfContracts::SearchDataPagination($keyword);
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
        if (isset($param['pdf_id'])) {
            $keyword['pdf_id'] = $param['pdf_id'];
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

        $data['log_pdf'] = \model\primary\log_pdfContracts::SearchData($keyword);
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

        $pdf_id = Request::Post('pdf_id', '');
        if ($pdf_id !== '') {
            $keyword['pdf_id'] = $pdf_id;
        }

        return \model\primary\log_pdfContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $log_pdf = new \plugins\model\primary\log_pdf($id);

        //response
        $data['log_pdf'] = [
            'id' => $log_pdf->id,
            'pdf_id' => $log_pdf->pdf_id,
            'user_id' => $log_pdf->user_id,
            'sent_at' => $log_pdf->sent_at,
            'json_data' => $log_pdf->json_data,
            'creator_info' => $log_pdf->creator_info,
            'processing_time' => $log_pdf->processing_time,
        ];

        return $data;
    }

}
