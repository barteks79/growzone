<?php 
    require_once __DIR__ . '../../../php/db.php';
    require_once __DIR__ . '../../../php/server_error.php';

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type');

    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        http_response_code(405);
        echo json_encode(['message' => 'Only DELETE requests are allowed.']);
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

    // pobieranie produktu z bazy
    $stmt = $db_o->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->bind_param('i', $product_id);
    if (!$stmt->execute()) server_error($stmt->error);
    
    $product = $stmt
        ->get_result()
        ->fetch_assoc();
    
    // walidacja produktu
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

    // walidacja cart'a
    if (!$cart) {
        http_response_code(451);
        echo json_encode(['message' => 'User\'s cart not found.']);
        exit;
    }

    $cart_id = $cart['cart_id'];

    // pobieramy cart_item z bazy
    $stmt = $db_o->prepare('SELECT * FROM cart_items WHERE product_id = ? AND cart_id = ?');
    $stmt->bind_param('ii', $product_id, $cart_id);
    if (!$stmt->execute()) server_error($stmt->error);

    $cart_item = $stmt
        ->get_result()
        ->fetch_assoc();

    // $stmt = $db_o->prepare('SELECT * FROM cart_items WHERE ')
    $product_quantity = $cart_item['quantity']; // logika z DB

    if ($product_quantity > 1) {
        // zmniejszamy quantity
        $updated_quantity = $cart_item['quantity'] - 1;
        $cart_item_id = $cart_item['cart_item_id'];

        $stmt = $db_o->prepare('UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?');
        $stmt->bind_param('ii', $updated_quantity, $cart_item_id);
        if (!$stmt->execute()) server_error($stmt->error);

        http_response_code(200);
        echo json_encode(['message' => "Product's quantity decreased."]);
    } else {
        // usuwamy z cart'a
        $stmt = $db_o->prepare('DELETE FROM cart_items WHERE product_id = ? AND cart_id = ?');
        $stmt->bind_param('ii', $product_id, $cart_id);
        if (!$stmt->execute()) server_error($stmt->error);
        
        http_response_code(204);
    }

    exit;
?>