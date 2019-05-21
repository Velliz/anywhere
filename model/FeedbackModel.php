<?php

namespace model;

use plugins\model\feedback;
use pukoframework\pda\DBI;

/**
 * Class FeedbackModel
 * @package model
 */
class FeedbackModel extends feedback
{

    public static function Create($arrayData)
    {
        return DBI::Prepare('feedback')->Save($arrayData);
    }

    public static function Update($FeedID, $dataUpdate)
    {
        return DBI::Prepare('feedback')->Update($FeedID, $dataUpdate);
    }

    public static function GetFeedback($FeedID)
    {
        return DBI::Prepare('SELECT * FROM feedback WHERE (feedbackID = @1);')
            ->GetData($FeedID);
    }

}