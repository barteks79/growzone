<?php

require_once __DIR__ . '/../../php/db.php';

$upload_id = $_POST['upload_id'];

$stmt = $db_o->prepare('DELETE FROM uploads WHERE upload_id = ?');
$stmt->bind_param('i', $upload_id);
$stmt->execute();

header('Location: ./index.php?tab=images');
