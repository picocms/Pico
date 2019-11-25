<?php // @codingStandardsIgnoreFile
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/index.php>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

// load dependencies
if (is_file(__DIR__ . '/vendor/autoload.php')) {
    // composer root package
    require_once(__DIR__ . '/vendor/autoload.php');
} elseif (is_file(__DIR__ . '/../../../vendor/autoload.php')) {
    // composer dependency package
    require_once(__DIR__ . '/../../../vendor/autoload.php');
} else {
    die(
        "Cannot find 'vendor/autoload.php'. If you're using a composer-based Pico install, run `composer install`. "
        . "If you're rather trying to use one of Pico's pre-built release packages, make sure to download Pico's "
        . "latest release package named 'pico-release-v*.tar.gz' (don't download a source code package)."
    );
}

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
