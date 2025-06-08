<?php 
    require_once __DIR__ . '../../../php/db.php';
    require_once __DIR__ . '../../../php/server_error.php';

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['message' => 'Only POST requests are allowed.']);
        exit;
    }

    $body = json_decode(file_get_contents('php://input'), true);

    // walidacja body
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

    $stmt = $db_o->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->bind_param('i', $product_id);
    if (!$stmt->execute()) server_error($stmt->error);

    $product = $stmt
        ->get_result()
        ->fetch_assoc();

    if (!$product) {
        http_response_code(404);
        echo json_encode(['message' => 'Product not found.']);
        exit;
    }

    // pobieranie uzytkownika z bazy
    $stmt = $db_o->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    if (!$stmt->execute()) server_error($stmt->error);

    $user = $stmt
        ->get_result()
        ->fetch_assoc();

    // walidacja uzytkownika
    if (!$user) {
        http_response_code(401);
        echo json_encode(['message' => 'User not authenticated.']);
        exit;
    }

    // pobieramy koszyk z bazy
    $stmt = $db_o->prepare('SELECT * FROM carts WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    if (!$stmt->execute()) server_error($stmt->error);

    $cart = $stmt
        ->get_result()
        ->fetch_assoc();

    if (!$cart) {
        $stmt = $db_o->prepare('INSERT INTO carts VALUES (NULL, ?)');
        $stmt->bind_param('i', $user_id);
        if (!$stmt->execute()) server_error($stmt->error);
    }

    $cart_id = $cart['cart_id'] ?? $stmt->insert_id;

    // pobieramy cart_item z bazy
    $stmt = $db_o->prepare('SELECT * FROM cart_items WHERE product_id = ? AND cart_id = ?');
    $stmt->bind_param('ii', $product_id, $cart_id);
    if (!$stmt->execute()) server_error($stmt->error);

    $cart_item = $stmt
        ->get_result()
        ->fetch_assoc();

    $is_product_in_cart = boolval($cart_item); // logika z DB

    if ($is_product_in_cart) {
        // zwiększamy quantity
        $updated_quantity = $cart_item['quantity'] + 1;
        $cart_item_id = $cart_item['cart_item_id'];

        $stmt = $db_o->prepare('UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?');
        $stmt->bind_param('ii', $updated_quantity, $cart_item_id);
        if (!$stmt->execute()) server_error($stmt->error);

        http_response_code(201);
        echo json_encode(['message' => "Product's quantity increased."]);
    } else {
        // dodajemy do cart'a
        $stmt = $db_o->prepare('INSERT INTO cart_items VALUES (NULL, ?, ?, 1)');
        $stmt->bind_param('ii', $cart_id, $product_id,);
        if (!$stmt->execute()) server_error($stmt->error);
        
        http_response_code(201);
        echo json_encode(['message' => 'Product added to cart.']);
    }

    $stmt->close();
    exit;
?>