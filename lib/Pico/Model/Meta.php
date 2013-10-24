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
class Meta extends AbstractModel {
	public function __construct($rawData = null) {
		if ($rawData !== null) {
			$this->setRawData($rawData);
		}
	}

	public function setRawData($rawData) {
		$this->parseRawData($rawData);
	}
	
	public function getFormattedDate() {
		global $config;
		if (isset($this->data['date'])) {
			return date($config['date_format'], strtotime($this->data['date']));
		}
		return null;
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
				$this->set($key, trim($val));
			}
		}
	}
}