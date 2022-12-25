<?php return [
    'const' => [
        'INSTALLED' => $_SERVER['INSTALLED'],
        'LIMITATIONS' => $_SERVER['LIMITATIONS']
    ],
    'cache' => [
        'kind' => 'MEMCACHED',
        'host' => $_SERVER['MEMCACHED_IP'],
        'port' => 11211,
    ],
    'logs' => [
        'slack' => [
            'url' => $_SERVER['SLACK_API'],
            'secure' => '',
            'username' => 'anywhere',
            'active' => $_SERVER['SLACK_API_STATUS']
        ],
        'hook' => [
            'url' => '',
            'secure' => '',
            'username' => 'anywhere',
            'active' => false
        ]
    ]
];
