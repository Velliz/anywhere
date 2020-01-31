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

}