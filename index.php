<?php
// ini_set('display_errors',1); 
// error_reporting(E_ALL);

/*
 * Pico v0.1
 */

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('CONTENT_DIR', ROOT_DIR .'content/');
define('LIB_DIR', ROOT_DIR .'lib/');
define('THEMES_DIR', ROOT_DIR .'themes/');
define('CACHE_DIR', LIB_DIR .'cache/');

require('config.php');
require(LIB_DIR .'Michelf/Markdown.php');
require(LIB_DIR .'Michelf/MarkdownExtra.php');
require(LIB_DIR .'Twig/Autoloader.php');
require(LIB_DIR .'gilbitron/Pico.php');
$pico = new Pico();

?>