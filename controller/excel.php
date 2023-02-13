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

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use plugins\auth\AnywhereAuthenticator;
use pukoframework\auth\Session;
use pukoframework\Framework;
use pukoframework\middleware\View;

/**
 * Class excel
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 * #Value PageTitle Excel Template
 */
class excel extends View
{

    /**
     * @var string
     */
    var $excelname = "";

    /**
     * @var array
     */
    var $columnspecs = array();

    /**
     * @var array
     */
    var $dataspecs = array();

    /**
     * @var string
     */
    var $requesttype = "POST";

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * #Auth session true
     * #Master master-codes.html
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

            //$this->RedirectTo(Framework::$factory->getBase() . 'beranda');
            if (!$resultUpdate) {
                $this->RedirectTo(Framework::$factory->getBase() . 'sorry');
            }
        }

        $dataEXCEL = $session;

        $dataEXCEL['excel'] = ExcelModel::GetExcelPage($id);

        $dataEXCEL['PageTitle'] = $dataEXCEL['excel'][0]['excelname'];

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
        $mode = 1;

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

        $styleArray = array(
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        );

        $header = [];
        $footer = [];

        $idx = 1;

        if ($this->requesttype === 'POST') {
            $data['status'] = 'success';
            if (!isset($_POST['jsondata'])) {
                $data['status'] = 'failed';
                $data['reason'] = 'post data [jsondata] is not defined.';
                header('Content-Type: application/json');
                die(json_encode($data));
            }

            $decoded_data = (array)json_decode($_POST['jsondata'], true);
            if (isset($decoded_data['tables'])) {
                if (isset($decoded_data['header'])) {
                    $mode = 2;
                    $header = $decoded_data['header'];
                }
                if (isset($decoded_data['footer'])) {
                    $mode = 2;
                    $footer = $decoded_data['footer'];
                }

                $this->dataspecs = $decoded_data['tables'];
            } else {
                $this->dataspecs = $decoded_data;
            }
        }

        if ($this->requesttype === 'URL') {
            throw new Exception('not supported for a moment');
        }

        if ($mode === 1) {
            foreach ($this->columnspecs as $key => $val) {
                $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
                $shit->setCellValue("{$val['column']}1", $val['display']);
                $shit->getStyle("{$val['column']}1")->getFont()->setBold(true);
                $shit->getStyle("{$val['column']}1")->applyFromArray($styleArray);
                foreach ($this->dataspecs as $x => $y) {
                    if ($y['key'] === $val['key']) {
                        foreach ($y['value'] as $pointer => $item) {
                            $shit->setCellValue($val['column'] . ($pointer + 2), $item);
                            $shit->getStyle($val['column'] . ($pointer + 2))->applyFromArray($styleArray);
                        }
                    }
                }
            }
        }
        if ($mode === 2) {
            $shit->setCellValue("A{$idx}", $this->excelname);
            $shit->getStyle("A{$idx}:B{$idx}")->getFont()->setBold(true);

            $idx++;

            foreach ($header as $key => $val) {
                $shit->setCellValue("A{$idx}", $val['key']);
                $shit->setCellValue("B{$idx}", $val['value']);
                $idx++;
            }

            $idx++;

            foreach ($this->columnspecs as $key => $val) {
                $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
                $shit->setCellValue("{$val['column']}{$idx}", $val['display']);
                $shit->getStyle("{$val['column']}{$idx}")->getFont()->setBold(true);
                $shit->getStyle("{$val['column']}{$idx}")->applyFromArray($styleArray);
                foreach ($this->dataspecs as $x => $y) {
                    if ($y['key'] === $val['key']) {
                        foreach ($y['value'] as $pointer => $item) {
                            $shit->setCellValue($val['column'] . ($pointer + $idx + 1), $item);
                            $shit->getStyle($val['column'] . ($pointer + $idx + 1))->applyFromArray($styleArray);
                        }
                    }
                }
            }

            $idx = $idx + sizeof($this->columnspecs);

            foreach ($footer as $key => $val) {
                $shit->setCellValue("A{$idx}", $val['key']);
                $shit->setCellValue("B{$idx}", $val['value']);
                $idx++;
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
        $mode = 1;

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

        $styleArray = array(
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        );

        $header = [];
        $footer = [];

        $idx = 1;

        if (isset($this->dataspecs['tables'])) {
            if (isset($this->dataspecs['header'])) {
                $mode = 2;
                $header = $this->dataspecs['header'];
            }
            if (isset($this->dataspecs['footer'])) {
                $mode = 2;
                $footer = $this->dataspecs['footer'];
            }

            $this->dataspecs = $this->dataspecs['tables'];
        }

        if ($mode === 1) {
            foreach ($this->columnspecs as $key => $val) {
                $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
                $shit->setCellValue("{$val['column']}1", $val['display']);
                $shit->getStyle("{$val['column']}1")->getFont()->setBold(true);
                $shit->getStyle("{$val['column']}1")->applyFromArray($styleArray);
                foreach ($this->dataspecs as $x => $y) {
                    if ($y['key'] === $val['key']) {
                        foreach ($y['value'] as $pointer => $item) {
                            $shit->setCellValue($val['column'] . ($pointer + 2), $item);
                            $shit->getStyle($val['column'] . ($pointer + 2))->applyFromArray($styleArray);
                        }
                    }
                }
            }
        }
        if ($mode === 2) {
            $shit->setCellValue("A{$idx}", $this->excelname);
            $shit->getStyle("A{$idx}:B{$idx}")->getFont()->setBold(true);

            $idx++;

            foreach ($header as $key => $val) {
                $shit->setCellValue("A{$idx}", $val['key']);
                $shit->setCellValue("B{$idx}", $val['value']);
                $idx++;
            }

            $idx++;

            foreach ($this->columnspecs as $key => $val) {
                $shit->getColumnDimension($val['column'])->setWidth((int)$val['width']);
                $shit->setCellValue("{$val['column']}{$idx}", $val['display']);
                $shit->getStyle("{$val['column']}{$idx}")->getFont()->setBold(true);
                $shit->getStyle("{$val['column']}{$idx}")->applyFromArray($styleArray);
                foreach ($this->dataspecs as $x => $y) {
                    if ($y['key'] === $val['key']) {
                        foreach ($y['value'] as $pointer => $item) {
                            $shit->setCellValue($val['column'] . ($pointer + $idx + 1), $item);
                            $shit->getStyle($val['column'] . ($pointer + $idx + 1))->applyFromArray($styleArray);
                        }
                    }
                }
            }

            $idx = $idx + sizeof($this->columnspecs);

            foreach ($footer as $key => $val) {
                $shit->setCellValue("A{$idx}", $val['key']);
                $shit->setCellValue("B{$idx}", $val['value']);
                $idx++;
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
