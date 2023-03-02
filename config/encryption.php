<?php return [
    'method' => 'AES-256-CBC',
    'key' => $_SERVER['ENCRYPTION_KEY'],
    'identifier' => 'anywhere',
    'cookies' => 'anywhere',
    'session' => 'anywhere',
    'expired' => 43800,
    'expiredText' => 'Login untuk melanjutkan',
    'errorText' => 'Anda tidak memiliki hak akses',
];
