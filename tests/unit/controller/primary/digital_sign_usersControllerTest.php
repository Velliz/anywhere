<?php

use PHPUnit\Framework\TestCase;

class digital_sign_usersControllerTest extends TestCase
{

    use \pukoconsole\util\TestingToolkit;

    protected $bearer;
    protected $name;

    protected function setUp()
    {
        // 1. comment this if want to run tests and generate docs
        $this->markTestIncomplete();

        // 2. make sure phpunit.xml have valid <server name="BEARER" value="..."/>
        $this->bearer = $_SERVER['BEARER'];
        $this->name = "digital_sign_users";
    }

    public function testCreate()
    {
        // 3. modify the url if customized
        $url = "digital_sign_users/create";

        // 4. modify the data with required from database
        $data = array(
                    'id' => 0,
            'created' => null,
            'modified' => null,
            'cuid' => 0,
            'muid' => 0,
            'dflag' => 0,
            'user_id' => 0,
            'name' => '',
            'phone' => '',
            'email' => '',
            'type' => '',
            'ktp' => '',
            'npwp' => '',
            'address' => '',
            'city' => '',
            'province' => '',
            'gender' => '',
            'place_of_birth' => '',
            'date_of_birth' => '',
            'org_unit' => '',
            'work_unit' => '',
            'position' => '',
            'is_verified' => 0,
            'callback_url' => '',
            'is_speciment' => 0
                );

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "POST", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "POST",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);
    }

    public function testUpdate()
    {
        $url = "digital_sign_users/1/update";

        $data = array(
                    'id' => 0,
            'created' => null,
            'modified' => null,
            'cuid' => 0,
            'muid' => 0,
            'dflag' => 0,
            'user_id' => 0,
            'name' => '',
            'phone' => '',
            'email' => '',
            'type' => '',
            'ktp' => '',
            'npwp' => '',
            'address' => '',
            'city' => '',
            'province' => '',
            'gender' => '',
            'place_of_birth' => '',
            'date_of_birth' => '',
            'org_unit' => '',
            'work_unit' => '',
            'position' => '',
            'is_verified' => 0,
            'callback_url' => '',
            'is_speciment' => 0
                );

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "POST", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "POST",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);
    }

    public function testRead()
    {
        // get single
        $url = "digital_sign_users/1";
        $data = array();

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "GET", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "GET",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);

        // searching
        $url = "digital_sign_users/search";
        $data = array(
            //write search term here
            //'idunit' => 1,
        );

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "POST", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "GET",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);

        // select
        $url = "digital_sign_users/select";
        $data = array();

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "GET", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "GET",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);

        // data tables
        $url = "digital_sign_users/table";
        $data = array(
            // column specs
            'id',
            'name',
        );

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "POST",
            'dataType' => "DEF",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);
    }

    public function testDelete()
    {
        $url = "digital_sign_users/1/delete";

        $data = array();

        $response = $this->SendRequest($this->bearer, "{$_SERVER['HTTP_HOST']}{$url}", "GET", "JSON", $data);
        $this->assertNotNull($response);

        $docs = array(
            'name' => $this->name,
            'url' => $url,
            'method' => "GET",
            'dataType' => "JSON",
            'data' => $data,
        );
        $this->WriteDocs($docs, $response);
    }

}