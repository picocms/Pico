<?php
require_once(__DIR__ . '/vendor/autoload.php');
$pico = new Pico(
    __DIR__,
    'config/',
    'plugins/',
    'themes/'
);
echo $pico->run();
