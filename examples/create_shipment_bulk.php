<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';

$client = new DevosClient($config, true);

$shipments = json_decode(file_get_contents('shipmentsdata.json'), true);

$response = $client->post('/api/shipment/createbulk', ['shipments' => $shipments]);



echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($responseData = $response->getData()) {
	foreach ($responseData['shipments'] as $shipment) {
		echo sprintf('<br><a href="%s">Label download</a><br>', $shipment['pdf_url']);
		echo sprintf('<a href="%s&string=1" target="_blank">Label inline</a><br>', $shipment['pdf_url']);

		echo json_encode($shipment, JSON_PRETTY_PRINT);

	}
} else {
	echo $response->getError();
}
echo '</pre>';


