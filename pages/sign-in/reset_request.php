<?php
require '../../php/phpmailer/src/PHPMailer.php';
require '../../php/phpmailer/src/SMTP.php';
require '../../php/phpmailer/src/Exception.php';
require '../../php/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../php/db.php';

    $email = $_POST['email'];

    $stmt = $db_o->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        echo "Jeśli konto istnieje, wysłaliśmy wiadomość.";
        exit;
    }

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $resetLink = "http://localhost/growzone/pages/sign-in/reset_password.php?token=$token";

    $stmt = $db_o->prepare("UPDATE users SET reset_token = ?, token_expires = ? WHERE email = ?");
    $stmt->bind_param('sss', $token, $expires, $email);
    $stmt->execute();

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';


    $env = get_env();

    try {
        $mail->isSMTP();
        $mail->Host       = $env['HOST'];
        $mail->SMTPAuth   = $env['AUTH'] === 'true' ? true : false;
        $mail->Username   = $env['USERNAME'];
        $mail->Password   = $env['PASSWORD'];
        $mail->SMTPSecure = $env['SECURE'];
        $mail->Port       = (int)$env['PORT'];

        $mail->setFrom('growzone.help@gmail.com', 'GrowZone');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset hasła';

        $mail->Body = '
        <!DOCTYPE html>
        <html lang="pl">
        <head>
        <meta charset="UTF-8">
        <title>Reset hasła</title>
        <style>
            body {
            margin: 0;
            padding: 0;
            font-family: "Inter", Arial, sans-serif;
            background-color: #ecfdf5;
            }
            .email-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px 20px;
            background: #f0fdf4;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            h1 {
            color: #065f46;
            }
            p {
            color: #111827;
            font-size: 16px;
            }
            .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background-color: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            }
        </style>
        </head>
        <body style="background: #d1fae5;">
        <div class="email-container">
            <h1>Zresetuj hasło</h1>
            <p>Kliknij przycisk poniżej, aby zresetować swoje hasło. Link jest ważny przez 1 godzinę.</p>
            <a href="' . $resetLink . '" class="btn">Zresetuj hasło</a>
            <p>Jeśli to nie Ty próbujesz zresetować hasło, zignoruj tę wiadomość.</p>
        </div>
        </body>
        </html>';


        $mail->send();
        echo "Wysłano wiadomość e-mail z linkiem do resetu.";
    } catch (Exception $e) {
        echo "Błąd wysyłania: {$mail->ErrorInfo}";
    }
}

?>

<!-- HTML formularza -->
<form method="POST">
    <input type="email" name="email" required placeholder="Twój email">
    <button type="submit">Wyślij link resetujący</button>
</form>
