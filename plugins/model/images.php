<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table images
 * #PrimaryKey IMAGEID
 */
class images extends Model
{


    /**
     * #Column IMAGEID int(11) not null auto_increment
     */
    var $IMAGEID = 0;

    /**
     * #Column userID int(11) not null
     */
    var $userID = 0;

    /**
     * #Column imagename varchar(180)
     */
    var $imagename = '';

    /**
     * #Column placeholdername varchar(180)
     */
    var $placeholdername = '';

    /**
     * #Column placeholderfile longblob
     */
    var $placeholderfile = null;

    /**
     * #Column x double
     */
    var $x = 0;

    /**
     * #Column y double
     */
    var $y = 0;

    /**
     * #Column x2 double
     */
    var $x2 = 0;

    /**
     * #Column y2 double
     */
    var $y2 = 0;

    /**
     * #Column w double
     */
    var $w = 0;

    /**
     * #Column h double
     */
    var $h = 0;

    /**
     * #Column requesttype varchar(30)
     */
    var $requesttype = '';

    /**
     * #Column requesturl text
     */
    var $requesturl = '';

    /**
     * #Column requestsample text
     */
    var $requestsample = '';

    /**
     * #Column requestsamplename varchar(255)
     */
    var $requestsamplename = '';

    /**
     * #Column requestsamplefile longblob
     */
    var $requestsamplefile = null;

}
