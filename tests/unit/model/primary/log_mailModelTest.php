<?php

use PHPUnit\Framework\TestCase;
use pukoframework\config\Factory;
use pukoframework\Framework;

class log_mailModelTest extends TestCase
{

    protected $framework;

    protected function setUp()
    {
        //comment this if want to run tests
        $this->markTestIncomplete();

        $factory = array(
            'base' => $_SERVER['HTTP_HOST'],
            'root' => $_ENV['BASEDIR'],
            'start' => microtime(true)
        );
        $fo = new Factory($factory);
        $this->framework = new Framework($fo);
    }

    public function testGetData()
    {

    }

    public function testGetById()
    {

    }

    public function testIsExists()
    {

    }

    public function testIsExistsWhere()
    {

    }

    public function testGetDataSize()
    {

    }

    public function testGetDataSizeWhere()
    {

    }

    public function testGetLastData()
    {

    }

    public function testSearchData()
    {

    }

    public function testDataTable()
    {

    }
}