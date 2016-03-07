<?php

namespace Bixie\DevosClient\Apitoken\Provider;

use Bixie\DevosClient\Request\RequestParameters;

class RequestApitokenProvider implements ApitokenProviderInterface {
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $private_key;

	/**
	 * @var string
	 */
	protected $token;

	/**
	 * @var string
	 */
	protected $salt;

	/**
	 * @var bool
	 */
	protected $validated = false;

	/**
	 * Constructor.
	 * @param $name
	 * @param $private_key
	 */
	public function __construct ($name = '', $private_key = '') {
		$this->name = $name;
		$this->private_key = $private_key;
	}

	/**
	 * @return boolean
	 */
	public function isValidated () {
		return $this->validated;
	}

	/**
	 * @return string
	 */
	public function getName () {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName ($name) {
		$this->name = $name;
	}

	/**
	 * @param string $private_key
	 */
	public function setPrivateKey ($private_key) {
		$this->private_key = $private_key;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate (RequestParameters $params) {
		return sha1($this->getSalt() . $params->toTokenString() . $this->private_key);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validate (RequestParameters $params) {
		$this->validated = $this->token === $this->generate($params);
		return $this->validated;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setToken ($token) {
		$this->token = $token;
	}

	/**
	 * Sets a API salt to encode.
	 * @param string $salt
	 */
	public function setSalt ($salt) {
		$this->salt = $salt;
	}

	/**
	 * @return string
	 */
	public function getSalt () {
		if (!isset($this->salt)) {
			$this->salt = time() . uniqid();
		}
		return $this->salt;
	}



}
