<?php

namespace model\primary;

use Exception;
use plugins\model\primary\users;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class usersContracts
 * @package model
 */
class usersContracts extends users implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, status_id, name, username, email, api_key
        FROM users
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, status_id, name, username, email, api_key
        FROM users
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM users WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM users WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM users WHERE dflag = 0;";
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
        $sql = sprintf("SELECT COUNT(id) data FROM users WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, status_id, name, username, email, api_key
        FROM users
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
        $sql = sprintf("SELECT id, status_id, name, username, email, api_key
        FROM users
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

        $sql = sprintf("SELECT id, status_id, name, username, email, api_key
        FROM users
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
            "status_id", //1
            "name", //2
            "username", //3
            "email", //4
            "api_key", //5
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }

        $sql = sprintf("SELECT id, status_id, name, username, email, api_key
        FROM users
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

    /**
     * @param $username
     * @param $password
     * @return mixed|null
     * @throws Exception
     */
    public static function GetUser($username, $password)
    {
        $sql = "SELECT u.*, 
        s.status, s.limitations 
        FROM users u 
        LEFT JOIN status s ON (s.id = u.status_id) 
        WHERE (u.dflag = 0)
        AND (u.username = @1) AND (u.password = @2) 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($username, $password);
    }

    public static function UserIdByApiKey($api_key)
    {
        $sql = "SELECT id
        FROM users
        WHERE (dflag = 0)
        AND (apikey = @1);";
        $data = DBI::Prepare($sql)->FirstRow($api_key);
        return $data['id'];
    }
}
