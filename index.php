<?php

define('ROOT_DIR', realpath(dirname(__FILE__)) . '/');
define('LIB_DIR', ROOT_DIR . 'lib/');
define('VENDOR_DIR', ROOT_DIR . 'vendor/');
define('PLUGINS_DIR', ROOT_DIR . 'plugins/');
define('THEMES_DIR', ROOT_DIR . 'themes/');
define('CONFIG_DIR', ROOT_DIR . 'config/');
define('CACHE_DIR', LIB_DIR . 'cache/');

define('CONTENT_EXT', '.md');

require_once(VENDOR_DIR . 'autoload.php');
require_once(LIB_DIR . 'pico.php');
$pico = new Pico();
