<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';
echo '<form method="get">ID: <input name="id" value="'.@$_GET['id'].'"/><button>Go!</button><form>';
if (!$id = @$_GET['id']){
	return;
}


$client = new DevosClient($config, true);

$response = $client->post('/api/shipment/send/{id}', ['id' => $id]);


echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($responseData = $response->getData()) {

	$shipment = $responseData['shipment'];
	echo sprintf('domestic_parcel_number_nl: %s<br>', $shipment['domestic_parcel_number_nl']);


} else {
	echo $response->getError();
}
echo '</pre>';


