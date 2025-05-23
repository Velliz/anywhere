<?php

namespace controller\primary;

use Exception;
use plugins\UserBearerData;
use pukoframework\middleware\Service;

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
    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     * @auth bearer true
     */
    public function update($id = '')
    {
    }

    /**
     * @param string $id
     * @throws Exception
     * @auth bearer true
     */
    public function delete($id = '')
    {

    }

    /**
     * @return array
     * @throws Exception
     */
    public function explore()
    {

    }

    public function search()
    {

    }

    /**
     * @return array
     * @throws Exception
     * #Auth bearer true
     */
    public function table()
    {

    }

    /**
     * @param string $id
     * @return mixed
     * @throws Exception
     */
    public function read($id = '')
    {

    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update_html($id = '')
    {

    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update_style($id = '')
    {

    }

}
