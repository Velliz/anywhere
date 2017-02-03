<?php

namespace model;

use pukoframework\pda\DBI;

class TestimonialModel
{
    public static function Create($arrayData)
    {
        return DBI::Prepare('testimonial')->Save($arrayData);
    }

    public static function Update($testimonialID, $dataUpdate)
    {
        return DBI::Prepare('testimonial')->Update($testimonialID, $dataUpdate);
    }

    public static function GetLogMail($testimonialID)
    {
        return DBI::Prepare('SELECT * FROM testimonial WHERE (testimonialID = @1);')
            ->GetData($testimonialID);
    }

}