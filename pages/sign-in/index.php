<?php

session_start();

require_once __DIR__ . '/../../php/db.php';
require_once __DIR__ . '/../../php/validation.php';

$first_name = $_POST['first-name'] ?? null;
$last_name = $_POST['last-name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];

    if (!validate_email($email)) {
        $errors['email'] = 'Email is invalid.';
    }

    if (!isset($errors['email'])) {
        $stmt = $db_o->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows == 0) {
            $errors['email'] = 'Email is not registered.';
        }
    }

    if (empty($errors)) {
        $stmt = $db_o->prepare('SELECT user_id, password FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        if (password_verify($password, $result['password'])) {
            $user_id = $result['user_id'];

            $_SESSION['user_id'] = $user_id;
            unset($_SESSION['errors']);
            unset($_SESSION['sign-in-data']);

            header('Location: ../home/index.php');
            exit();
        } else {
            $errors['password'] = 'Password is incorrect.';
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['sign-in-data'] = [
        'first-name' => $first_name,
        'last-name' => $last_name,
        'email' => $email,
        'password' => $password
    ];

    header('Location: ./index.php');
    exit();
}

$email = htmlspecialchars($_SESSION['sign-in-data']['email'] ?? '');
$email_error = htmlspecialchars($_SESSION['errors']['email'] ?? '');

$password = htmlspecialchars($_SESSION['sign-in-data']['password'] ?? '');
$password_error = htmlspecialchars($_SESSION['errors']['password'] ?? '');

if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in | GrowZone</title>

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
                <h2 class="text-3xl font-medium mb-8">Welcome back</h2>
                
                <form action="" method="post" class="grid gap-3 w-full">
                    <div class="grid gap-1 mb-3">
                        <label for="email" class="flex gap-0.5">
                            <span>Email Address</span>    
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="email" name="email" id="email" placeholder="Enter your email" class="border border-gray-400 p-2 pl-3 rounded-md w-full" value="<?= $email ?>" />
                            <div class="absolute right-0.5 bottom-1 p-2">
                                <i data-lucide="mail" class="size-[18px]"></i>
                            </div>
                        </div>
                        <span class="text-red-600 text-sm"><?= $email_error ?></span>
                    </div>

                    <div class="grid gap-1">
                        <label for="password" class="flex gap-0.5">
                            <span>Password</span>    
                            <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Enter your password" class="border border-gray-400 p-2 pl-3 rounded-md w-full" value="<?= $password ?>" />
                            <button type="button" id="toggle-password" class="absolute right-0.5 bottom-0.5 p-2">
                                <i data-lucide="eye" class="size-[22px]"></i>
                            </button>
                        </div>
                        <span class="text-red-600 text-sm"><?= $password_error ?></span>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remember" id="remember" />
                            <label for="remember">Remember me</label>
                        </div>

                        <a href="reset_request.php" class="underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="cursor-pointer rounded-md bg-green-500 py-3 font-bold text-white shadow-xs transition hover:brightness-110 [box-shadow:0_4px_0_0_var(--color-green-700)] active:translate-y-[4px] active:shadow-none">Sign in</button>
                </form>

                <div class="mt-6 flex items-center gap-2 w-full">
                    <span class="w-full h-[2px] bg-gray-400"></span>
                    <span class="text-sm opacity-50">OR</span>
                    <span class="w-full h-[2px] bg-gray-400"></span>
                </div>

                <span class="mt-4">Don't have an account yet? <a href="../sign-up/index.php" class="underline">Sign up</a></span>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
