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

}
