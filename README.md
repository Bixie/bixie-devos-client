# Bixie De Vosdiensten API-client

De Vos API client examples.

### Install

Use git/composer to install the client in a webroot.

```
git clone https://github.com/Bixie/bixie-devos-client .
composer install
```

Copy `config.php.dist` to `config.php` and fill in the correct values.

### Basic usage

```php
//set config
$config = [
    'api_url' => 'http://www.devosdiensten.nl/component/bix_devos/',
    'api_username' => 'xxxx',
    'api_secret' => 'xxxx'
];
//get client
$client = new DevosClient($config);

//get all shipments from sender
$filter = [
    'sender_id' => 19,
    'state' => 1
];
$response = $client->get('/api/shipment', compact('filter'));

//get data from response
if ($responseData = $response->getData()) {
    //handle data

} else {
    //errorhandling
    throw new \Exception($response->getError());
}
```

### Example data

Data for the examples can be found and changed in [examples/shipmentdata](examples/shipmentdata) and [examples/shipmentsdata](examples/shipmentsdata).
