<?php

require_once __DIR__ . '/../../php/db.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

foreach ($data as $change) {
    $id = $change['id'];
    $name = $change['name'];
    $value = $change['value'];

    if ($name == 'delete') {
        $stmt = $db_o->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        continue;
    }
    
    $query = 'UPDATE users SET ';

    if ($name == 'first-name') {
        $query .= 'first_name';
    }

    if ($name == 'last-name') {
        $query .= 'last_name';
    }

    if ($name == 'email') {
        $query .= 'email';
    }

    if ($name == 'is-admin') {
        $query .= 'is_admin';
    }

    $query .= ' = ? WHERE user_id = ?';

    $stmt = $db_o->prepare($query);
    $stmt->bind_param($name == 'is-admin' ? 'ii' : 'si', $value, $id);
    $stmt->execute();
}
