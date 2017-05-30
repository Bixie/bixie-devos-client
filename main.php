<?php

require __DIR__ . '/vendor/autoload.php';

if (!file_exists(__DIR__ . '/config.php')) {
	file_put_contents(__DIR__ . '/config.php', file_get_contents(__DIR__ . '/config.php.dist'));
}

$config = include __DIR__ . '/config.php';


