<?php

namespace model;

use plugins\model\excel;
use pukoframework\pda\DBI;

/**
 * Class ExcelModel
 * @package model
 */
class ExcelModel extends excel
{

    public static function CountExcelUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM excel WHERE userID = @1 LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewExcelPage($arrayData)
    {
        return DBI::Prepare('excel')->Save($arrayData);
    }

    public static function UpdateExcelPage($excelID, $dataUpdate)
    {
        return DBI::Prepare('excel')->Update($excelID, $dataUpdate);
    }

    public static function GetExcelPage($excelID)
    {
        return DBI::Prepare('SELECT * FROM excel WHERE EXCELID = @1 LIMIT 1;')
            ->GetData($excelID);
    }

    public static function GetExcelLists($userID)
    {
        return DBI::Prepare('SELECT * FROM excel WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetExcelRender($apikey, $excelID)
    {
        return DBI::Prepare('SELECT * FROM excel e LEFT JOIN users u ON (e.userID = u.ID)
        WHERE u.apikey = @1 AND e.EXCELID = @2 LIMIT 1;')
            ->GetData($apikey, $excelID);
    }

}