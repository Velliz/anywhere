<?php return [
    'const' => [
        'INSTALLED' => false,
        'LIMITATIONS' => 10,
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'expired' => 100,
        'host' => 'localhost',
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => '',
            'secure' => '',
            'username' => 'anywhere-log',
            'active' => false
        ],
        'hook' => [
            'url' => '',
            'secure' => '',
            'username' => 'anywhere-log',
            'active' => false
        ]
    ]
];