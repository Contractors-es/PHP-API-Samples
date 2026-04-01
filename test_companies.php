<?php

require_once __DIR__ . '/vendor/autoload.php';

use ContractorsEs\Api\Api;
use ContractorsEs\Api\ApiRequestException;

$api = new Api("https://demo.contractors.es", "admin", "admin", "en");

try {
    // 1) Create Meeting
    $payload = [
        'company_name' => 'API Test Company ' . date('c'),
        'country_id' => 1, // USA
        'permission' => 2,
        'fields' => [
            // 'custom_date' => '2024-06-01',
        ]
    ];
    $resp = $api->post('/api/crm/companies', $payload);
    if (!in_array($resp->getStatusCode(), [200, 201])) $api->throwErr($resp);
    $created = json_decode($resp->getBody()->getContents(), true);
    $companyId = $created['data']['id'];
    echo "Created company ID: {$companyId}\n";

    // 4) Update company name
    $resp = $api->patch("/api/crm/companies/{$companyId}", [
        'company_name' => 'API Test Company Updated ' . date('c')
    ]);
    if (!in_array($resp->getStatusCode(), [200, 204])) $api->throwErr($resp);
    echo "Updated company name.\n";

    // 5) Cleanup
    $resp = $api->delete("/api/crm/companies/{$companyId}");
    if (!in_array($resp->getStatusCode(), [200, 204])) $api->throwErr($resp);
    echo "Deleted company {$companyId}.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
