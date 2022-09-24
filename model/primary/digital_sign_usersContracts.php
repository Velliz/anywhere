<?php

namespace model\primary;

use Exception;
use plugins\model\primary\digital_sign_users;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class digital_sign_usersContracts
 * @package model
 */
class digital_sign_usersContracts extends digital_sign_users implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM digital_sign_users WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM digital_sign_users WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM digital_sign_users WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM digital_sign_users WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
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
        $sql = sprintf("SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
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

        $sql = sprintf("SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
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
            "id",
            "user_id",
            "name",
            "phone",
            "email",
            "type",
            "ktp",
            "npwp",
            "address",
            "city",
            "province",
            "gender",
            "place_of_birth",
            "date_of_birth",
            "org_unit",
            "work_unit",
            "position",
            "is_verified",
            "callback_url",
            "is_speciment"
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, user_id, name, phone, email, type, ktp, npwp, address, city, province, gender, place_of_birth, date_of_birth, org_unit, work_unit, position, is_verified, callback_url, is_speciment
        FROM digital_sign_users
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
