<?php

namespace model\primary;

use Exception;
use plugins\model\primary\digital_signs;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class digital_signsContracts
 * @package model
 */
class digital_signsContracts extends digital_signs implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0 AND ds.id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM digital_signs WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM digital_signs WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM digital_signs WHERE dflag = 0;";
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
        $sql = sprintf("SELECT COUNT(id) data FROM digital_signs WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0
        ORDER BY ds.id DESC
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
        $sql = sprintf("SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0 
        %s;", $strings);
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

        $sql = sprintf("SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0 
        %s;", $strings);

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
            "document_name", //2
            "digital_sign_hash", //3
            "digital_sign_secure", //4
            "email", //5
            "location", //6
            "reason", //7
            "created", //8
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }

        $sql = sprintf("SELECT ds.id, ds.created, ds.user_id, ds.document_name, ds.digital_sign_hash, 
        ds.digital_sign_secure, ds.email, ds.location, ds.reason,
        dsu.is_verified, dsu.callback_url, dsu.is_speciment
        FROM digital_signs ds
        LEFT JOIN digital_sign_users dsu ON (ds.user_id = dsu.id AND dsu.dflag = 0)
        WHERE ds.dflag = 0 
        %s;", $strings);

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
