<?php

namespace Bixie\DevosClient\Apitoken\Provider;

use Bixie\DevosClient\Request\RequestParameters;

interface ApitokenProviderInterface
{
	/**
	 * Generates an API token.
	 * @param RequestParameters $params
	 * @return
	 */
    public function generate(RequestParameters $params);

    /**
     * Validates an API token.
     *
	 * @param RequestParameters $params
     * @return bool
     */
    public function validate(RequestParameters $params);

	/**
	 * Gets a API user name.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Sets a API user name.
	 *
	 * @param string $name
	 */
	public function setName($name);

	/**
	 * Sets a API key.
	 *
	 * @param string $private_key
	 */
	public function setPrivateKey($private_key);

	/**
     * Sets a API token to validate.
     *
     * @param string $token
     */
    public function setToken($token);

    /**
     * Sets a API salt to encode.
     *
     * @param string $salt
     */
    public function setSalt($salt);
}
