<?php

// load dependencies
if(is_file($f = __DIR__ . '/vendor/autoload.php')) {
    // local composer install
    require_once($f);
} elseif(is_file($f = __DIR__ . '/../../../vendor/autoload.php')) {
    // root composer install
    require_once($f);
} else {
    // composer needs install...
    die('Cannot find composer `/vendor/autoload.php` -- try `composer install`');
}

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
