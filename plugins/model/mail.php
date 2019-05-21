<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table mail
 * #PrimaryKey MAILID
 */
class mail extends Model
{

    
    /**
     * #Column MAILID int(11) not null auto_increment
     */
    var $MAILID = 0;

    /**
     * #Column userID int(11) not null 
     */
    var $userID = 0;

    /**
     * #Column html text  
     */
    var $html = '';

    /**
     * #Column css text  
     */
    var $css = '';

    /**
     * #Column mailname varchar(255) not null 
     */
    var $mailname = '';

    /**
     * #Column mailaddress varchar(255)  
     */
    var $mailaddress = '';

    /**
     * #Column mailpassword varchar(255)  
     */
    var $mailpassword = '';

    /**
     * #Column cc varchar(255)  
     */
    var $cc = '';

    /**
     * #Column bcc varchar(255)  
     */
    var $bcc = '';

    /**
     * #Column replyto varchar(255)  
     */
    var $replyto = '';

    /**
     * #Column host varchar(255) not null 
     */
    var $host = '';

    /**
     * #Column port int(8) not null 
     */
    var $port = 0;

    /**
     * #Column smtpauth varchar(20) not null 
     */
    var $smtpauth = '';

    /**
     * #Column smtpsecure varchar(20) not null 
     */
    var $smtpsecure = '';

    /**
     * #Column requesttype varchar(20) not null 
     */
    var $requesttype = '';

    /**
     * #Column requesturl varchar(155) not null 
     */
    var $requesturl = '';

    /**
     * #Column requestsample text  
     */
    var $requestsample = '';

    /**
     * #Column cssexternal text  
     */
    var $cssexternal = '';


    public static function Create($data)
    {
        return DBI::Prepare('mail')->Save($data);
    }

    public static function Update($where, $data)
    {
        return DBI::Prepare('mail')->Update($where, $data);
    }

    public static function GetAll()
    {
        return DBI::Prepare('SELECT * FROM mail')->GetData();
    }

}