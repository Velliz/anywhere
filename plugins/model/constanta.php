<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table constanta
 * #PrimaryKey constID
 */
class constanta extends Model
{


    /**
     * #Column constID int(11) unsigned not null auto_increment
     */
    var $constID = 0;

    /**
     * #Column userID int(11) not null
     */
    var $userID = 0;

    /**
     * #Column uniquekey varchar(250) not null
     */
    var $uniquekey = '';

    /**
     * #Column constantaval text not null
     */
    var $constantaval = '';

}
