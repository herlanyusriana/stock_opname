<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client(['base_uri' => 'http://127.0.0.1:8000/api/']);

try {
    // 1. Login
    echo "Logging in...\n";
    $response = $client->post('login', [
        'json' => [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]
    ]);
    
    $data = json_decode($response->getBody(), true);
    $token = $data['token'];
    echo "Login successful. Token: " . substr($token, 0, 10) . "...\n";

    // 2. Get QR Location
    echo "Fetching Location QR...\n";
    $response = $client->get('qr/location/1', [
        'headers' => ['Authorization' => 'Bearer ' . $token]
    ]);
    
    if ($response->getHeaderLine('Content-Type') === 'image/png') {
        echo "Location QR received (PNG).\n";
    } else {
        echo "Error: Location QR is not PNG.\n";
    }

    // 3. Get QR Part
    echo "Fetching Part QR...\n";
    $response = $client->get('qr/part/1', [
        'headers' => ['Authorization' => 'Bearer ' . $token]
    ]);

    if ($response->getHeaderLine('Content-Type') === 'image/png') {
        echo "Part QR received (PNG).\n";
    } else {
        echo "Error: Part QR is not PNG.\n";
    }

    echo "Verification passed!\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
        echo "Response: " . $e->getResponse()->getBody() . "\n";
    }
    exit(1);
}
