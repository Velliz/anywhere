<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table status
 * #PrimaryKey ID
 */
class status extends Model
{

    
    /**
     * #Column ID int(11) not null auto_increment
     */
    var $ID = 0;

    /**
     * #Column status varchar(255) not null 
     */
    var $status = '';


    public static function Create($data)
    {
        return DBI::Prepare('status')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('status')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM status')->GetData();
    }

}