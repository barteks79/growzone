<?php

require_once __DIR__ . '/../../php/db.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

foreach ($data as $change) {
    $id = $change['id'];
    $name = $change['name'];
    $value = $change['value'];

    if ($name == 'delete') {
        $stmt = $db_o->prepare('DELETE FROM categories WHERE category_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        continue;
    }
    
    $query = 'UPDATE categories SET ';

    if ($name == 'title') {
        $query .= 'title';
    }

    $query .= ' = ? WHERE category_id = ?';

    $stmt = $db_o->prepare($query);
    $stmt->bind_param('si', $value, $id);
    $stmt->execute();
}
