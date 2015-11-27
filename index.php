<?php

// check PHP version
if (version_compare(PHP_VERSION, '5.3.6', '<')) {
    die('Sorry, Pico requires PHP 5.3.6 or above to run!');
}

// load dependencies
if(is_file(__DIR__ . '/vendor/autoload.php')) {
    // composer root package
    require_once(__DIR__ . '/vendor/autoload.php');
} elseif(is_file(__DIR__ . '/../../../vendor/autoload.php')) {
    // composer dependency package
    require_once(__DIR__ . '/../../../vendor/autoload.php');
} else {
    die("Cannot find `vendor/autoload.php`. Run `composer install`.");
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
