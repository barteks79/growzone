<?php

session_start();

require_once __DIR__ . '/../../php/db.php';

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

if (!$user || !$user['is_admin']) {
    header("Location: ../home/index.php");
    exit();
}

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

foreach ($data as $change) {
    $id = $change['id'];
    $name = $change['name'];
    $value = $change['value'];

    if ($name == 'delete') {
        $stmt = $db_o->prepare('DELETE FROM products WHERE product_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        continue;
    }
    
    $query = 'UPDATE products SET ';

    if ($name == 'title') {
        $query .= 'title';
        $type = 's';
    }

    if ($name == 'price') {
        $query .= 'price';
        $type = 'd';
    }

    if ($name == 'description') {
        $query .= 'description';
        $type = 's';
    }

    if ($name == 'category') {
        $query .= 'category_id';
        $type = 'i';
    }

    if ($name == 'picture') {
        $query .= 'upload_id';
        $type = 'i';

        if ($value == 0) {
            $value = null;
        }
    }

    if ($name == 'in-stock') {
        $query .= 'in_stock';
        $type = 'i';
    }

    $query .= ' = ? WHERE product_id = ?';

    $stmt = $db_o->prepare($query);
    $stmt->bind_param($type . 'i', $value, $id);
    $stmt->execute();
}

if($change['name'] == 'delete') {
    $stmt = $db_o->prepare('INSERT INTO logs (user_id, action, created_at) VALUES (?, "Records deleted from Products", NOW())');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
} else {
    $stmt = $db_o->prepare('INSERT INTO logs (user_id, action, created_at) VALUES (?, "Records updated in Products", NOW())');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
}