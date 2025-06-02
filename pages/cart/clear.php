<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type');

    $body = json_decode(file_get_contents('php://input'), true);

    if (!$body) {
        http_response_code(400);
        echo json_encode(['message' => 'No body provided.']);
        exit;
    }
    
    $user_id = $body['user_id'];

    if (!$user_id) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid body provided.']);
        exit;
    }

    $user = [
        'email' => 'test@gmail.com',
        'password' => '32de32nsadyu2jsnadjkhas-sdad2@E3'
    ];

    if (!$user) {
        http_response_code(404);
        echo json_encode(['message' => 'User not found.']);
        exit;
    }

    // logika usuwania wszystkich
    
    http_response_code(201);
    echo json_encode(['message' => 'Product removed from cart.']);
    exit;
?>