<?php

namespace model;

use pukoframework\pda\DBI;

/**
 * Class LogPdf
 * @package model
 */
class LogPdf extends \plugins\model\logpdf
{

    /**
     * @param $arrayData
     * @return bool|string
     * @throws \Exception
     */
    public static function Create($arrayData)
    {
        return DBI::Prepare('logpdf')->Save($arrayData);
    }

    /**
     * @param $logid
     * @param $dataUpdate
     * @return bool
     * @throws \Exception
     */
    public static function Update($logid, $dataUpdate)
    {
        return DBI::Prepare('logpdf')->Update($logid, $dataUpdate);
    }

    /**
     * @param $logid
     * @return array
     * @throws \Exception
     */
    public static function GetLogPdf($logid)
    {
        return DBI::Prepare('SELECT * FROM logpdf WHERE ($logid = @1);')
            ->GetData($logid);
    }

    /**
 * @param $pdfID
 * @return mixed|null
 * @throws \Exception
 */
    public static function GetStats($pdfID)
    {
        $sql = "SELECT COUNT(logid) generated, DATE(sentat) lastprinted
        FROM logpdf 
        WHERE (PDFID = @1)
        GROUP BY PDFID
        ORDER BY sentat DESC;";
        return DBI::Prepare($sql)->FirstRow($pdfID);
    }
}