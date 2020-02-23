<?php return [
    'const' => [
        'INSTALLED' => true,
        'LIMITATIONS' => 9999,
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
            'username' => 'anywhere',
            'active' => false
        ],
        'hook' => [
            'url' => '',
            'secure' => '',
            'username' => 'anywhere',
            'active' => false
        ]
    ]
];