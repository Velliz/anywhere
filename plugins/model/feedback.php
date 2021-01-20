<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table feedback
 * #PrimaryKey feedbackID
 */
class feedback extends Model
{


    /**
     * #Column feedbackID int(11) not null auto_increment
     */
    var $feedbackID = 0;

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
     * #Column feedback text not null
     */
    var $feedback = '';

    /**
     * #Column isapproved tinyint(1)
     */
    var $isapproved = 0;

    /**
     * #Column approveddate datetime
     */
    var $approveddate = null;

    /**
     * #Column feedbackresponds text
     */
    var $feedbackresponds = '';

}
