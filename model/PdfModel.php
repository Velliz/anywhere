<?php

namespace model;

use pukoframework\pda\DBI;

class PdfModel extends DBI
{
    public static function CountPDFUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM pdf WHERE userID = @1 LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewPdfPage($userID, $filename)
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