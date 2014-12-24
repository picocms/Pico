<?php 
/**
 * Pico Configuration
 *
 * This is the configuration file for Pico. It comes loaded with the 
 *  default values, which can be found in the get_config() method of
 *  the Pico class (lib/pico.php).
 *
 * @author Gilbert Pellegrom
 * @link http://picocms.org
 * @license http://opensource.org/licenses/MIT
 * @version 0.8
 */

/*
 * Site title
 */
$config['site_title'] = 'Pico';

/*
 * Override base URL (e.g. http://example.com)
 */
$config['base_url'] = '';

// Set the theme (defaults to "default")
$config['theme'] = 'default';

// Set the PHP date format
$config['date_format'] = 'jS M Y';

/*
 * Twig settings
 * To enable Twig caching change the value of 'cache' to CACHE_DIR
 * Autoescape Twig vars
 * Enable Twig debug
 */
$config['twig_config'] = array(			
	'cache' => false,
	'autoescape' => false,
	'debug' => false
);

/*
 * Order pages by "alpha" or "date"
 */
$config['pages_order_by'] = 'alpha';	 

/*
 * Order pages "asc" or "desc"
 */
$config['pages_order'] = 'asc';			

/*
 * The pages excerpt length (in words)
 */
$config['excerpt_length'] = 50;			

/*
 * Custom configuration settings can be added, too.
 * The following example can be accessed with the
 * Twig variable {{ config.custom_setting }} in a theme
 */

// $config['custom_setting'] = 'Hello'; 	
