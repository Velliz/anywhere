<?php

namespace controller\api;

use Exception;
use model\WordModel;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class word extends Service
{

    /**
     * @throws Exception
     */
    public function wordtemplate()
    {
        $id = Request::Post('id', null);
        if ($id == null) {
            throw new Exception('id not defined.');
        }

        $type = Request::Post('type', null);
        if ($type == null) {
            throw new Exception('type not defined.');
        }
        if (!$_FILES) {
            throw new Exception('attachment file not defined.');
        }

        $name = $_FILES['placeholderfile']['name'];
        $tmp_name = $_FILES['placeholderfile']['tmp_name'];

        $input = array(
            'placeholdername' => $name,
            'placeholderfile' => $tmp_name
        );

        $id = WordModel::UpdateWordPage(array('WORDID' => $id), $input);
        $data['Image'] = WordModel::GetWordAttribute($id);

        return $data;
    }

    /**
     * @param $id
     */
    public function placeholder($id)
    {
        $word = WordModel::GetWordPage($id)[0];
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        echo $word['placeholderfile'];
        die();
    }

}