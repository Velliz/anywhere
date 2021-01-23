<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table users
 * #PrimaryKey ID
 */
class users extends Model
{


    /**
     * #Column ID int(11) not null auto_increment
     */
    var $ID = 0;

    /**
     * #Column name varchar(255) not null
     */
    var $name = '';

    /**
     * #Column username varchar(255) not null
     */
    var $username = '';

    /**
     * #Column password varchar(255) not null
     */
    var $password = '';

    /**
     * #Column email varchar(255) not null
     */
    var $email = '';

    /**
     * #Column apikey varchar(255) not null
     */
    var $apikey = '';

    /**
     * #Column statusID int(11) not null
     */
    var $statusID = 0;

}
