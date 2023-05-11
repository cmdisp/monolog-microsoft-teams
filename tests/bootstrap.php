<?php

if (!is_readable(__DIR__ . '/../vendor/autoload.php')) {
    exit(PHP_EOL . 'Run composer install first.' . PHP_EOL);
}

require_once __DIR__ . '/../vendor/autoload.php';
