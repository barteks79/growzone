<?php

require_once __DIR__ . '/../../php/db.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$productName = $data['productName'];

$stmt = $db_o->prepare('SELECT title FROM products WHERE title LIKE ? ORDER BY title');
$temp = "$productName%";
$stmt->bind_param('s', $temp);
$stmt->execute();

$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$products = [];

foreach ($result as $product) {
    array_push($products, $product['title']);
}

echo json_encode($products);
