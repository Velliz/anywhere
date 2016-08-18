<?php
define('ROOT', __DIR__);
define('BASE_URL', "http://" . $_SERVER['SERVER_NAME'] . "/anywhere/");
require __DIR__ . '/vendor/autoload.php';
$framework = new \pukoframework\Framework();
$framework->RouteMapping(array(
    'register' => 'main/register',
    'login' => 'main/userlogin',
    'logout' => 'main/userlogout',
    'about' => 'main/about',
    'home' => 'main/home',
    'beranda' => 'main/beranda',
    'limitations' => 'main/limitations',
    'sorry' => 'main/sorry',
));
$framework->Start();