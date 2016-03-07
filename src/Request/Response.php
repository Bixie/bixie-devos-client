<?php

namespace Bixie\DevosClient\Request;

use Psr\Http\Message\ResponseInterface;


class Response {
	/**
	 * @var ResponseInterface
	 */
	protected $response;

	/**
	 * Response constructor.
	 * @param ResponseInterface $response
	 */
	public function __construct (ResponseInterface $response) {
		$this->response = $response;
	}

	/**
	 * @return bool|mixed
	 */
	public function getData () {

		try {

			if ($this->response->getStatusCode() == 200) {
				return json_decode($this->response->getBody(), true);
			}

			return false;
		} catch (\Exception $e) {
			return false;
		}

	}

	public function getError () {
		return $this->response->getReasonPhrase();
	}


}