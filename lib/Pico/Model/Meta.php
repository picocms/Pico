<?php

namespace Pico\Model;

/**
 * Meta model
 *
 * @author Frank Nägler
 * @link http://pico.dev7studios.com
 * @license http://opensource.org/licenses/MIT
 * @version 0.1
 */
class Meta {
	protected $headers  = array();

	public function __construct($rawData = null) {
		if ($rawData !== null) {
			$this->parseRawData($rawData);
		}
	}

	public function setRawData($rawData) {
		$this->parseRawData($rawData);
	}
	
	public function get($key) {
		return (isset($this->headers[$key])) ? $this->headers[$key] : null;
	}

	public function getFormattedDate() {
		global $config;
		if (isset($this->headers['date'])) {
			return date($config['date_format'], strtotime($this->headers['date']));
		}
		return null;
	}
	
	public function __get($name) {
		return $this->get($name);
	}

	public function __call($name, $args) {
		if (strpos($name, 'get') !== false) {
			$name = substr($name, 3);
			return $this->get($name);
		}
	}

	protected function parseRawData($rawData) {
		$metaPart   = substr($rawData, 0, strpos($rawData, '*/'));
		if (strpos($metaPart, '/*') == 0) {
			$metaPart   = trim(substr($metaPart, 2));
			$headers    = explode("\n", $metaPart);
			foreach ($headers as $line) {
				$parts  = explode(':', $line);
				$key    = array_shift($parts);
				$val    = implode($parts);
				$this->headers[$key]    = trim($val);
			}
		}
	}
}