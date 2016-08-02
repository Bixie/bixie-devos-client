<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';

//get label
$client = new DevosClient($config, true);

$response = $client->get('/api/sender');

echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($responseData = $response->getData()) {

	echo json_encode($responseData, JSON_PRETTY_PRINT);

} else {
	echo $response->getError();
}
echo '</pre>';


