<?php

namespace Bixie\DevosClient;

use Bixie\DevosClient\Apitoken\Apitoken;
use Bixie\DevosClient\Apitoken\Provider\RequestApitokenProvider;
use Bixie\DevosClient\Request\RequestHeaders;
use Bixie\DevosClient\Request\RequestParameters;
use Bixie\DevosClient\Request\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Psr7\Uri;

class DevosClient {

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @var CookieJar
	 */
	protected $cookieJar;

	/**
	 * @var Client
	 */
	protected $apiToken;

	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * @var bool
	 */
	protected $debug;

	/**
	 * DevosClient constructor.
	 * @param      $config
	 * @param bool $debug
	 */
	public function __construct ($config, $debug = false) {
		$this->config = $config;

		$this->apiToken = new RequestApitokenProvider($this->config['api_username'], $this->config['api_secret']);
		$this->client = new Client(['base_uri' => $this->config['api_url']]);
		$this->debug = $debug;
	}

	/**
	 * @param string $url
	 * @param array $query
	 * @param array $headers
	 * @return Response Response from the service.
	 */
	public function get ($url, $query = [], $headers = []) {
		return $this->send('GET', $url, [], $query, $headers);
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @param array $query
	 * @param array $headers
	 * @return Response Response from the service.
	 */
	public function post ($url, $data = [], $query = [], $headers = []) {
		return $this->send('POST', $url, $data, $query, $headers);
	}

	/**
	 * @param string $url
	 * @param array $data
	 * @param array $query
	 * @param array $headers
	 * @return Response Response from the service.
	 */
	public function delete ($url, $data = [], $query = [], $headers = []) {
		return $this->send('DELETE', $url, $data, $query, $headers);
	}

	/**
	 * @param string $method
	 * @param string $url
	 * @param array  $data
	 * @param array $query
	 * @param array  $headers
	 * @return Response Response from the service.
	 */
	public function send ($method, $url, $data = [], $query = [], $headers = []) {

		if (preg_match('/\{(.*)\}/', $url, $match)) {
			if (isset($data[$match[1]])) {
				$url = preg_replace('/(\{.*\})/', $data[$match[1]], $url);
			}
			if (isset($query[$match[1]])) {
				$url = preg_replace('/(\{.*\})/', $query[$match[1]], $url);
			}
		}
		$query = (new RequestParameters($query));
		$query->add(['p' => $url]);

		$data = (new RequestParameters($data));

		try {
			$response = $this->client->request($method, '', [
				'query' => $query->all(),
				'form_params' => $data->all(),
				'headers' => $this->getHeaders($data, $query, $headers)->all(),
				'cookies' => $this->getCookies()
			]);

			return new Response($response);

		} catch (RequestException $e) {

			if ($e->hasResponse()) {
				return new Response($e->getResponse());
			}
			return new Response(new GuzzleResponse(500, [], null, ['reason_phrase' => $e->getMessage()]));

		} catch (\Exception $e) {

			return new Response(new GuzzleResponse(500, [], null, ['reason_phrase' => $e->getMessage()]));
		}

	}

	/**
	 * @return bool|CookieJar
	 */
	protected function getCookies () {
		if (!isset($this->cookieJar) && $this->debug) {
			$this->cookieJar = CookieJar::fromArray([
				'XDEBUG_SESSION' => 'PHPSTORM'
			], (new Uri($this->config['api_url']))->getHost());
		}
		return $this->debug ? $this->cookieJar : false;
	}

	/**
	 * @param RequestParameters $data
	 * @param RequestParameters $query
	 * @param array             $headers
	 * @return RequestHeaders
	 */
	protected function getHeaders (RequestParameters $data, RequestParameters $query, $headers = []) {
		$data->add($query->all());
		$headers[Apitoken::HEADER_KEY_TOKEN] = $this->apiToken->generate($data);
		$headers[Apitoken::HEADER_KEY_SALT] = $this->apiToken->getSalt();
		$headers[Apitoken::HEADER_KEY_USERNAME] = $this->apiToken->getName();
		return new RequestHeaders($headers);
	}

}