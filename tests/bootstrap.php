<?php
$autoloader = __DIR__ . '/../vendor/autoload.php';

if (!is_readable($autoloader)) {
    die(PHP_EOL . "Missing Composer's vendor/autoload.php; run 'composer install' first." . PHP_EOL . PHP_EOL);
}

require_once $autoloader;
