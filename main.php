<?php

require __DIR__ . '/vendor/autoload.php';

if (!file_exists(__DIR__ . '/config.json')) {
	file_put_contents(__DIR__ . '/config.json', file_get_contents(__DIR__ . '/config.json.dist'));
}

$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);


