<?php
namespace anywhere\model;

use anywhere\backdoor\Data;
use anywhere\backdoor\Model;

class DBAnywhere extends Model
{
    public static function GetUser($username, $password)
    {
        return Data::From('SELECT u.*, s.`status` FROM `user` u LEFT JOIN `status` s ON (s.ID = u.statusID)
        WHERE `username` = @1 AND `password` = @2 LIMIT 1;')
            ->FetchAll($username, $password);
    }

    public static function NewUser($arrayData)
    {
        $model = new Model('user');
        return $model->Save($arrayData);
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
        return $model->Save($arrayData);
    }

    public static function UpdatePdfPage($pdfID, $dataUpdate)
    {
        $model = new Model('pdf');
        return $model->Update($pdfID, $dataUpdate);
    }

    public static function GetPdfPage($pdfID)
    {
        return Data::From('SELECT * FROM `pdf` WHERE `PDFID` = @1 LIMIT 1;')
            ->FetchAll($pdfID);
    }

    public static function GetPdfLists($userID)
    {
        return Data::From('SELECT * FROM `pdf` WHERE `userID` = @1;')
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
        return Data::From('SELECT * FROM `member` WHERE `ID` = @1')->FetchAll($idMember);
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
}