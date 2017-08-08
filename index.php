<?php

include 'main.php';

use Bixie\DevosClient\DevosClient;

?>
<ul>
	<li><a href="examples/get_senders.php">Get Senders</a></li>
	<li><a href="examples/create_shipment.php">Create Shipment</a></li>
	<li><a href="examples/save_shipment.php">Save Shipment</a></li>
	<li><a href="examples/register_gls.php">Register GLS</a></li>
	<li><a href="examples/create_label.php">Create Label</a></li>
	<li><a href="examples/create_shipment_bulk.php">Create Shipments Bulk</a></li>
	<li><a href="examples/get_pdf_string.php">Get PDF string</a></li>
</ul>
<?php
$client = new DevosClient($config, true);
/**
 * Filter options
 * @var string $search
 * @var string $klantnummer
 * @var int    $sender_id
 * @var string $gls_customer_number
 * @var string $created_from
 * @var string $created_to
 * @var string $state (default > 0) SHIPMENTGLS_STATE_REMOVED = 0, SHIPMENTGLS_STATE_CREATED = 1, SHIPMENTGLS_STATE_SCANNED = 2
 * @var string $order
 * @var int    $dir
 * @var int    $limit
 */
$filter = [
	'sender_id' => 19,
	'state' => 1
];

$response = $client->get('/api/shipment', compact('filter'));

if ($responseData = $response->getData()) {
	echo '<pre>';
	echo print_r($responseData);
	echo '</pre>';

} else {
	echo $response->getError();
}