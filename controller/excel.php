<?php
/**
 * Anywhere
 *
 * Anywhere is output-as-a-service (OAAS) platform.
 *
 * This content is released under the Apache License Version 2.0, January 2004
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Copyright (c) 2016, Didit Velliz
 *
 * @package    velliz/anywhere
 * @author    Didit Velliz
 * @link    https://github.com/velliz/anywhere
 * @since    Version 1.0.0
 *
 */

namespace controller;

use model\ExcelModel;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use plugins\auth\AnywhereAuthenticator;
use plugins\controller\AnywhereView;
use pukoframework\auth\Session;
use pukoframework\Framework;

/**
 * Class excel
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 */
class excel extends AnywhereView
{

    var $excelname = "";
    var $columnspecs = array();
    var $dataspecs = array();
    var $requesttype = "POST";

    /**
     * @throws \Exception
     */
    public function main()
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (!isset($session['ID'])) $this->RedirectTo(Framework::$factory->getBase());

        if ((int)$session['statusID'] == 1) {
            $result = ExcelModel::CountExcelUser($session['ID'])[0];
            if ((int)$result['result'] >= $this->GetAppConstant('LIMITATIONS')) $this->RedirectTo('limitations');
        }

        $snap_shoot = date('d-m-Y-His');

        $arrayData = array(
            'userID' => $session['ID'],
            'excelname' => 'EXCEL-' . $snap_shoot . '.xlsx',
            'columnspecs' => json_encode(array(
                array("key" => "nama", "display" => "Nama", "width" => 15, "column" => "A"),
                array("key" => "umur", "display" => "Umur", "width" => 15, "column" => "B"),
                array("key" => "dob", "display" => "Tempat, Tanggal Lahir", "width" => 15, "column" => "C"),
                array("key" => "hobi", "display" => "Hobi", "width" => 15, "column" => "D"),
                array("key" => "alamat", "display" => "Alamat", "width" => 15, "column" => "E")
            ), JSON_PRETTY_PRINT),
            'dataspecs' => json_encode(array(
                array("key" => "nama", "value" => array(
                    "Anywhere Wrapper", "Puko Framework", "PHP 7.3"
                )),
                array("key" => "umur", "value" => array(
                    12, 15, 14
                )),
                array("key" => "dob", "value" => array(
                    "Bandung, 23 januari 2009", "Bandung, 04 maret 2001", "Jakarta, 14 februari 1995"
                )),
                array("key" => "hobi", "value" => array(
                    "Coding", "Sleeping", "Shopping"
                )),
                array("key" => "alamat", "value" => array(
                    "JL Perintis Kemerdekaan No 19", "JL Perintis Kemerdekaan No 9", "JL Perintis Kemerdekaan No 43"
                )),
            ), JSON_PRETTY_PRINT),
            'requesttype' => 'POST',
        );

        $pdfID = ExcelModel::NewExcelPage($arrayData);
        $dataEXCEL = ExcelModel::GetExcelPage($pdfID)[0];

        $this->RedirectTo('update/' . $dataEXCEL['EXCELID']);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * #Auth session true
     */
    public function update($id)
    {
        $session = Session::Get(AnywhereAuthenticator::Instance())->GetLoginData();
        if (isset($_POST['excelid'])) {
            $arrayID = array('EXCELID' => $_POST['excelid']);
            $arrayData = array(
                'EXCELID' => $_POST['excelid'],
                'excelname' => $_POST['excelname'],
                'columnspecs' => $_POST['columnspecs'],
                'dataspecs' => $_POST['dataspecs'],
                'requesttype' => $_POST['requesttype'],
            );
            $resultUpdate = ExcelModel::UpdateExcelPage($arrayID, $arrayData);

            if ($resultUpdate) $this->RedirectTo(Framework::$factory->getBase() . 'beranda');
            $this->RedirectTo(Framework::$factory->getBase() . 'sorry');
        }

        $dataEXCEL = $session;

        $dataEXCEL['excel'] = ExcelModel::GetExcelPage($id);
        foreach ($dataEXCEL['excel'] as $key => $value) {
            $dataEXCEL['excel'][$key]['apikey'] = $session['apikey'];
            switch ($value['requesttype']) {
                case 'POST':
                    $dataEXCEL['excel'][$key]['POST'] = 'checked';
                    break;
                case 'URL':
                    $dataEXCEL['excel'][$key]['URL'] = 'checked';
                    break;
            }
        }

        return $dataEXCEL;
    }

    /**
     * @param $api_key
     * @param $excelId
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function render($api_key, $excelId)
    {
        $excelRender = ExcelModel::GetExcelRender($api_key, $excelId)[0];

        $this->excelname = $excelRender['excelname'];
        $this->columnspecs = json_decode($excelRender['columnspecs'], true);
        $this->dataspecs = json_decode($excelRender['dataspecs'], true);
        $this->requesttype = $excelRender['requesttype'];

        $excel = new Spreadsheet();
        $shit = $excel->getActiveSheet();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if ($this->requesttype === 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                header('Content-Type: application/json');
                die(json_encode($data));
            }
            $this->dataspecs = (array)json_decode($_POST['jsondata'], true);
        }

        if ($this->requesttype === 'URL') {
            throw new Exception('not supported for a moment');
        }

        foreach ($this->columnspecs as $key => $val) {
            $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
            $shit->setCellValue("{$val['column']}1", $val['display']);
            foreach ($this->dataspecs as $x => $y) {
                if ($y['key'] === $val['key']) {
                    foreach ($y['value'] as $pointer => $item)
                        $shit->setCellValue($val['column'] . ($pointer + 2), $item);
                }
            }
        }

        $invalidCharacters = $shit->getInvalidCharacters();
        $title = str_replace($invalidCharacters, '.', $this->excelname);
        $shit->setTitle($title);

        $writer = IOFactory::createWriter($excel, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header(sprintf('Content-Disposition: attachment; filename="%s.xlsx"', $title));
        $writer->save("php://output");

        exit();
    }

    /**
     * @param $api_key
     * @param $excelId
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * #Template html false
     */
    public function coderender($api_key, $excelId)
    {
        $excelRender = ExcelModel::GetExcelRender($api_key, $excelId)[0];

        $this->excelname = $excelRender['excelname'];
        $this->columnspecs = json_decode($excelRender['columnspecs'], true);
        $this->dataspecs = json_decode($excelRender['dataspecs'], true);
        $this->requesttype = $excelRender['requesttype'];

        $excel = new Spreadsheet();
        $shit = $excel->getActiveSheet();

        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Author: Anywhere 0.1");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        foreach ($this->columnspecs as $key => $val) {
            $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
            $shit->setCellValue("{$val['column']}1", $val['display']);
            foreach ($this->dataspecs as $x => $y) {
                if ($y['key'] === $val['key']) {
                    foreach ($y['value'] as $pointer => $item)
                        $shit->setCellValue($val['column'] . ($pointer + 2), $item);
                }
            }
        }

        $invalidCharacters = $shit->getInvalidCharacters();
        $title = str_replace($invalidCharacters, '.', $this->excelname);
        $shit->setTitle($title);

        $writer = IOFactory::createWriter($excel, "Xlsx");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header(sprintf('Content-Disposition: attachment; filename="%s.xlsx"', $title));
        $writer->save("php://output");

        exit();
    }


}