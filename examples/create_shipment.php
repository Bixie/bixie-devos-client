<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';

$client = new DevosClient($config, true);

$shipment = json_decode(file_get_contents('shipmentdata.json'), true);

$response = $client->post('/api/shipment/create', ['data' => $shipment]);



echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($responseData = $response->getData()) {

	echo sprintf('<a href="%s">Label download</a><br>', $responseData['shipment']['pdf_url']);
	echo sprintf('<a href="%s&string=1" target="_blank">Label inline</a><br>', $responseData['shipment']['pdf_url']);

	echo json_encode($responseData, JSON_PRETTY_PRINT);
} else {
	echo $response->getError();
}
echo '</pre>';


