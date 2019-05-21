<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table testimonial
 * #PrimaryKey testimonialID
 */
class testimonial extends Model
{

    
    /**
     * #Column testimonialID int(11) not null auto_increment
     */
    var $testimonialID = 0;

    /**
     * #Column userID int(11) not null 
     */
    var $userID = 0;

    /**
     * #Column created datetime not null 
     */
    var $created = null;

    /**
     * #Column signature varchar(255) not null 
     */
    var $signature = '';

    /**
     * #Column subject varchar(255) not null 
     */
    var $subject = '';

    /**
     * #Column testimonial text not null 
     */
    var $testimonial = '';

    /**
     * #Column isvalid tinyint(4)  
     */
    var $isvalid = 0;

    /**
     * #Column validationdate datetime  
     */
    var $validationdate = null;


    public static function Create($data)
    {
        return DBI::Prepare('testimonial')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('testimonial')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM testimonial')->GetData();
    }

}