<?php
session_start();

if (!isset($_GET['token']) || $_GET['token'] !== ($_SESSION['reset_token'] ?? '')) {
    die("Nieprawidłowy lub wygasły token.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];

    // Tu powinieneś zapisać nowe hasło do bazy / pliku
    // Zamiast bazy – tylko testowo
    echo "Hasło zostało zmienione na: " . htmlspecialchars($newPassword);

    // Usuń token z sesji
    unset($_SESSION['reset_token']);
    unset($_SESSION['reset_email']);
    exit;
}
?>

<!-- HTML formularza -->
<form method="POST">
    <input type="password" name="password" required placeholder="Nowe hasło">
    <button type="submit">Ustaw hasło</button>
</form>
