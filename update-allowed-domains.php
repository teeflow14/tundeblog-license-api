<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['allowed_domains']) && is_array($input['allowed_domains'])) {
        $filename = 'allowed-domains.json';
        $filepath = __DIR__ . '/' . $filename;
        
        // Write the updated list to the JSON file
        if (file_put_contents($filepath, json_encode($input['allowed_domains']))) {
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to update allowed domains']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
