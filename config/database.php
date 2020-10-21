<?php
$db['primary'] = [
    'dbType' => $_SERVER['DB_TYPE'],
    'host' => $_SERVER['DB_HOST'],
    'user' => $_SERVER['DB_USER'],
    'pass' => $_SERVER['DB_PASS'],
    'dbName' => $_SERVER['DB_NAME'],
    'port' => $_SERVER['DB_PORT']
];

return $db;