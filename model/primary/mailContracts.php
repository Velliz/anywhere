<?php

namespace model\primary;

use Exception;
use plugins\model\primary\mail;
use pukoframework\pda\DBI;
use pukoframework\pda\ModelContracts;
use pukoframework\plugins\DataTables;
use pukoframework\plugins\Paginations;

/**
 * Class mailContracts
 * @package model
 */
class mailContracts extends mail implements ModelContracts
{

    public static function GetData()
    {
        $sql = "SELECT id, user_id, html, css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, request_sample, css_external
        FROM mail
        WHERE dflag = 0";
        return DBI::Prepare($sql)->GetData();
    }

    public static function GetById($id)
    {
        $sql = "SELECT id, user_id, html, css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, request_sample, css_external
        FROM mail
        WHERE dflag = 0 AND id = @1";
        return DBI::Prepare($sql)->FirstRow($id);
    }

    public static function IsExists($id)
    {
        $sql = "SELECT id FROM mail WHERE dflag = 0 AND id = @1;";
        $data = DBI::Prepare($sql)->GetData($id);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function IsExistsWhere($column, $value)
    {
        $sql = sprintf("SELECT id FROM mail WHERE dflag = 0 AND (%s = @1);", $column);
        $data = DBI::Prepare($sql)->GetData($value);
        if (sizeof($data) > 0) {
            return true;
        }
        return false;
    }

    public static function GetDataSize()
    {
        $sql = "SELECT COUNT(id) data FROM mail WHERE dflag = 0;";
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
        $sql = sprintf("SELECT COUNT(id) data FROM mail WHERE dflag = 0 %s;", $strings);
        $data = DBI::Prepare($sql)->FirstRow();
        return (int)$data['data'];
    }

    public static function GetLastData()
    {
        $sql = "SELECT id, user_id, html, css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, request_sample, css_external
        FROM mail
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
        $sql = sprintf("SELECT id, user_id, html, css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, request_sample, css_external
        FROM mail
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

        $sql = sprintf("SELECT id, user_id, html, css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, request_sample, css_external
        FROM mail
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
            "html", //2
            "css", //3
            "mail_name", //4
            "mail_address", //5
            "mail_password", //6
            "cc", //7
            "bcc", //8
            "reply_to", //9
            "host", //10
            "port", //11
            "smtp_auth", //12
            "smtp_secure", //13
            "request_type", //14
            "request_url", //15
            "request_sample", //16
            "css_external", //17
        ));

        $strings = "";
        foreach ($condition as $column => $values) {
            if ($column === '*') {
                $strings .= $values;
            } else {
                $strings .= sprintf(" AND (%s = '%s') ", $column, $values);
            }
        }

        $sql = sprintf("SELECT id, user_id, NULL AS html, NULL AS css, mail_name, mail_address, mail_password, cc, bcc, reply_to, host, port, smtp_auth, smtp_secure, request_type, request_url, NULL AS request_sample, css_external
        FROM mail
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

    public static function GetApiKeyById($idMail)
    {
        $sql = "SELECT u.api_key
        FROM mail m
        LEFT JOIN users u ON (m.user_id = u.id)
        WHERE m.dflag = 0
        AND m.id = @1
        LIMIT 1";
        return DBI::Prepare($sql)->FirstRow($idMail)['api_key'];
    }

    public static function GetMailRender($api_key, $mailId)
    {
        $sql = "SELECT * 
        FROM mail m
        LEFT JOIN users u ON (m.user_id = u.id)
        WHERE (u.api_key = @1) 
        AND (m.id = @2) 
        LIMIT 1;";
        return DBI::Prepare($sql)->FirstRow($api_key, $mailId);
    }
}
