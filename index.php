<?php
require 'config/anyconfig.php';
require __DIR__ . '/vendor/autoload.php';

use anywhere\Anywhere;
Anywhere::Setup(DEVELOPMENT)->Start();