<?php
require_once __DIR__ . '/../../php/db.php';
require_once __DIR__ . '/../../php/env.php';

if (!isset($_GET['token'])) {
    die("Nieprawidłowy lub wygasły token.");
}

$token = $_GET['token'];
$stmt = $db_o->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expires > NOW()");
$stmt->bind_param('s', $token);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Nieprawidłowy lub wygasły token.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $db_o->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE user_id = ?");
    $stmt->bind_param('si', $hashedPassword, $user['user_id']);
    $stmt->execute();

    echo "Hasło zostało pomyślnie zresetowane. Możesz się teraz zalogować.";
    exit;
}
?>

<!-- HTML formularza -->
<form method="POST">
    <input type="password" name="password" required placeholder="Nowe hasło">
    <button type="submit">Ustaw hasło</button>
</form>
