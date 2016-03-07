<?php

namespace Bixie\DevosClient;

use Bixie\DevosClient\Apitoken\Provider\ApitokenProviderInterface;

class Apitoken
{

	const HEADER_KEY_TOKEN = 'X-DEVOS-API-TOKEN';
	const REQUEST_KEY_TOKEN = '_api_token';
	const HEADER_KEY_SALT = 'X-DEVOS-API-SALT';
	const REQUEST_KEY_SALT = '_api_salt';
	const HEADER_KEY_USERNAME = 'X-DEVOS-API-USERNAME';
	const REQUEST_KEY_USERNAME = '_api_username';

    /**
     * @var ApitokenProviderInterface
     */
    protected $provider;

    /**
     * Constructor.
     *
     * @param ApitokenProviderInterface $provider
     */
    public function __construct(ApitokenProviderInterface $provider)
    {
        $this->provider = $provider;
    }

}
