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
    
    $product_id = $body['product_id'];
    $user_id = $body['user_id'];

    if (!$product_id || !$user_id) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid body provided.']);
        exit;
    }

    // logika z db

    $product = [
        'product_id' => 1,
        'name' => 'Palma',
        'price' => 69.99,
        'photo' => 'images/palma.jpg',
        'in_stock' => true
    ];

    if (!$product) {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found.']);
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

    $product_quantity = false; // logika z DB

    if ($product_quantity > 1) {
        // zwiększamy quantity

        http_response_code(201);
        echo json_encode(['message' => "Product's quantity decreased."]);
    } else {
        // dodajemy do cart'a
        
        http_response_code(201);
        echo json_encode(['message' => 'Product removed from cart.']);
    }

    exit;
?>