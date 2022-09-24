<?php
/**
 * --- DO NOT EDIT THIS FILE ---
 * This file is generated automatically
 * and will replaced automatically by pukoconsole
 */

namespace plugins\model\primary;

use pukoframework\pda\Model;

/**
 * #DatabaseType mysql
 * #Table status
 * #PrimaryKey id
 */
class status extends Model
{

    
    /**
     * #Column id int(11) not null auto_increment
     */
    var $id = 0;

    /**
     * #Column created datetime not null 
     */
    var $created = null;

    /**
     * #Column modified timestamp not null on update current_timestamp()
     */
    var $modified = null;

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
     * #Column status varchar(40) not null 
     */
    var $status = '';

    /**
     * #Column description varchar(250) not null 
     */
    var $description = '';

    /**
     * #Column limitations int(10) not null 
     */
    var $limitations = 0;


}
