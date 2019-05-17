<?php return [
    'const' => [
        'INSTALLED' => $_SERVER['INSTALLED'],
        'LIMITATIONS' => $_SERVER['LIMITATIONS'],
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'expired' => 100,
        'host' => 'localhost',
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => $_SERVER['SLACK'],
            'secure' => '',
            'username' => 'anywhere',
            'active' => false
        ],
        'hook' => [
            'url' => $_SERVER['HOOK'],
            'secure' => '',
            'username' => 'anywhere',
            'active' => false
        ]
    ]
];