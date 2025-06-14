<?php

require_once __DIR__ . '/../../php/db.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$rating = $data['rating'];
$description = $data['description'];
$user_id = $data['user_id'];
$product_id = $data['product_id'];

$stmt = $db_o->prepare('INSERT INTO reviews (rating, description, user_id, product_id, created_at) VALUES (?, ?, ?, ?, CURRENT_DATE())');
$stmt->bind_param('isii', $rating, $description, $user_id, $product_id);
$stmt->execute();
