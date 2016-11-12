<?php
namespace model;

use pukoframework\pda\DBI;

class MailModel extends DBI
{

    public static function CountMailUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM mail WHERE userID = @1 LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewMailPage($userID, $filename)
    {
        $arrayData = array(
            'userID' => $userID,
            'reportname' => 'PDF-' . $filename . '.pdf',
            'html' => 'HTML-PDF-' . $filename . '.html',
            'css' => 'CSS-PDF-' . $filename . '.css',
            'outputmode' => 'Inline',
            'paper' => 'A4',
            'requesttype' => 'POST',
        );

        return DBI::Prepare('mail')->Save($arrayData);
    }

    public static function UpdateMailPage($pdfID, $dataUpdate)
    {
        return DBI::Prepare('mail')->Update($pdfID, $dataUpdate);
    }

    public static function GetMailPage($pdfID)
    {
        return DBI::Prepare('SELECT * FROM mail WHERE (EMAILID = @1) LIMIT 1;')
            ->GetData($pdfID);
    }

    public static function GetMailLists($userID)
    {
        return DBI::Prepare('SELECT * FROM mail WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetMailRender($apikey, $pdfID)
    {
        return DBI::Prepare('SELECT * FROM mail m LEFT JOIN users u ON (m.userID = u.ID)
        WHERE u.apikey = @1 AND m.EMAILID = @2 LIMIT 1;')
            ->GetData($apikey, $pdfID);
    }
}