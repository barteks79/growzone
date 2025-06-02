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
        header('Location: ./reset-request.php?email=notfound');
        exit;
    }

    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $resetLink = "http://localhost/growzone/pages/sign-in/reset-password.php?token=$token";

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
        header('Location: ./reset-request.php?email=sent');
    } catch (Exception $e) {
        echo "Błąd wysyłania: {$mail->ErrorInfo}";
        header("Location: ./reset-request.php?email=$mail->ErrorInfo");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script src="./script.js" defer></script>
</head>

<body class="font-[Inter]">
    <div class="relative h-dvh">
        <div class="primary-radial-background absolute inset-0 -z-[1]"></div>

        <a href="../home/index.php" class="absolute top-6 left-6 bg-white rounded-md shadow-sm px-6 py-3">
            <div class="flex items-center gap-3 group">
                <img src="../../public/images/icon.png" alt="growzone icon" width="36" height="36" />
                <span class="text-2xl font-semibold group-hover:text-emerald-600 transition">GrowZone</span>
            </div>
        </a>
        <div class="h-full grid place-items-center">
            <main class="bg-white rounded-xl shadow-xl px-8 py-8 min-w-[25rem] flex flex-col items-center">
                <h2 class="text-3xl font-medium mb-8">Reset password</h2>
                
                <form method="POST" class="grid gap-3 w-full">
                    <div class="grid gap-1 mb-3">
                        <label for="email" class="flex gap-0.5">
                            <span>Email Address</span>    
                            <span class="text-red-600">*</span>
                        </label>

                        <div class="relative">
                            <input type="email" name="email" id="email" placeholder="Enter your email" class="border border-gray-400 p-2 pl-3 rounded-md w-full" />
                            <div class="absolute right-0.5 bottom-1 p-2">
                                <i data-lucide="mail" class="size-[18px]"></i>
                            </div>
                        </div>

                        <span class="text-red-600 text-sm">
                            <?php 
                                if (isset($_GET['email']) && $_GET['email'] !== 'sent') {
                                    if ($_GET['email'] === 'notfound') {
                                        echo "Ten adres email nie istnieje!"; 
                                    } else {
                                        echo "Coś poszło nie tak! Spróbuj ponownie później.";
                                    }
                                } 
                            ?>
                        </span>

                        <span class="text-green-600 text-sm">
                            <?php 
                                if (isset($_GET['email']) && $_GET['email'] === 'sent') {
                                    echo "Mail został wysłany! Sprawdź swoją skrzynkę."; 
                                }
                            ?>
                        </span>
                    </div>

                    <button type="submit" class="cursor-pointer rounded-md bg-green-500 py-3 font-bold text-white shadow-xs transition hover:brightness-110 [box-shadow:0_4px_0_0_var(--color-green-700)] active:translate-y-[4px] active:shadow-none">Send</button>
                </form>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
