<?php
//todo : bersihan penggunaan ini
define('FILE', dirname(__FILE__));
define('ROOT', 'http://localhost/anywhere');

define('DEVELOPMENT', 'DEV');
define('PRODUCTION', 'PROD');

require __DIR__ . '/vendor/autoload.php';

use anywhere\Anywhere;
Anywhere::Setup(DEVELOPMENT)->Start();