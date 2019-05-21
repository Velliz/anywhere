<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table excel
 * #PrimaryKey EXCELID
 */
class excel extends Model
{

    
    /**
     * #Column EXCELID int(11) not null auto_increment
     */
    var $EXCELID = 0;

    /**
     * #Column userID int(11) not null 
     */
    var $userID = 0;

    /**
     * #Column excelname varchar(255) not null 
     */
    var $excelname = '';

    /**
     * #Column columnspecs text not null 
     */
    var $columnspecs = '';

    /**
     * #Column dataspecs text not null 
     */
    var $dataspecs = '';

    /**
     * #Column requesttype varchar(60) not null 
     */
    var $requesttype = '';


    public static function Create($data)
    {
        return DBI::Prepare('excel')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('excel')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM excel')->GetData();
    }

}