<?php
$db['primary'] = [
    'dbType' => 'mysql',
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbName' => 'anywhere',
    'port' => 3306,
    'driver' => '',
    'ignoreTableWithPrefix' => '_',
    'hideColumns' => [
        'created', 'modified', 'cuid', 'muid', 'dflag', 'password'
    ]
];

return $db;
