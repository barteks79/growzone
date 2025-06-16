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

$stmt = $db_o->prepare('INSERT INTO logs (user_id, action, created_at) VALUES (?, "New image added", NOW())');
$stmt->bind_param('i', $user_id);
$stmt->execute();