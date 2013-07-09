<?php 

/*
// Override any of the default settings below:

$config['base_url'] = ''; 				// Override base URL (e.g. http://example.com)
$config['twig_config'] = array(			// Twig settings
	'cache' => false,					// To enable Twig caching change this to CACHE_DIR
	'autoescape' => false,				// Autoescape Twig vars
	'debug' => false					// Enable Twig debug
);
$config['excerpt_length'] = 50;			// The pages excerpt length (in words)

// To add a custom config setting:

$config['custom_setting'] = 'Hello'; 	// Can be accessed by {{ config.custom_setting }} in a theme

*/
$config['site_title'] = 'Rewdy';		// Site title
$config['theme'] = 'elliot'; 			// Set the theme (defaults to "default")
$config['date_format'] = 'F d, Y';		// Set the PHP date format

$config['pages_order_by'] = 'date';	// Order pages by "alpha" or "date"
$config['pages_order'] = 'desc';			// Order pages "asc" or "desc"

?>