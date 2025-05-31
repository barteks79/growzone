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

    if (!validate_between($first_name, 1, 20)) {
        $errors['first-name'] = 'First name must be between 1 and 20 characters.';
    }

    if (!validate_between($last_name, 1, 30)) {
        $errors['last-name'] = 'Last name must be between 1 and 30 characters.';
    }

    if (!validate_email($email)) {
        $errors['email'] = 'Email is invalid.';
    }

    if (!validate_between($password, 3, 30)) {
        $errors['password'] = 'Password must be between 3 and 30 characters.';
    }

    if (!isset($errors['email'])) {
        $stmt = $db_o->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $errors['email'] = 'Email is already registered.';
        }
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db_o->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $first_name, $last_name, $email, $hashed_password);
        $stmt->execute();

        $stmt = $db_o->prepare('SELECT user_id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $user_id = $stmt->get_result()->fetch_assoc()['user_id'];

        $_SESSION['user_id'] = $user_id;
        unset($_SESSION['errors']);
        unset($_SESSION['sign-up-data']);

        header('Location: ../home/index.php');
        exit();
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['sign-up-data'] = [
        'first-name' => $first_name,
        'last-name' => $last_name,
        'email' => $email,
        'password' => $password
    ];

    header('Location: ./index.php');
    exit();
}

$first_name = htmlspecialchars($_SESSION['sign-up-data']['first-name'] ?? '');
$first_name_error = htmlspecialchars($_SESSION['errors']['first-name'] ?? '');

$last_name = htmlspecialchars($_SESSION['sign-up-data']['last-name'] ?? '');
$last_name_error = htmlspecialchars($_SESSION['errors']['last-name'] ?? '');

$email = htmlspecialchars($_SESSION['sign-up-data']['email'] ?? '');
$email_error = htmlspecialchars($_SESSION['errors']['email'] ?? '');

$password = htmlspecialchars($_SESSION['sign-up-data']['password'] ?? '');
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
    <title>Sign up | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script type="module" src="./script.js" defer></script>
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
                <div id="avatar" class="size-16 mb-8 text-white rounded-full animate-pulse font-bold text-2xl grid place-items-center bg-neutral-300"></div>
                
                <form action="" method="post" class="grid gap-6 w-full">
                    <div class="grid grid-cols-2 gap-5">
                        <div class="grid gap-1">
                            <label for="first-name" class="flex gap-0.5">
                                <span>First name</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="first-name" id="first-name" placeholder="Your first name" class="border border-gray-400 p-2 pl-3 rounded-md w-full" value="<?= $first_name ?>" />
                                <div class="absolute right-0.5 bottom-1 p-2">
                                    <i data-lucide="user" class="size-[18px]"></i>
                                </div>
                            </div>
                            <div class="text-red-600 text-sm"><?= $first_name_error ?></div>
                        </div>

                        <div class="grid gap-1">
                            <label for="last-name" class="flex gap-0.5">
                                <span>Last name</span>
                                <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="last-name" id="last-name" placeholder="Your last name" class="border border-gray-400 p-2 pl-3 rounded-md w-full" value="<?= $last_name ?>" />
                                <div class="absolute right-0.5 bottom-1 p-2">
                                    <i data-lucide="user" class="size-[18px]"></i>
                                </div>
                            </div>
                            <div class="text-red-600 text-sm"><?= $last_name_error ?></div>
                        </div>
                    </div>

                    <div class="grid gap-1">
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
                            <div class="text-red-600 text-sm"><?= $email_error ?></div>
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
                        <div id="password-strength" class="grid grid-cols-4 gap-1 px-0.5 mt-1">
                            <span class="transition h-1.5 rounded-full bg-neutral-300 data-[strength=1]:bg-red-500 data-[strength=2]:bg-amber-500 data-[strength=3]:bg-green-500 data-[strength=4]:bg-green-500"></span>
                            <span class="transition h-1.5 rounded-full bg-neutral-300 data-[strength=2]:bg-amber-500 data-[strength=3]:bg-green-500 data-[strength=4]:bg-green-500"></span>
                            <span class="transition h-1.5 rounded-full bg-neutral-300 data-[strength=3]:bg-green-500 data-[strength=4]:bg-green-500"></span>
                            <span class="transition h-1.5 rounded-full bg-neutral-300 data-[strength=4]:bg-green-500"></span>
                        </div>
                        <div class="text-red-600 text-sm"><?= $password_error ?></div>
                    </div>

                    <button type="submit" class="cursor-pointer rounded-md bg-green-500 py-3 font-bold text-white shadow-xs transition hover:brightness-110 [box-shadow:0_4px_0_0_var(--color-green-700)] active:translate-y-[4px] active:shadow-none">Sign up</button>
                </form>

                <div class="mt-6 flex items-center gap-2 w-full">
                    <span class="w-full h-[2px] bg-gray-400"></span>
                    <span class="text-sm opacity-50">OR</span>
                    <span class="w-full h-[2px] bg-gray-400"></span>
                </div>

                <span class="mt-4">Already have an account? <a href="../sign-in/index.php" class="underline">Sign in</a></span>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
