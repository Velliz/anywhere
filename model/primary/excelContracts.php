<?php

namespace model\primary;

use Exception;
use plugins\model\primary\excel;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class excelContracts
 * @package model
 */
class excelContracts extends excel implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, excel_name, column_specs, data_specs, request_type
        FROM excel
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, excel_name, column_specs, data_specs, request_type
        FROM excel
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM excel WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM excel WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM excel WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM excel WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, excel_name, column_specs, data_specs, request_type
        FROM excel
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
        $sql = sprintf("SELECT id, user_id, excel_name, column_specs, data_specs, request_type
        FROM excel
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

        $sql = sprintf("SELECT id, user_id, excel_name, column_specs, data_specs, request_type
        FROM excel
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
            "excel_name", //2
            "column_specs", //3
            "data_specs", //4
            "request_type", //5
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, user_id, excel_name, NULL AS column_specs, NULL AS data_specs, request_type
        FROM excel
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

    public static function GetExcelRender($api_key, $pdfId)
    {
        $sql = "SELECT * 
        FROM excel e 
        LEFT JOIN users u ON (e.user_id = u.id)
        WHERE u.api_key = @1 
        AND e.id = @2 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($api_key, $pdfId);
    }

    public static function GetApiKeyById($pdfId)
    {
        $sql = "SELECT u.api_key
        FROM excel e 
        LEFT JOIN users u ON (e.user_id = u.id)
        WHERE e.dflag = 0
        AND e.id = @1
        LIMIT 1";
        return DBI::Prepare($sql)->FirstRow($pdfId)['api_key'];
    }
}
