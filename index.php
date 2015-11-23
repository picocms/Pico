<?php

$parent = '..' . DIRECTORY_SEPARATOR;
set_include_path(
    get_include_path() . PATH_SEPARATOR .
    $parent . $parent . $parent . PATH_SEPARATOR .
    '.'
);

// load dependencies
require_once('vendor/autoload.php');

// instance Pico
$pico = new Pico(
    __DIR__,    // root dir
    'config/',  // config dir
    'plugins/', // plugins dir
    'themes/'   // themes dir
);

// override configuration?
// $pico->setConfig(array());

// run application
echo $pico->run();
