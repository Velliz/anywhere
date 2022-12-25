<?php
$db['primary'] = [
    'dbType' => 'mysql',
    'host' => $_SERVER['DB_HOST'],
    'user' => $_SERVER['DB_USER'],
    'pass' => $_SERVER['DB_PASS'],
    'dbName' => $_SERVER['DB_NAME'],
    'port' => $_SERVER['DB_PORT'],
    'driver' => '',
    'ignoreTableWithPrefix' => '_',
    'hideColumns' => [
        'created', 'modified', 'cuid', 'muid', 'dflag', 'password'
    ]
];

return $db;
