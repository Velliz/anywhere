<?php

namespace model\primary;

use Exception;
use plugins\model\primary\log_pdf;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class log_pdfContracts
 * @package model
 */
class log_pdfContracts extends log_pdf implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM log_pdf WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM log_pdf WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM log_pdf WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM log_pdf WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0
        ORDER BY id DESC
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow();
    }

    public static function SearchData($keyword = array())
    {
        $strings = "";
        foreach ($keyword as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0 %s;", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    public static function SearchDataPagination($keyword = array())
    {
        $pagination = new Paginations();
        $pagination->SetDBEngine('mysql');

        $strings = "";
        foreach ($keyword as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0 %s;", $strings);

        $pagination->SetQuery($sql);

        return $pagination->GetDataPaginations(function ($result) {
            foreach ($result as $key => $val) {
                //custom implementation here
                $result[$key] = $val;
            }
            return $result;
        });
    }

    public static function GetDataTable($condition = [])
    {
        $table = new DataTables(DataTables::POST);
        $table->SetDBEngine('mysql');
        $table->SetColumnSpec(array(
            "id", //0
            "pdf_id", //1
            "user_id", //2
            "sent_at", //3
            "json_data", //4
            "creator_info", //5
            "processing_time", //6
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, pdf_id, user_id, sent_at, json_data, creator_info, processing_time
        FROM log_pdf
        WHERE dflag = 0 %s;", $strings);

        $table->SetQuery($sql);

        return $table->GetDataTables(function ($result) {
            foreach ($result as $key => $val) {
                //custom implementation here
                $result[$key] = $val;
            }
            return $result;
        });
    }

    public static function GetPdfStats($id_pdf)
    {
        $sql = "SELECT logpdf.pdfid, pdf.reportname, COUNT(logpdf.pdfid) AS generated, logpdf.sentat AS lastprinted
        FROM logpdf
        LEFT JOIN pdf USING (pdfid)
        WHERE (logpdf.dflag = 0) 
        AND (logpdf.pdfid = @1)
        GROUP BY pdfid
        ORDER BY COUNT(logpdf.pdfid) DESC";
        return DBI::Prepare($sql)->GetData($id_pdf);
    }

    public static function GetPdfTimeline($id_pdf, $startdate, $enddate)
    {
        $sql = "SELECT logpdf.logid, logpdf.pdfid, pdf.reportname, logpdf.processingtime, logpdf.sentat
        FROM logpdf
        LEFT JOIN pdf USING (pdfid)
        WHERE (logpdf.dflag = 0)
        AND (logpdf.pdfid = @1)
        AND DATE(logpdf.sentat) BETWEEN DATE(@2) AND DATE(@3)
        ORDER BY logpdf.logid DESC";
        return DBI::Prepare($sql)->GetData($id_pdf, $startdate, $enddate);
    }

    public static function GetAllPopularity()
    {
        $sql = "SELECT logpdf.logid, pdf.reportname, COUNT(logpdf.logid) AS counter
        FROM logpdf
        LEFT JOIN pdf USING (logid)
        GROUP BY logid
        ORDER BY COUNT(logpdf.logid) DESC;";
        return DBI::Prepare($sql)->GetData();
    }

}
