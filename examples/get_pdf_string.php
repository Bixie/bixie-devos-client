<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

echo '<a href="../">Index</a><br>';
echo '<form method="get">domestic_parcel_number_nl: <input name="domestic_parcel_number_nl" value="'.@$_GET['domestic_parcel_number_nl'].'"/><button>Go!</button><form>';
if (!$domestic_parcel_number_nl = @$_GET['domestic_parcel_number_nl']){
	return;
}


//get label
$client = new DevosClient($config, true);

$response = $client->get('/api/shipment/pdf/{domestic_parcel_number_nl}', [
	'domestic_parcel_number_nl' => $domestic_parcel_number_nl,
	'string' => 1
]);

echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if ($pdfString = (string) $response->getResponseBody()) {

	var_dump($pdfString);

} else {
	echo $response->getError();
}
echo '</pre>';


