<?php

session_start();

require_once __DIR__ . '/../../php/db.php';

$user = null;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $db_o->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

$product_id = $_GET['product_id'];

if (!$user || !$product_id) exit;

$data = ['product_id' => $product_id, 'user_id' => $user['user_id']];

$url = 'http://localhost/growzone/pages/cart/add.php';

$options = array(
  'http' => array(
    'method' => 'POST',
    'content' => json_encode($data),
    'header'=> "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$response = json_decode($result);

header('Location: ../cart/index.php');
exit;
