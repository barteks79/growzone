<?php

require_once __DIR__ . '/../../php/db.php';

foreach ($_FILES as $file) {
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $title = pathinfo($file['name'], PATHINFO_FILENAME);

    $stmt = $db_o->prepare('INSERT INTO uploads (file_path, title, size, created_at) VALUES (CONCAT(UUID(), ".", ?), ?, ?, CURRENT_DATE())');
    $stmt->bind_param('ssi', $extension, $title, $file['size']);
    $stmt->execute();

    $uploadId = $stmt->insert_id;

    $stmt = $db_o->prepare('SELECT file_path FROM uploads WHERE upload_id = ?');
    $stmt->bind_param('i', $uploadId);
    $stmt->execute();

    $uploadName = $stmt->get_result()->fetch_assoc()['file_path'];
    $uploadDir = __DIR__ . '/../../uploads/';

    move_uploaded_file($file['tmp_name'], $uploadsDir . $uploadName);
}
