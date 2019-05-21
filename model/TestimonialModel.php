<?php

namespace model;

use plugins\model\testimonial;
use pukoframework\pda\DBI;

/**
 * Class TestimonialModel
 * @package model
 */
class TestimonialModel extends testimonial
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