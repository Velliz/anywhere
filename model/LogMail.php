<?php

namespace model;

use pukoframework\pda\DBI;

/**
 * Class LogMail
 * @package model
 */
class LogMail extends \plugins\model\logmail
{
    public static function Create($arrayData)
    {
        return DBI::Prepare('logmail')->Save($arrayData);
    }

    public static function Update($mailID, $dataUpdate)
    {
        return DBI::Prepare('logmail')->Update($mailID, $dataUpdate);
    }

    public static function GetLogMail($mailID)
    {
        return DBI::Prepare('SELECT * FROM logmail WHERE (mailID = @1);')
            ->GetData($mailID);
    }
}