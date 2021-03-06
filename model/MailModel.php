<?php

namespace model;

use plugins\model\mail;
use pukoframework\pda\DBI;

/**
 * Class MailModel
 * @package model
 */
class MailModel extends mail
{

    public static function CountMailUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM mail WHERE (userID = @1) LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewMailPage($arrayData)
    {
        return DBI::Prepare('mail')->Save($arrayData);
    }

    public static function UpdateMailPage($pdfID, $dataUpdate)
    {
        return DBI::Prepare('mail')->Update($pdfID, $dataUpdate);
    }

    public static function GetMailPage($mailID)
    {
        return DBI::Prepare('SELECT * FROM mail WHERE (MAILID = @1) LIMIT 1;')
            ->GetData($mailID);
    }

    public static function GetMailLists($userID)
    {
        return DBI::Prepare('SELECT * FROM mail WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetMailRender($apikey, $mailID)
    {
        return DBI::Prepare('SELECT * FROM mail m LEFT JOIN users u ON (m.userID = u.ID)
        WHERE (u.apikey = @1) AND (m.MAILID = @2) LIMIT 1;')
            ->GetData($apikey, $mailID);
    }
}