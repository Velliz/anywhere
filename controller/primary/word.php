<?php

namespace controller\primary;

use Exception;
use model\primary\wordContracts;
use plugins\UserBearerData;
use pukoframework\Framework;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class word extends Service
{

    use UserBearerData;

    /**
     * @throws Exception
     * #Auth bearer true
     */
    public function create()
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['word_name'] === '') {
            throw new Exception($this->say('WORD_NAME_REQUIRED'));
        }

        //validations: customize here
        $user_limitations = $this->user['status']['limitations'];
        if ($user_limitations === null) {
            $user_limitations = $this->GetAppConstant('LIMITATIONS');
        }
        $limit = wordContracts::GetDataSizeWhere([
            'user_id' => $this->user['id'],
        ]);
        if ($limit >= $user_limitations) {
            throw new Exception($this->say('QUOTA_LIMITATIONS'));
        }

        $word = new \plugins\model\primary\word();
        $word->created = $this->GetServerDateTime();
        $word->cuid = $this->user['id'];
        $word->user_id = $this->user['id'];
        $word->word_name = trim($param['word_name']);
        $word->word_template = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.word.docx');
        $word->request_sample = file_get_contents(Framework::$factory->getRoot() . '/assets/template/starter.word.json');
        $word->save();

        //response
        $data['word'] = [
            'id' => $word->id,
            'word_name' => $word->word_name,
            'request_sample' => $word->request_sample,
            'created' => $word->created,
            'modified' => $word->modified,
            'user_id' => $word->user_id,
        ];

        return $data;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * #Auth bearer true
     */
    public function update($id = '')
    {
        $param = Request::JsonBody();

        //validations: empty check
        if ($param['word_name'] === '') {
            throw new Exception($this->say('WORD_NAME_REQUIRED'));
        }

        //update
        $word = new \plugins\model\primary\word($id);
        $word->modified = $this->GetServerDateTime();
        $word->muid = $this->user['id'];

        $word->word_name = trim($param['word_name']);

        if (isset($param['request_sample'])) {
            $word->request_sample = $param['request_sample'];
        }

        $word->modify();

        //response
        $data['word'] = [
            'id' => $word->id,
            'word_name' => $word->word_name,
            'request_sample' => $word->request_sample,
            'created' => $word->created,
            'modified' => $word->modified,
            'user_id' => $word->user_id,
        ];

        return $data;
    }

    /**
     * @param string $id
     * @throws Exception
     * #Auth bearer true
     */
    public function delete($id = '')
    {
        $word = new \plugins\model\primary\word($id);
        $word->modified = $this->GetServerDateTime();
        $word->muid = $this->user['id'];

        $word->dflag = 1;
        $word->modify();

        //response
        return [
            'deleted' => true,
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    public function explore()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

        return wordContracts::SearchDataPagination($keyword);
    }

    public function search()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

        $data['word'] = wordContracts::SearchData($keyword);
    }

    /**
     * @return array
     * @throws Exception
     * #Auth bearer true
     */
    public function table()
    {
        $keyword = [];

        //post addition filter here
        $keyword['user_id'] = $this->user['id'];

        return wordContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $word = new \plugins\model\primary\word($id);

        //response
        $data['word'] = [
            'id' => $word->id,
            'word_name' => $word->word_name,
            'request_sample' => $word->request_sample,
            'created' => $word->created,
            'modified' => $word->modified,
            'user_id' => $word->user_id,
        ];

        return $data;
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update_word_template($id = '')
    {
        $word_template = Request::Files('word_template', '', true);
        if ($word_template->isError()) {
            throw new Exception($this->say('WORD_TEMPLATE_REQUIRED'));
        }

        $word = new \plugins\model\primary\word($id);
        $word->modified = $this->GetServerDateTime();
        $word->muid = $this->user['id'];

        $word->word_template = file_get_contents($word_template->getTmpName());

        $word->modify();

        //response
        $data['word'] = [
            'id' => $word->id,
            'word_name' => $word->word_name,
            'request_sample' => $word->request_sample,
            'created' => $word->created,
            'modified' => $word->modified,
            'user_id' => $word->user_id,
        ];
        return $data;
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public function download_word_template($id)
    {
        $word = new \plugins\model\primary\word($id);

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$word->word_name}.docx");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Cache-Control: must-revalidate");
        header("Expires: 0");
        header("Pragma: public");

        echo $word->word_template;
        exit;
    }

}
