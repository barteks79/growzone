<?php 
   session_start();
   
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: PUT');
   header('Access-Control-Allow-Headers: Content-Type');

    if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
        http_response_code(405);
        echo json_encode(['message' => 'Only PUT requests are allowed.']);
        exit;
    }

    $body = json_decode(file_get_contents('php://input'), true);

    if (!$body) {
        http_response_code(400);
        echo json_encode(['message' => 'No body provided.']);
        exit;
    }

    foreach ($body as $key => $value) {
        $_SESSION[$key] = $value;
    }
    
    http_response_code(201);
    echo json_encode(['message' => 'Session updated.']);
    exit;
?>