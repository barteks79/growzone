<?php

require_once __DIR__ . '/../../php/db.php';

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

    if ($name == 'rating') {
        $query .= 'rating';
        $type = 'd';
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
