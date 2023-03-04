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
 * #Table log_excel
 * #PrimaryKey id
 */
class log_excel extends Model
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
     * #Column excel_id int(11) not null 
     */
    var $excel_id = 0;

    /**
     * #Column user_id int(11) not null 
     */
    var $user_id = 0;

    /**
     * #Column json_data text not null 
     */
    var $json_data = '';

    /**
     * #Column processing_time double  
     */
    var $processing_time = 0;


}
