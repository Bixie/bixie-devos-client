<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';
echo '<form method="get">ID: <input name="id" value="'.@$_GET['id'].'"/><button>Go!</button><form>';
if (!$id = @$_GET['id']){
	return;
}


//get label
$client = new DevosClient($config, true);

$response = $client->post('/api/shipment/label/{id}', ['id' => $id]);

echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($responseData = $response->getData()) {

	echo sprintf('<a href="%s">PDF download</a><br>', $responseData['shipment']['pdf_url']);
	echo sprintf('<a href="%s&string=1" target="_blank">PDF inline</a><br>', $responseData['shipment']['pdf_url']);
	echo sprintf('<a href="%s" target="_blank">PNG inline</a><br>', $responseData['shipment']['png_url']);

	echo json_encode($responseData, JSON_PRETTY_PRINT);

} else {
	echo $response->getError();
}
echo '</pre>';


