<?php

namespace model;

use plugins\model\images;
use pukoframework\pda\DBI;

/**
 * Class ImageModel
 * @package model
 */
class ImageModel extends images
{
    public static function CountImageUser($userID)
    {
        return DBI::Prepare('SELECT count(*) AS result FROM images WHERE (userID = @1) LIMIT 1;')
            ->GetData($userID);
    }

    public static function NewImagePage($arrayData, $binary = false)
    {
        return DBI::Prepare('images')->Save($arrayData, $binary);
    }

    public static function UpdateImagePage($imageID, $dataUpdate, $binary = false)
    {
        return DBI::Prepare('images')->Update($imageID, $dataUpdate, $binary);
    }

    public static function GetImagePage($imageID)
    {
        return DBI::Prepare('SELECT * FROM images WHERE (IMAGEID = @1) LIMIT 1;')
            ->GetData($imageID);
    }

    public static function GetImageAttribute($imageID)
    {
        return DBI::Prepare('SELECT IMAGEID, userID, imagename, h, w, x, y, x2, y2 FROM images WHERE (IMAGEID = @1) LIMIT 1;')
            ->GetData($imageID);
    }

    public static function GetImageLists($userID)
    {
        return DBI::Prepare('SELECT * FROM images WHERE userID = @1;')
            ->GetData($userID);
    }

    public static function GetImageRender($apikey, $imageID)
    {
        return DBI::Prepare('SELECT * FROM images i LEFT JOIN users u ON (i.userID = u.ID)
        WHERE (u.apikey = @1) AND (i.IMAGEID = @2) LIMIT 1;')
            ->GetData($apikey, $imageID);
    }
}