<?php

namespace plugins\model;

use pukoframework\pda\DBI;
use pukoframework\pda\Model;

/**
 * #Table pdf
 * #PrimaryKey PDFID
 */
class pdf extends Model
{


    /**
     * #Column PDFID int(11) not null auto_increment
     */
    var $PDFID = 0;

    /**
     * #Column userID int(11) not null
     */
    var $userID = 0;

    /**
     * #Column reportname varchar(255) not null
     */
    var $reportname = '';

    /**
     * #Column html longblob
     */
    var $html = null;

    /**
     * #Column css longblob
     */
    var $css = null;

    /**
     * #Column outputmode varchar(255) not null
     */
    var $outputmode = '';

    /**
     * #Column paper varchar(255) not null
     */
    var $paper = '';

    /**
     * #Column orientation varchar(30) not null
     */
    var $orientation = '';

    /**
     * #Column requesttype varchar(255) not null
     */
    var $requesttype = '';

    /**
     * #Column requesturl varchar(255) not null
     */
    var $requesturl = '';

    /**
     * #Column requestsample text not null
     */
    var $requestsample = '';

    /**
     * #Column cssexternal text
     */
    var $cssexternal = '';

}
