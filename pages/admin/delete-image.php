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

$upload_id = $_POST['upload_id'];

$stmt = $db_o->prepare('UPDATE products SET upload_id = NULL WHERE upload_id = ?');
$stmt->bind_param('i', $upload_id);
$stmt->execute();

$stmt = $db_o->prepare('DELETE FROM uploads WHERE upload_id = ?');
$stmt->bind_param('i', $upload_id);
$stmt->execute();

$stmt = $db_o->prepare('INSERT INTO logs (user_id, action, created_at) VALUES (?, "Image deleted", NOW())');
$stmt->bind_param('i', $user_id);
$stmt->execute();

header('Location: ./index.php?tab=images');
exit;
