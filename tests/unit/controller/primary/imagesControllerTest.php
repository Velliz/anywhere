<?php

use PHPUnit\Framework\TestCase;

class imagesControllerTest extends TestCase
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
        $this->name = "images";
    }

    public function testCreate()
    {
        // 3. modify the url if customized
        $url = "images/create";

        // 4. modify the data with required from database
        $data = array(
            'IMAGEID' => 0,
            'userID' => 0,
            'imagename' => '',
            'placeholdername' => '',
            'placeholderfile' => null,
            'x' => 0,
            'y' => 0,
            'x2' => 0,
            'y2' => 0,
            'w' => 0,
            'h' => 0,
            'requesttype' => '',
            'requesturl' => '',
            'requestsample' => '',
            'requestsamplename' => '',
            'requestsamplefile' => null
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
        $url = "images/1/update";

        $data = array(
            'IMAGEID' => 0,
            'userID' => 0,
            'imagename' => '',
            'placeholdername' => '',
            'placeholderfile' => null,
            'x' => 0,
            'y' => 0,
            'x2' => 0,
            'y2' => 0,
            'w' => 0,
            'h' => 0,
            'requesttype' => '',
            'requesturl' => '',
            'requestsample' => '',
            'requestsamplename' => '',
            'requestsamplefile' => null
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
        $url = "images/1";
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
        $url = "images/search";
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
        $url = "images/select";
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
        $url = "images/table";
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
        $url = "images/1/delete";

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