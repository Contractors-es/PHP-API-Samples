<?php

require_once __DIR__ . '/vendor/autoload.php';

use ContractorsEs\Api\Api;
use ContractorsEs\Api\ApiRequestException;

$api = new Api("https://demo.contractors.es", "admin", "admin", "en");
$countries = $api->getAll('/api/countries');
print_r($countries);
