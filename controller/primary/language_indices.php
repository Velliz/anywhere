<?php

namespace controller\primary;

use DateTime;
use Exception;
use model\primary\usersContracts;
use plugins\UserBearerData;
use pukoframework\middleware\Service;
use pukoframework\Request;

/**
 * #Template html false
 */
class language_indices extends Service
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
        if ($param['app_name'] === '') {
            throw new Exception($this->say('APP_NAME_REQUIRED'));
        }
        if ($param['identifier'] === '') {
            throw new Exception($this->say('IDENTIFIER_REQUIRED'));
        }
        if ($param['variables'] === '') {
            throw new Exception($this->say('VARIABLES_REQUIRED'));
        }
        if ($param['texts'] === '') {
            throw new Exception($this->say('TEXTS_REQUIRED'));
        }

        //validations: customize here

        //insert
        $language_indices = new \plugins\model\primary\language_indices();
        $language_indices->created = $this->GetServerDateTime();
        $language_indices->cuid = $this->user['id'];

        $language_indices->user_id = $this->user['id'];

        $language_indices->app_name = trim($param['app_name']);
        $language_indices->identifier = trim($param['identifier']);
        $language_indices->variables = trim($param['variables']);
        $language_indices->texts = trim($param['texts']);

        $language_indices->save();

        //response
        $data['language_indices'] = [
            'id' => $language_indices->id,
            'user' => usersContracts::GetById($language_indices->user_id),
            'app_name' => $language_indices->app_name,
            'identifier' => $language_indices->identifier,
            'variables' => $language_indices->variables,
            'texts' => $language_indices->texts,
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
        if ($param['app_name'] === '') {
            throw new Exception($this->say('APP_NAME_REQUIRED'));
        }
        if ($param['identifier'] === '') {
            throw new Exception($this->say('IDENTIFIER_REQUIRED'));
        }
        if ($param['variables'] === '') {
            throw new Exception($this->say('VARIABLES_REQUIRED'));
        }
        if ($param['texts'] === '') {
            throw new Exception($this->say('TEXTS_REQUIRED'));
        }

        //validations: customize here

        //update
        $language_indices = new \plugins\model\primary\language_indices($id);
        $language_indices->modified = $this->GetServerDateTime();
        $language_indices->muid = $this->user['id'];

        $language_indices->app_name = trim($param['app_name']);
        $language_indices->identifier = trim($param['identifier']);
        $language_indices->variables = trim($param['variables']);
        $language_indices->texts = trim($param['texts']);

        $language_indices->modify();

        //response
        $data['language_indices'] = [
            'id' => $language_indices->id,
            'user' => usersContracts::GetById($language_indices->user_id),
            'app_name' => $language_indices->app_name,
            'identifier' => $language_indices->identifier,
            'variables' => $language_indices->variables,
            'texts' => $language_indices->texts,
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
        $language_indices = new \plugins\model\primary\language_indices($id);
        $language_indices->modified = $this->GetServerDateTime();
        $language_indices->muid = $this->user['id'];
        //delete logic here
        $language_indices->dflag = 1;
        $language_indices->modify();

        return [
            'deleted' => true
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

        return \model\primary\language_indicesContracts::SearchDataPagination($keyword);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function search()
    {
        $keyword = [];

        $param = Request::JsonBody();
        //post addition filter here
        if (isset($param['user_id'])) {
            $keyword['user_id'] = $param['user_id'];
        }

        $data['language_indices'] = \model\primary\language_indicesContracts::SearchData($keyword);
        return $data;
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function table()
    {
        $keyword = [];

        //post addition filter here
        $keyword['user_id'] = $this->user['id'];

        return \model\primary\language_indicesContracts::GetDataTable($keyword);
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {
        $language_indices = new \plugins\model\primary\language_indices($id);

        //response
        $data['language_indices'] = [
            'id' => $language_indices->id,
            'user' => usersContracts::GetById($language_indices->user_id),
            'app_name' => $language_indices->app_name,
            'identifier' => $language_indices->identifier,
            'variables' => $language_indices->variables,
            'texts' => $language_indices->texts,

        ];

        return $data;
    }

}
