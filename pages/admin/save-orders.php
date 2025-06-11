<?php

require_once __DIR__ . '/../../php/db.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

foreach ($data as $change) {
    $id = $change['id'];
    $name = $change['name'];
    $value = $change['value'];
    
    $query = 'UPDATE orders SET ';

    if ($name == 'order-date') {
        $query .= 'order_date';
    }

    if ($name == 'delivered') {
        $query .= 'delivered';
    }

    if ($name == 'delivery-date') {
        $query .= 'delivery_date';
    }

    $query .= ' = ? WHERE order_id = ?';

    $stmt = $db_o->prepare($query);
    $stmt->bind_param($name == 'delivered' ? 'ii' : 'si', $value, $id);
    $stmt->execute();
}
