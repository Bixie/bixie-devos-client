<?php

include 'main.php';

use Bixie\DevosClient\DevosClient;

?>
<ul>
	<li><a href="examples/save_shipment.php">Save Shipment</a></li>
	<li><a href="examples/register_gls.php">Register GLS</a></li>
	<li><a href="examples/create_label.php">Create Label</a></li>
</ul>
<?php
$client = new DevosClient($config, true);

$response = $client->get('/api/shipment');

if ($responseData = $response->getData()) {
	echo '<pre>';
	echo print_r($responseData);
	echo '</pre>';

} else {
	echo $response->getError();
}

?>
