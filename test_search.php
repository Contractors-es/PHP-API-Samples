<?php
require_once __DIR__ . '/vendor/autoload.php';

use ContractorsEs\Api\Api;
use ContractorsEs\Api\ApiRequestException;


$config = [
    'url' => 'https://demo.contractors.es',
    'username' => 'admin',
    'password' => 'admin',
    'lang' => 'en'
];

$searchData = [
    'filters' => [
        [
            'type' => 'and',
            'field' => 'company_name',
            'operator' => 'like',
            'value' => '%a%'
        ]
    ]
];

try {
    $api = new Api($config['url'], $config['username'], $config['password'], $config['lang']);
    $response = $api->post('/api/crm/companies/search', $searchData);
    $responseData = json_decode($response->getBody()->getContents(), true);

    if (isset($responseData['data']) && !empty($responseData['data'])) {
        foreach ($responseData['data'] as $company) {
            echo "{$company['company_name']}\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
