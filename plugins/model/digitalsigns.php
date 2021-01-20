<?php

namespace plugins\model;

use pukoframework\pda\Model;

/**
 * #Table digitalsigns
 * #PrimaryKey id
 */
class digitalsigns extends Model
{

    /**
     * #Column id int(11) not null
     */
    var $id = 0;

    /**
     * #Column created datetime not null
     */
    var $created = '';

    /**
     * #Column modified timestamp not null
     */
    var $modified = '';

    /**
     * #Column cuid int(11) not null
     */
    var $cuid = 0;

    /**
     * #Column muid int(11) not null
     */
    var $muid = 0;

    /**
     * #Column dflag tinyint(1) not null
     */
    var $dflag = 0;

    /**
     * #Column digitalsignhash varchar(200)
     */
    var $digitalsignhash = '';

    /**
     * #Column digitalsignsecure varchar(200)
     */
    var $digitalsignsecure = '';

    /**
     * #Column email varchar(250)
     */
    var $email = '';

    /**
     * #Column location varchar(180)
     */
    var $location = '';

    /**
     * #Column reason varchar(250)
     */
    var $reason = '';

}