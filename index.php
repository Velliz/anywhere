<?php

use Dotenv\Dotenv;
use pukoframework\Framework;
use pukoframework\config\Factory;

require 'vendor/autoload.php';

//spin up environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$protocol = 'http';
if (isset($_SERVER['HTTPS'])) {
    $protocol = 'https';
} else if (isset($_SERVER['HTTP_X_SCHEME'])) {
    $protocol = strtolower($_SERVER['HTTP_X_SCHEME']);
} else if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']);
} else if (isset($_SERVER['SERVER_PORT'])) {
    $serverPort = (int)$_SERVER['SERVER_PORT'];
    if ($serverPort == 80) {
        $protocol = 'http';
    } else if ($serverPort == 443) {
        $protocol = 'https';
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, Cache-Control, Authorization, If-Modified-Since, X-File-Size, X-Requested-With, X-File-Name, X-Permissions, X-Agen");

$factory = array(
    'cli_param' => null,
    'environment' => $_SERVER['ENVIRONMENT'],
    'base' => ($protocol . "://" . $_SERVER['HTTP_HOST'] . "/"),
    'root' => __DIR__,
    'start' => microtime(true)
);
$fo = new Factory($factory);

$framework = new Framework($fo);
$framework->Start();
