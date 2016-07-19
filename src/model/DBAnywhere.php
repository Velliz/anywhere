<?php
namespace anywhere\model;

use anywhere\backdoor\Data;
use anywhere\backdoor\Model;

class DBAnywhere extends Model
{
    public static function GetUser($username, $password)
    {
        return Data::From('SELECT u.*, s.status FROM users u LEFT JOIN status s ON (s.ID = u.statusID)
        WHERE username = @1 AND password = @2 LIMIT 1;')
            ->FetchAll($username, $password);
    }

    public static function NewUser($arrayData)
    {
        $model = new Model('users');
        return $model->Save($arrayData);
    }

    public static function CountPDFUser($userID)
    {
        return Data::From('SELECT count(*) AS result FROM pdf WHERE userID = @1 LIMIT 1;')
            ->FetchAll($userID);
    }

    public static function NewPdfPage($userID)
    {
        $model = new Model('pdf');
        $filename = date('d-m-Y-His');
        $arrayData = array(
            'userID' => $userID,
            'reportname' => 'PDF-' . $filename . '.pdf',
            'html' => 'HTML-PDF-' . $filename . '.html',
            'css' => 'CSS-PDF-' . $filename . '.css',
            'outputmode' => 'Inline',
            'paper' => 'A4',
            'requesttype' => 'POST',
        );

        $path = FILE . '/storage/' . $userID;
        mkdir($path, 0777, true);

        file_put_contents($path . '/HTML-PDF-' . $filename . '.html', "<h1>Hello to Anywhere</h1>");
        file_put_contents($path . '/CSS-PDF-' . $filename . '.css', "<h1>Hello to Anywhere</h1>");

        return $model->Save($arrayData);
    }

    public static function UpdatePdfPage($pdfID, $dataUpdate)
    {
        $model = new Model('pdf');
        return $model->Update($pdfID, $dataUpdate);
    }

    public static function GetPdfPage($pdfID)
    {
        return Data::From('SELECT * FROM pdf WHERE PDFID = @1 LIMIT 1;')
            ->FetchAll($pdfID);
    }

    public static function GetPdfLists($userID)
    {
        return Data::From('SELECT * FROM pdf WHERE userID = @1;')
            ->FetchAll($userID);
    }

    /**
     * @param $idMember
     * @return array
     *
     * @deprecated
     */
    public static function GetMemberByID($idMember)
    {
        return Data::From('SELECT * FROM member WHERE ID = @1')->FetchAll($idMember);
    }

    /**
     * @param $arrayMember
     * @return bool|string
     *
     * @deprecated
     */
    public static function AddMember($arrayMember)
    {
        $model = new Model('member');
        return $model->Save($arrayMember);
    }

    public static function GetPdfRender($apikey, $pdfID)
    {
        return Data::From('SELECT * FROM pdf p LEFT JOIN users u ON (p.userID = u.ID)
        WHERE u.apikey = @1 AND p.PDFID = @2 LIMIT 1;')
            ->FetchAll($apikey, $pdfID);
    }
}