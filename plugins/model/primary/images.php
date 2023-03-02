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
 * #Table images
 * #PrimaryKey id
 */
class images extends Model
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
     * #Column user_id int(11) not null 
     */
    var $user_id = 0;

    /**
     * #Column image_name varchar(180)  
     */
    var $image_name = '';

    /**
     * #Column placeholder_name varchar(180)  
     */
    var $placeholder_name = '';

    /**
     * #Column placeholder_file longblob  
     */
    var $placeholder_file = null;

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
     * #Column request_type varchar(30)  
     */
    var $request_type = '';

    /**
     * #Column request_url text  
     */
    var $request_url = '';

    /**
     * #Column request_sample text  
     */
    var $request_sample = '';

    /**
     * #Column request_sample_name varchar(255)  
     */
    var $request_sample_name = '';

    /**
     * #Column request_sample_file longblob  
     */
    var $request_sample_file = null;


}
