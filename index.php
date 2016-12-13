<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('ROOT', __DIR__);
define('FILE', dirname(__FILE__));
define('BASE_URL', "http://" . $_SERVER['SERVER_NAME'] . "/anywhere/");
define('LIMITATIONS', 4);
require __DIR__ . '/vendor/autoload.php';
$framework = new \pukoframework\Framework();
$framework->RouteMapping(array(
    'register' => 'main/register',
    'login' => 'main/userlogin',
    'logout' => 'main/userlogout',
    'about' => 'main/about',
    'home' => 'main/home',
    'sorry' => 'main/sorry',
    'beranda' => 'users/beranda',
    'profil' => 'users/profil',
    'guide' => 'guide/main',
));
$framework->Start();