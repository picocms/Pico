<?php
/**
 * Pico configuration from yaml file... waiting Pico 2.0!!!
 * 
 * @author  Luca Minopoli
 * @link    http://tokaytech.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */

use Symfony\Component\Yaml\Yaml ;

$yamlfile = $this->getConfigDir() . 'config.yaml';
if (file_exists($yamlfile)) {
	try {
		$config = Yaml::Parse($yamlfile);
                //echo "<pre>"; print_r($config); echo "</pre>";
	} catch (Exception $exception) {
		printf('ERROR!!! Unable to parse the config file: %s', $exception->getMessage());
	}
}



