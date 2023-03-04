<?php

namespace model\primary;

use Exception;
use plugins\model\primary\log_mail;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class log_mailContracts
 * @package model
 */
class log_mailContracts extends log_mail implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM log_mail WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM log_mail WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM log_mail WHERE dflag = 0;";
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
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }
        $sql = sprintf("SELECT COUNT(id) data FROM log_mail WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
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
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }
        $sql = sprintf("SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
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
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }

        $sql = sprintf("SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
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
            "mail_id", //1
            "user_id", //2
            "sent_at", //3
            "json_data", //4
            "result_data", //5
            "debug_info", //6
            "processing_time", //7
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }

        $sql = sprintf("SELECT id, mail_id, user_id, sent_at, json_data, result_data, debug_info, processing_time
        FROM log_mail
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
}
