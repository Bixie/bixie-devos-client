<?php

namespace Bixie\DevosClient\Request;

use Symfony\Component\HttpFoundation\HeaderBag;

class RequestHeaders extends HeaderBag
{

	/**
	 * retruns array of headers for curl options
	 */
	public function toArray ()
	{
		$headers = [];
		foreach ($this->all() as $key => $values) {
			foreach ($values as $value) {
				$headers[] = $key.': '.$value;
			}
		}
		return $headers;
	}
}
