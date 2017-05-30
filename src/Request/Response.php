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
     * @var array|bool
     */
	protected $data;

	/**
	 * Response constructor.
	 * @param ResponseInterface $response
	 */
	public function __construct (ResponseInterface $response) {
		$this->response = $response;
		$this->reasonPhrase = $response->getReasonPhrase();
		$this->setData();
	}

	public function getStatusCode () {
		return $this->response->getStatusCode();
	}

	public function getResponseBody () {
		return $this->response->getBody();
	}

	/**
     * Set data when response is valid
	 */
	public function setData () {
        try {

            $this->data = false;

            $data = json_decode($this->response->getBody(), true);

            if (isset($data['error'])) {
                $this->reasonPhrase = isset($data['message']) ? $data['message'] : $data['error'];
                $this->response = $this->response->withStatus(400, $this->reasonPhrase);
            } elseif ($data && in_array($this->response->getStatusCode(), [200, 201])) {
                $this->data = $data;
            }
        } catch (\Exception $e) {
            $this->reasonPhrase = $e->getMessage();
            $this->data = false;
        }
	}

	/**
	 * @return bool|mixed
	 */
	public function getData () {
        return $this->data;
	}

	public function getError () {
		return $this->reasonPhrase;
	}


}