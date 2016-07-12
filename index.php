<?php
require __DIR__ . '/vendor/autoload.php';
require 'config/anyconfig.php';

use velliz\anywhere\Anywhere;

$address = explode('/', $_GET['query']);
Anywhere::Setup($address, DEVELOPMENT)->Start();

?>