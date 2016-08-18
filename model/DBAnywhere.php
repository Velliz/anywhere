<?php
namespace model;

use anywhere\backdoor\Model;
use pukoframework\pda\DBI;

class DBAnywhere
{
    public static function GetUser($username, $password)
    {
        return DBI::Prepare("SELECT u.*, s.status FROM users u LEFT JOIN status s ON (s.ID = u.statusID) WHERE username = @1 AND password = @2 LIMIT 1;")
            ->GetData($username, $password);
    }

    public static function GetUserById($id)
    {
        return DBI::Prepare("SELECT u.*, s.status FROM users u LEFT JOIN status s ON (s.ID = u.statusID) WHERE u.ID = @1 LIMIT 1;")
            ->GetData($id);
    }

    public static function NewUser($arrayData)
    {
        return DBI::Prepare("users")->Save($arrayData);
    }

    public static function CountPDFUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM pdf WHERE userID = @1 LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewPdfPage($userID, $filename)
    {
        /*
        $path = FILE . '/storage/' . $userID;
        mkdir($path, 0777, true);

        file_put_contents($path . '/HTML-PDF-' . $filename . '.html', "<h1>Hello to Anywhere</h1>");
        file_put_contents($path . '/CSS-PDF-' . $filename . '.css', "<h1>Hello to Anywhere</h1>");
        */

        $arrayData = array(
            'userID' => $userID,
            'reportname' => 'PDF-' . $filename . '.pdf',
            'html' => 'HTML-PDF-' . $filename . '.html',
            'css' => 'CSS-PDF-' . $filename . '.css',
            'outputmode' => 'Inline',
            'paper' => 'A4',
            'requesttype' => 'POST',
        );

        return DBI::Prepare('pdf')->Save($arrayData);
    }

    public static function UpdatePdfPage($pdfID, $dataUpdate)
    {
        return DBI::Prepare('pdf')->Update($pdfID, $dataUpdate);
    }

    public static function GetPdfPage($pdfID)
    {
        return DBI::Prepare('SELECT * FROM pdf WHERE PDFID = @1 LIMIT 1;')
            ->GetData($pdfID);
    }

    public static function GetPdfLists($userID)
    {
        return DBI::Prepare('SELECT * FROM pdf WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetPdfRender($apikey, $pdfID)
    {
        return DBI::Prepare('SELECT * FROM pdf p LEFT JOIN users u ON (p.userID = u.ID)
        WHERE u.apikey = @1 AND p.PDFID = @2 LIMIT 1;')
            ->GetData($apikey, $pdfID);
    }
}