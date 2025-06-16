<?php

require_once __DIR__ . '/../../php/db.php';

$title = $_POST['title'];

$stmt = $db_o->prepare('INSERT INTO categories (title) VALUES (?)');
$stmt->bind_param('s', $title);
$stmt->execute();

header('Location: ./index.php?tab=categories');
exit;
