<?php
define('HTTPDOCS', realpath(rtrim(__DIR__, '/')) . '/');
define('ROOT_DIR', realpath(HTTPDOCS . '../httpdocs-includes') . '/');

define('LIB_DIR', ROOT_DIR . 'lib/');
define('VENDOR_DIR', ROOT_DIR . 'vendor/');
define('PLUGINS_DIR', ROOT_DIR . 'plugins/');
define('THEMES_DIR', HTTPDOCS . 'themes/');
define('CONFIG_DIR', ROOT_DIR . 'config/');
define('CACHE_DIR', LIB_DIR . 'cache/');

require_once(VENDOR_DIR . 'autoload.php');

