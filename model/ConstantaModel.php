<?php

namespace model;

use plugins\model\constanta;

use pukoframework\pda\DBI;

/**
 * Class ConstantaModel
 * @package model
 * #Value title Manage Constant
 */
class ConstantaModel extends constanta
{

    /**
     * @param $userID
     * @return array
     * @throws \Exception
     */
    public static function GetCollection($userID)
    {
        $sql = "SELECT * FROM constanta WHERE userID = @1;";
        $result = DBI::Prepare($sql)->GetData($userID);
        return $result;
    }

    public static function IsKeyExists($userID, $key)
    {
        $sql = "SELECT * FROM constanta WHERE userID = @1 AND uniquekey = @2;";
        $result = DBI::Prepare($sql)->GetData($userID, $key);
        return count($result) > 0;
    }

}