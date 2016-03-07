<?php

require __DIR__ . '/vendor/autoload.php';

use Bixie\DevosClient\DevosClient;

if (!file_exists(__DIR__ . '/config.json')) {
	file_put_contents(__DIR__ . '/config.json', file_get_contents(__DIR__ . '/config.json.dist'));
}

$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);

$client = new DevosClient($config, true);

$response = $client->get('/api/shipment');

if ($responseData = $response->getData()) {

	var_dump($responseData);

} else {
	echo $response->getError();
}

