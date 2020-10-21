<?php return [
    'const' => [
        'INSTALLED' => $_SERVER['INSTALLED'],
        'LIMITATIONS' => $_SERVER['LIMITATIONS']
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'host' => 'localhost',
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => $_SERVER['SLACK'],
            'secure' => '',
            'username' => 'anywhere',
            'active' => $_SERVER['SLACK_ACTIVE']
        ],
        'hook' => [
            'url' => $_SERVER['HOOK'],
            'secure' => '',
            'username' => 'anywhere',
            'active' => $_SERVER['HOOK_ACTIVE']
        ]
    ]
];