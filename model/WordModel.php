<?php

namespace model;
use pukoframework\pda\DBI;

/**
 * Class WordModel
 * @package model
 */
class WordModel
{

    public static function CountWordUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM word WHERE userID = @1 LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewWordPage($arrayData, $binary = false)
    {
        return DBI::Prepare('word')->Save($arrayData, $binary);
    }

    public static function UpdateWordPage($wordID, $dataUpdate, $binary = false)
    {
        return DBI::Prepare('word')->Update($wordID, $dataUpdate, $binary);
    }

    public static function GetWordPage($wordID)
    {
        return DBI::Prepare('SELECT * FROM word WHERE WORDID = @1 LIMIT 1;')
            ->GetData($wordID);
    }

    public static function GetWordAttribute($wordID)
    {
        return DBI::Prepare('SELECT WORDID, userID, wordname, columnspecs, dataspecs, placeholdername, requesttype 
            FROM word WHERE WORDID = @1 LIMIT 1;')
            ->GetData($wordID);
    }

    public static function GetWordLists($userID)
    {
        return DBI::Prepare('SELECT WORDID, userID, wordname, columnspecs, dataspecs, placeholdername, requesttype
            FROM word WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetWordRender($apikey, $wordID)
    {
        return DBI::Prepare('SELECT * FROM word w LEFT JOIN users u ON (w.userID = u.ID)
        WHERE u.apikey = @1 AND w.WORDID = @2 LIMIT 1;')
            ->GetData($apikey, $wordID);
    }

}