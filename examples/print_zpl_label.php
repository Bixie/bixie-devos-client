<?php

include '../main.php';

use Bixie\DevosClient\DevosClient;

$ip = @$_GET['ip'] ? : '127.0.0.1';
$port = @$_GET['port'] ? : '9100';

echo '<a href="../">Index</a><br>';
echo '<form method="get">';
echo 'IP: <input name="ip" value="'.$ip.'"/><br>';
echo 'Port: <input name="port" value="'.$port.'"/><br>';
echo 'domestic_parcel_number_nl: <input name="domestic_parcel_number_nl" value="'.@$_GET['domestic_parcel_number_nl'].'"/><button>Go!</button><form>';
if (!$domestic_parcel_number_nl = @$_GET['domestic_parcel_number_nl']){
	return;
}


//get label
$client = new DevosClient($config, true);

$response = $client->get('/api/shipment/zpl/{domestic_parcel_number_nl}', [
	'domestic_parcel_number_nl' => $domestic_parcel_number_nl,
	'ip' => $ip,
	'port' => $port,
]);

echo '<pre>Statuscode: ' . $response->getStatusCode() . '<br>';
if (!$response->getData()) {

	echo $response->getError();
	
}
echo '</pre>';


