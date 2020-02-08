<?php

use PHPUnit\Framework\TestCase;

class constantaControllerTest extends TestCase
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
        $this->name = "constanta";
    }

    public function testCreate()
    {
        // 3. modify the url if customized
        $url = "constanta/create";

        // 4. modify the data with required from database
        $data = array(
            'constID' => 0,
            'userID' => 0,
            'keys' => '',
            'values' => ''
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
        $url = "constanta/1/update";

        $data = array(
            'constID' => 0,
            'userID' => 0,
            'keys' => '',
            'values' => ''
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
        $url = "constanta/1";
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
        $url = "constanta/search";
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
        $url = "constanta/select";
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
        $url = "constanta/table";
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
        $url = "constanta/1/delete";

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