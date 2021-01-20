<?php

namespace model;

use Exception;
use plugins\model\digitalsigns;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;

/**
 * Class DigitalSignUserModel
 * @package model
 */
class DigitalSignUserModel extends digitalsigns implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, userid, `name`, phone, email, `type`, ktp, npwp, address,
        city, province, gender, placeOfBirth, dateOfBirth, orgUnit,
        workUnit, `position`, isverified, isspeciment
        FROM digitalsignusers 
        WHERE (dflag = 0);";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, userid, `name`, phone, email, `type`, ktp, npwp, address,
        city, province, gender, placeOfBirth, dateOfBirth, orgUnit,
        workUnit, `position`, isverified, isspeciment
        FROM digitalsignusers 
        WHERE (dflag = 0) AND (id = @1);";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM digitalsignusers WHERE (dflag = 0) AND (id = @1);";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM digitalsignusers WHERE (dflag = 0) AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM digitalsignusers WHERE (dflag = 0);";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = array())
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM digitalsignusers WHERE (dflag = 0) %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, userid, `name`, phone, email, `type`, ktp, npwp, address,
        city, province, gender, placeOfBirth, dateOfBirth, orgUnit,
        workUnit, `position`, isverified, isspeciment
        FROM digitalsignusers 
        WHERE (dflag = 0) ORDER BY id DESC LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow();
    }

    public static function SearchData($keyword = array())
    {
        $strings = "";
        foreach ($keyword as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT id, userid, `name`, phone, email, `type`, ktp, npwp, address,
        city, province, gender, placeOfBirth, dateOfBirth, orgUnit,
        workUnit, `position`, isverified, isspeciment
        FROM digitalsignusers 
        WHERE (dflag = 0) %s;", $strings);
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetDataTable($condition = array())
    {
        $table = new DataTables(DataTables::POST);
        $table->SetColumnSpec(array(
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
            "placeOfBirth",
            "dateOfBirth",
            "orgUnit",
            "workUnit",
            "position",
            "isverified",
            "isspeciment",
            "userid",
            "id"
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT id, userid, `name`, phone, email, `type`, ktp, npwp, address,
        city, province, gender, placeOfBirth, dateOfBirth, orgUnit,
        workUnit, `position`, isverified, isspeciment
        FROM digitalsignusers 
        WHERE (dflag = 0) %s;", $strings);

        $table->SetQuery($sql);

        return $table->GetDataTables(function ($result) {
            foreach ($result as $key => $val) {
                $result[$key] = $val;
            }
            return $result;
        });
    }
}
