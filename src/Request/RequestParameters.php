<?php

namespace Bixie\DevosClient\Request;

use Symfony\Component\HttpFoundation\ParameterBag;

class RequestParameters extends ParameterBag
{
	public function __construct (array $parameters) {
		parent::__construct($this->forceArray($parameters));
	}

	/**
	 * Create a string used to calculate the token.
	 *
	 * @return string
	 */
	public function toTokenString()	{
		$pairs = [];
		foreach ($this->getSortedKeys($this->all()) as $key) {
			$pairs[] = $key . ':' . json_encode($this->get($key, ''), JSON_NUMERIC_CHECK);
		}
		return implode('|', $pairs);
	}

	/**
	 * @param $array
	 * @return mixed
	 */
	protected function forceArray ($array) {
		//fix stdclass from json_array
		foreach ($array as &$value) {
			if (gettype($value) == 'object') {
				$value = (array) $value;
			}
			if (is_array($value)) {
				$value = $this->forceArray($value);
			}
		}
		return $array;
	}

	/**
	 * @param array $array
	 * @param array $keys
	 * @return array
	 */
	protected function getSortedKeys (array $array, $keys = []) {

		foreach ($array as $key => $value) {
			if (!empty($value) && !is_numeric($key) && !in_array($key, $keys)) {
				$keys[] = $key;
			}
			if (is_array($value)) {
				$keys = $this->getSortedKeys($value, $keys);
			}
		}
		sort($keys);
		return $keys;
	}
}
