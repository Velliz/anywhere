<?php

namespace controller;

use Exception;
use model\primary\log_wordContracts;
use model\primary\wordContracts;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use plugins\controller\AnywhereView;
use plugins\model\primary\log_word;

/**
 * Class word
 * @package controller
 *
 * #ClearOutput false
 * #Master master.html
 * #Value PageTitle Word Templates
 */
class word extends AnywhereView
{

    private $word_name;

    private $word_template;

    private $request_sample;

    /**
     * word constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $id_word
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function update($id_word)
    {
        $data['id_word'] = $id_word;
        $data['api_key'] = wordContracts::GetApiKeyById($id_word);

        return $data;
    }

    /**
     * @param $id_word
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function html($id_word)
    {
        $data['id_word'] = $id_word;
        $data['api_key'] = wordContracts::GetApiKeyById($id_word);

        return $data;

    }

    /**
     * @param $id_word
     * @return array
     *
     * #ClearOutput value false
     * #ClearOutput block false
     * #ClearOutput comment false
     * @throws Exception
     * #Master master-codes.html
     */
    public function style($id_word)
    {
        $data['id_word'] = $id_word;
        $data['api_key'] = wordContracts::GetApiKeyById($id_word);

        return $data;
    }

    /**
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function coderender($api_key, $wordId)
    {
        $wordRender = wordContracts::GetWordRender($api_key, $wordId);
        $this->word_name = $wordRender['word_name'];
        $this->word_template = $wordRender['word_template'];
        $this->request_sample = $wordRender['request_sample'];

        // 1. Write BLOB to temp file
        $tempInput = tempnam(sys_get_temp_dir(), 'tpl_') . '.docx';
        file_put_contents($tempInput, $this->word_template);

        // 2. Use TemplateProcessor
        $templateProcessor = new TemplateProcessor($tempInput);
        $data = json_decode($this->request_sample, true);

        // Scalar replacements
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $templateProcessor->setValue($key, $value);
            }
        }

        // Clone rows for array data
        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value[0]) && is_array($value[0])) {
                $firstSubKey = array_key_first($value[0]);
                $templateProcessor->cloneRow("$key.$firstSubKey", count($value));
                foreach ($value as $index => $row) {
                    $rowIndex = $index + 1;
                    foreach ($row as $subKey => $subValue) {
                        $templateProcessor->setValue("$key.$subKey#$rowIndex", $subValue);
                    }
                }
            }
        }

        // 3. Save to temp output file
        $tempOutput = tempnam(sys_get_temp_dir(), 'out_') . '.docx';
        $templateProcessor->saveAs($tempOutput);

        // 4. Load and stream using IOFactory
        $phpWord = IOFactory::load($tempOutput);
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$this->word_name}.docx");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Cache-Control: must-revalidate");
        header("Expires: 0");
        header("Pragma: public");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');

        // 5. Clean up
        unlink($tempInput);
        unlink($tempOutput);
        exit;
    }

    /**
     * #Template master false
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function render($api_key, $wordId)
    {
        $wordRender = wordContracts::GetWordRender($api_key, $wordId);
        $this->word_name = $wordRender['word_name'];
        $this->word_template = $wordRender['word_template'];

        $data['status'] = 'success';
        if (!isset($_POST['jsondata'])) {
            $data['status'] = 'failed';
            $data['reason'] = 'post data [jsondata] is not defined.';
            header('Content-Type: application/json');
            die(json_encode($data));
        }
        $this->request_sample = $_POST['jsondata'];

        // 1. Write BLOB to temp file
        $tempInput = tempnam(sys_get_temp_dir(), 'tpl_') . '.docx';
        file_put_contents($tempInput, $this->word_template);

        // 2. Use TemplateProcessor
        $templateProcessor = new TemplateProcessor($tempInput);
        $data = json_decode($this->request_sample, true);

        // Scalar replacements
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $templateProcessor->setValue($key, $value);
            }
        }

        // Clone rows for array data
        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value[0]) && is_array($value[0])) {
                $firstSubKey = array_key_first($value[0]);
                $templateProcessor->cloneRow("$key.$firstSubKey", count($value));
                foreach ($value as $index => $row) {
                    $rowIndex = $index + 1;
                    foreach ($row as $subKey => $subValue) {
                        $templateProcessor->setValue("$key.$subKey#$rowIndex", $subValue);
                    }
                }
            }
        }

        // 3. Save to temp output file
        $tempOutput = tempnam(sys_get_temp_dir(), 'out_') . '.docx';
        $templateProcessor->saveAs($tempOutput);

        //save logs
        $log_word = new log_word();
        $log_word->created = $this->GetServerDateTime();
        $log_word->cuid = $wordRender['user_id'];

        $log_word->word_id = $wordId;
        $log_word->user_id = $wordRender['user_id'];
        $log_word->sent_at = $this->GetServerDateTime();
        $log_word->json_data = json_encode($this->request_sample, true);
        $log_word->creator_info = $_POST['creator'] ?? null;
        $log_word->processing_time = 0;
        $log_word->save();
        //end save logs

        // 4. Load and stream using IOFactory
        $phpWord = IOFactory::load($tempOutput);
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename='{$this->word_name}.docx'");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Cache-Control: must-revalidate");
        header("Expires: 0");
        header("Pragma: public");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');

        // 5. Clean up
        unlink($tempInput);
        unlink($tempOutput);
        exit;
    }

    /**
     * @param $logID
     * @param $api_key
     * @param $wordId
     * @throws Exception
     */
    public function timelinerender($logID, $api_key, $wordId)
    {
        $wordRender = wordContracts::GetWordRender($api_key, $wordId);
        $logData = log_wordContracts::GetById($logID);
        $this->word_name = $wordRender['word_name'];
        $this->word_template = $wordRender['word_template'];

        $this->request_sample = $logData['json_data'];

        // 1. Write BLOB to temp file
        $tempInput = tempnam(sys_get_temp_dir(), 'tpl_') . '.docx';
        file_put_contents($tempInput, $this->word_template);

        // 2. Use TemplateProcessor
        $templateProcessor = new TemplateProcessor($tempInput);
        $data = json_decode($this->request_sample, true);

        // Scalar replacements
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $templateProcessor->setValue("!$key", $value);
            }
        }

        // Clone rows for array data
        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value[0]) && is_array($value[0])) {
                $firstSubKey = array_key_first($value[0]);
                $templateProcessor->cloneRow("!$key.$firstSubKey", count($value));
                foreach ($value as $index => $row) {
                    $rowIndex = $index + 1;
                    foreach ($row as $subKey => $subValue) {
                        $templateProcessor->setValue("!$key.$subKey#$rowIndex", $subValue);
                    }
                }
            }
        }

        // 3. Save to temp output file
        $tempOutput = tempnam(sys_get_temp_dir(), 'out_') . '.docx';
        $templateProcessor->saveAs($tempOutput);

        // 4. Load and stream using IOFactory
        $phpWord = IOFactory::load($tempOutput);
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename='{$this->word_name}.docx'");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Cache-Control: must-revalidate");
        header("Expires: 0");
        header("Pragma: public");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save('php://output');

        // 5. Clean up
        unlink($tempInput);
        unlink($tempOutput);
        exit;
    }

    /**
     * @param $id_word
     * @return array
     * @throws Exception
     * #Master master-codes.html
     */
    public function timeline($id_word)
    {
        $data['id_word'] = $id_word;
        $data['api_key'] = wordContracts::GetApiKeyById($id_word);

        return $data;
    }

}
