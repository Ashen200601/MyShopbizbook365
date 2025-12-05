<?php
require_once '../../../../wp-load.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Get POST data
$postData = json_decode(file_get_contents('php://input'), true);

// Determine which API to call based on the provided action
$action = $postData['action'] ?? 'getProducts';
$url = '';

switch ($action) {
    case 'getProducts':
        $url = FAQLY_PLUGIN_LICENSE_URL . 'getFilteredProducts';
        $data = [
            "collectionHandle" => $postData['collectionHandle'] ?? "",
            "productHandle" => $postData['productHandle'] ?? "",
            "paginationParams" => $postData['paginationParams'] ?? [
                "first" => 12,
                "afterCursor" => null,
                "beforeCursor" => null,
                "reverse" => true
            ]
        ];

        break;
    case 'getCollections':
        $url = FAQLY_PLUGIN_LICENSE_URL . 'getCollections';
        $data = [];
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
        exit;
}

// Prepare the request arguments
$args = [
    'method' => 'POST',
    'body' => json_encode($data),
    'headers' => [
        'Content-Type' => 'application/json',
    ]
];
// Make the request using wp_remote_post
$response = wp_remote_post($url, $args);

// Check for errors
if (is_wp_error($response)) {
    echo json_encode(['error' => 'Request failed: ' . $response->get_error_message()]);
    exit;
}

// Check the response code
$http_code = wp_remote_retrieve_response_code($response);
if ($http_code !== 200) {
    echo json_encode(['error' => 'HTTP error: ' . $http_code]);
    exit;
}

// Get the response body
$response_body = wp_remote_retrieve_body($response);
$data = json_decode($response_body, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON format received from the external API']);
    exit;
}

// Output the fetched data as JSON
echo json_encode($data);