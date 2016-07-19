<?php
define('FILE', dirname(__FILE__));
define('ROOT', 'https://hidden-beach-23274.herokuapp.com/');

define('DEVELOPMENT', 'DEV');
define('PRODUCTION', 'PROD');

ini_set("display_errors", "1");
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use anywhere\Anywhere;
Anywhere::Setup(DEVELOPMENT);