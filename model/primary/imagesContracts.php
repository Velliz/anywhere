<?php

namespace model\primary;

use Exception;
use plugins\model\primary\images;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class imagesContracts
 * @package model
 */
class imagesContracts extends images implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, image_name, placeholder_name, placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, request_sample_file
        FROM images
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, image_name, placeholder_name, placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, request_sample_file
        FROM images
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM images WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM images WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM images WHERE dflag = 0;";
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetDataSizeWhere($condition = [])
    {
        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }
        $sql = sprintf("SELECT COUNT(id) data FROM images WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, image_name, placeholder_name, placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, request_sample_file
        FROM images
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
        $sql = sprintf("SELECT id, user_id, image_name, placeholder_name, placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, request_sample_file
        FROM images
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

        $sql = sprintf("SELECT id, user_id, image_name, placeholder_name, placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, request_sample_file
        FROM images
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
            "image_name", //2
            "placeholder_name", //3
            "x", //4
            "y", //5
            "x2", //6
            "y2", //7
            "w", //8
            "h", //9
            "request_type", //10
            "request_url", //11
            "request_sample", //12
            "request_sample_name", //13
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
        }

        $sql = sprintf("SELECT id, user_id, image_name, placeholder_name, NULL AS placeholder_file, x, y, x2, y2, w, h, request_type, request_url, request_sample, request_sample_name, NULL AS request_sample_file
        FROM images
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

    public static function GetApiKeyById($idImage)
    {
        $sql = "SELECT u.api_key
        FROM images i
        LEFT JOIN users u ON (i.user_id = u.id)
        WHERE i.dflag = 0
        AND i.id = @1
        LIMIT 1";
        return DBI::Prepare($sql)->FirstRow($idImage)['api_key'];
    }

    public static function GetImageRender($api_key, $imageId)
    {
        $sql = "SELECT * 
        FROM images i 
        LEFT JOIN users u ON (i.user_id = u.id)
        WHERE (u.api_key = @1) 
        AND (i.id = @2) 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($api_key, $imageId);
    }
}
