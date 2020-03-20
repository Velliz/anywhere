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
        return DBI::Prepare('SELECT logpdf.PDFID, logpdf.jsondata, pdf.reportname, logpdf.processingtime
        FROM logpdf
        LEFT JOIN pdf USING (PDFID)
        WHERE (logpdf.logid = @1);')
            ->GetData($logid);
    }

    /**
     * @param $PDFID
     * @return array
     * @throws \Exception
     */
    public static function GetPdfStats($PDFID)
    {
        return DBI::Prepare('SELECT logpdf.PDFID, pdf.reportname, COUNT(logpdf.PDFID) generated, logpdf.sentat lastprinted
        FROM logpdf
        LEFT JOIN pdf USING (PDFID)
        WHERE (logpdf.PDFID = @1)
        GROUP BY PDFID
        ORDER BY COUNT(logpdf.PDFID) DESC')
            ->GetData($PDFID);
    }

    /**
     * @param $PDFID
     * @param $startdate
     * @param $enddate
     * @return array
     * @throws \Exception
     */
    public static function GetPdfTimeline($PDFID, $startdate, $enddate)
    {
        return DBI::Prepare("SELECT logpdf.logid, logpdf.PDFID, pdf.reportname, logpdf.processingtime, logpdf.sentat
        FROM logpdf
        LEFT JOIN pdf USING (PDFID)
        WHERE logpdf.PDFID = @1
        AND DATE(logpdf.sentat) BETWEEN DATE(@2) AND DATE(@3)
        ORDER BY logpdf.logid DESC")
            ->GetData($PDFID, $startdate, $enddate);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function GetAllPopularity()
    {
        $sql = "SELECT logpdf.PDFID, pdf.reportname, COUNT(logpdf.PDFID) counter
        FROM logpdf
        LEFT JOIN pdf USING (PDFID)
        GROUP BY PDFID
        ORDER BY COUNT(logpdf.PDFID) DESC;";
        return DBI::Prepare($sql)->GetData();
    }
}