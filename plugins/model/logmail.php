<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table logmail
 * #PrimaryKey logid
 */
class logmail extends Model
{


    /**
     * #Column logid int(11) not null auto_increment
     */
    var $logid = 0;

    /**
     * #Column MAILID int(11) not null
     */
    var $MAILID = 0;

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
     * #Column resultdata text
     */
    var $resultdata = '';

    /**
     * #Column debuginfo text
     */
    var $debuginfo = '';

    /**
     * #Column processingtime double
     */
    var $processingtime = 0;

}
