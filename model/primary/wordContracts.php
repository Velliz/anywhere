<?php

namespace model\primary;

use Exception;
use plugins\model\primary\word;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class wordContracts
 * @package model
 */
class wordContracts extends word implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, word_name, request_sample
        FROM word
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, word_name, word_template, request_sample
        FROM word
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM word WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM word WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM word WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, str_replace("'", "\'", $values));
            }
        }
        $sql = sprintf("SELECT COUNT(id) data FROM word WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, word_name, request_sample
        FROM word
        WHERE dflag = 0
        ORDER BY id DESC
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow();
    }

    public static function SearchData($keyword = array())
    {
        $strings = "";
        foreach ($keyword as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, str_replace("'", "\'", $values));
            }
        }
        $sql = sprintf("SELECT id, user_id, word_name, request_sample
        FROM word
        WHERE dflag = 0 %s;", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    public static function SearchDataPagination($keyword = array())
    {
        $pagination = new Paginations();
        $pagination->SetDBEngine('mysql');

        $strings = "";
        foreach ($keyword as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, str_replace("'", "\'", $values));
            }
        }

        $sql = sprintf("SELECT id, user_id, word_name, request_sample
        FROM word
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
            "word_name", //2
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, str_replace("'", "\'", $values));
            }
        }

        $sql = sprintf("SELECT id, user_id, word_name, request_sample
        FROM word
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

    public static function GetWordRender($api_key, $pdfId)
    {
        $sql = "SELECT * 
        FROM word w
        LEFT JOIN users u ON (w.user_id = u.id)
        WHERE u.api_key = @1 
        AND w.id = @2 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($api_key, $pdfId);
    }

    public static function GetApiKeyById($pdfId)
    {
        $sql = "SELECT u.api_key
        FROM word w
        LEFT JOIN users u ON (w.user_id = u.id)
        WHERE w.dflag = 0
        AND w.id = @1
        LIMIT 1";
        return DBI::Prepare($sql)->FirstRow($pdfId)['api_key'];
    }
}
