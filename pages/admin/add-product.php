<?php

require_once __DIR__ . '/../../php/db.php';

$title = $_POST['title'];
$price = $_POST['price'];
$description = $_POST['description'];
$category = $_POST['category'];
$picture = $_POST['picture'];
$in_stock = $_POST['in-stock'] == 'on' ? 1 : 0;

$upload_id = $picture == 0 ? null : $picture;

$stmt = $db_o->prepare('INSERT INTO products (title, price, description, category_id, upload_id, in_stock) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->bind_param('sdsiii', $title, $price, $description, $category, $upload_id, $in_stock);
$stmt->execute();

header('Location: ./index.php?tab=products');
exit;
