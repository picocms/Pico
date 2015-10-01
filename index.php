<?php
require_once(__DIR__ . '/vendor/autoload.php');
$pico = new Pico(
    __DIR__,
    __DIR__ . '/config/',
    __DIR__ . '/plugins/',
    __DIR__ . '/themes/'
);
echo $pico->run();
