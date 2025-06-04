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
    
    $user_id = $body['user_id'];

    if (!$user_id) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid body provided.']);
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

    // usuwanie koszyka dla uzytkownika
    $stmt = $db_o->prepare('DELETE FROM carts WHERE user_id = ?');
    $stmt->bind_param('i', $user_id);
    if (!$stmt->execute()) server_error($stmt->error);
    
    http_response_code(204);
    exit;
?>