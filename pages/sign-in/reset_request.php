<?php
require '../php/phpmailer/src/PHPMailer.php';
require '../php/phpmailer/src/SMTP.php';
require '../php/phpmailer/src/Exception.php';
require '../php/utils.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Sprawdź, czy email istnieje – tu na sztywno:
    if ($email !== 'test@gmail.com') {
        echo "Jeśli konto istnieje, wysłaliśmy wiadomość.";
        exit;
    }

    // Wygeneruj token
    $token = bin2hex(random_bytes(32));
    $resetLink = "http://http://localhost/growzone/pages/sign-in/reset_password.php?token=$token";

    // Zapisz token do pliku, bazy, lub sesji — tu sesja (dla testów)
    session_start();
    $_SESSION['reset_token'] = $token;
    $_SESSION['reset_email'] = $email;

    // Wysyłka maila
    $mail = new PHPMailer(true);

    $env = get_env();

    try {
        $mail->isSMTP();
        $mail->Host       = $env['HOST'];
        $mail->SMTPAuth   = $env['AUTH'] === 'true' ? true : false;
        $mail->Username   = $env['USERNAME'];
        $mail->Password   = $env['PASSWORD'];
        $mail->SMTPSecure = $env['SECURE'];
        $mail->Port       = (int)$env['PORT'];

        $mail->setFrom('twojemail@gmail.com', 'TwojaStrona');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset hasła';
        $mail->Body    = "Kliknij <a href='$resetLink'>tutaj</a>, aby zresetować hasło.";

        $mail->send();
        echo "Wysłano wiadomość e-mail z linkiem do resetu.";
    } catch (Exception $e) {
        echo "Błąd wysyłania: {$mail->ErrorInfo}";
    }
}

// require_once 'db.php'; // <- upewnij się, że masz poprawne połączenie PDO

// $email = $_POST['email'];

// $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
// $stmt->execute([$email]);
// $user = $stmt->fetch();

// if (!$user) {
//     echo "Jeśli konto istnieje, wysłaliśmy wiadomość.";
//     exit;
// }

// // Wygeneruj token i zapisz go w bazie
// $token = bin2hex(random_bytes(32));
// $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
// $resetLink = "http://localhost/growzone/pages/sign-in/reset_password.php?token=$token";

// $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, token_expires = ? WHERE email = ?");
// $stmt->execute([$token, $expires, $email]);      DO PODMIANY
?>

<!-- HTML formularza -->
<form method="POST">
    <input type="email" name="email" required placeholder="Twój email">
    <button type="submit">Wyślij link resetujący</button>
</form>
