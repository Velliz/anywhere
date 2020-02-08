<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * Class logpdf
 * @package plugins\model
 */
class logpdf extends Model
{


    /**
     * #Column logid int(11) not null auto_increment
     */
    var $logid = 0;

    /**
     * #Column PDFID int(11) not null
     */
    var $PDFID = 0;

    /**
     * #Column userid int(11) not null
     */
    var $userid = 0;

    /**
     * #Column sentat timestamp not null on update CURRENT_TIMESTAMP
     */
    var $sentat = null;

    /**
     * #Column jsondata text not null
     */
    var $jsondata = '';

    /**
     * #Column creatorinfo text
     */
    var $creatorinfo = '';

    /**
     * #Column processingtime double
     */
    var $processingtime = 0;


    public static function Create($data)
    {
        return DBI::Prepare('logpdf')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('logpdf')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM logpdf')->GetData();
    }

}