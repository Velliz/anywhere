<?php

namespace model\primary;

use Exception;
use plugins\model\primary\pdf;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class pdfContracts
 * @package model
 */
class pdfContracts extends pdf implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM pdf WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM pdf WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM pdf WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM pdf WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
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
        $sql = sprintf("SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
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

        $sql = sprintf("SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
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
            "user_id", //1
            "report_name", //2
            "html", //3
            "css", //4
            "php_script", //5
            "output_mode", //6
            "paper", //7
            "orientation", //8
            "request_type", //9
            "request_url", //10
            "request_sample", //11
            "css_external", //12
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, user_id, report_name, html, css, php_script, output_mode, paper, orientation, request_type, request_url, request_sample, css_external
        FROM pdf
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

    public static function GetPdfRender($api_key, $pdfId)
    {
        $sql = "SELECT * 
        FROM pdf p 
        LEFT JOIN users u ON (p.user_id = u.id)
        WHERE u.api_key = @1 
        AND p.id = @2 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($api_key, $pdfId);
    }

    public static function GetApiKeyById($pdfId)
    {
        $sql = "SELECT u.api_key
        FROM pdf p 
        LEFT JOIN users u ON (p.user_id = u.id)
        WHERE p.dflag = 0
        AND p.id = @1
        LIMIT 1";
        return DBI::Prepare($sql)->FirstRow($pdfId)['api_key'];
    }
}
