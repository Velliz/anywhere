<?php

namespace plugins\model;

use pukoframework\pda\Model;

/**
 * #Table digitalsignusers
 * #PrimaryKey id
 */
class digitalsignusers extends Model
{

    /**
     * #Column id int(11) not null
     */
    var $id = 0;

    /**
     * #Column userid int(11) not null
     */
    var $userid = 0;

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
     * #Column name varchar(180) not null
     */
    var $name = '';

    /**
     * #Column phone varchar(40)
     */
    var $phone = '';

    /**
     * #Column email varchar(180)
     */
    var $email = '';

    /**
     * #Column type varchar(60)
     */
    var $type = '';

    /**
     * #Column ktp varchar(20)
     */
    var $ktp = '';

    /**
     * #Colmn npwp varchar(20)
     */
    var $npwp = '';

    /**
     * #Column address varchar(200)
     */
    var $address = '';

    /**
     * #Column city varchar(100)
     */
    var $city = '';

    /**
     * #Column province varchar(100)
     */
    var $province = '';

    /**
     * #Column gender varchar(1) not null
     */
    var $gender = '';

    /**
     * #Column placeOfBirth varchar(100)
     */
    var $placeOfBirth = '';

    /**
     * #Column dateOfBirth varchar(10)
     */
    var $dateOfBirth = '';

    /**
     * #Column orgUnit varchar(50)
     */
    var $orgUnit = '';

    /**
     * #Column workUnit varchar(50)
     */
    var $workUnit = '';

    /**
     * #Column position varchar(100)
     */
    var $position = '';

    /**
     * #Column callbackurl varchar(250) not null
     */
    var $callbackurl = '';

    /**
     * #Column isverified tinyint(1)
     */
    var $isverified = 0;

    /**
     * #Column isspeciment tinyint(1)
     */
    var $isspeciment = 0;

}
