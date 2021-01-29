<?php

if (!is_readable(__DIR__ . '/../vendor/autoload.php')) {
    die(PHP_EOL . "Missing Composer's vendor/autoload.php; run 'composer install' first." . PHP_EOL);
}

require_once __DIR__ . '/../vendor/autoload.php';
