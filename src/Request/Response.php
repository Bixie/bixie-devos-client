<?php

namespace Bixie\DevosClient\Request;

use Psr\Http\Message\ResponseInterface;


class Response {
	/**
	 * @var ResponseInterface
	 */
	protected $response;
	/**
	 * @var string
	 */
	protected $reasonPhrase;

	/**
	 * Response constructor.
	 * @param ResponseInterface $response
	 */
	public function __construct (ResponseInterface $response) {
		$this->response = $response;
		$this->reasonPhrase = $response->getReasonPhrase();
	}

	public function getStatusCode () {
		return $this->response->getStatusCode();
	}

	public function getResponseBody () {
		return $this->response->getBody();
	}

	/**
	 * @return bool|mixed
	 */
	public function getData () {

		try {

			if (in_array($this->response->getStatusCode(), [200, 201])) {
				$data = json_decode($this->response->getBody(), true);
				if (isset($data['error'])) {
					$this->reasonPhrase = $data['error'];
					return false;
				}
				return $data;
			}

			return false;
		} catch (\Exception $e) {
			return false;
		}

	}

	public function getError () {
		return $this->reasonPhrase;
	}


}