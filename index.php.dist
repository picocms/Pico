<?php // @codingStandardsIgnoreFile
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/index.php.dist>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

// check PHP platform requirements
if (PHP_VERSION_ID < 50306) {
    die('Pico requires PHP 5.3.6 or above to run');
}
if (!extension_loaded('dom')) {
    die("Pico requires the PHP extension 'dom' to run");
}
if (!extension_loaded('mbstring')) {
    die("Pico requires the PHP extension 'mbstring' to run");
}

// load dependencies
require_once(__DIR__ . '/vendor/autoload.php');

// instance Pico
$pico = new Pico(
    __DIR__,    // root dir
    'config/',  // config dir
    'plugins/', // plugins dir
    'themes/'   // themes dir
);

// override configuration?
//$pico->setConfig(array());

// run application
echo $pico->run();
