<?php
namespace model;

use pukoframework\pda\DBI;

class LogMail
{
    public static function Create($arrayData)
    {
        return DBI::Prepare('logmail')->Save($arrayData);
    }

    public static function Update($pdfID, $dataUpdate)
    {
        return DBI::Prepare('logmail')->Update($pdfID, $dataUpdate);
    }

    public static function GetLogMail($mailID)
    {
        return DBI::Prepare('SELECT * FROM logmail WHERE (mailID = @1);')
            ->GetData($mailID);
    }
}