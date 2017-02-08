<?php

namespace model;


use pukoframework\pda\DBI;

class FeedbackModel
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