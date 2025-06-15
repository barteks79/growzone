<?php
    session_start();

    require_once __DIR__ . '/../../php/db.php';

    $user = null;

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

    if (!$user) {
        header("Location: ../home/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = $_POST['password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $db_o->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE user_id = ?");
        $stmt->bind_param('si', $hashedPassword, $user['user_id']);
        $stmt->execute();

        header('Location: ./index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Password | GrowZone</title>

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
                <h2 class="text-3xl font-medium mb-8">New password</h2>
                
                <form method="POST" class="grid gap-3 w-full">
                    <div class="grid gap-1 mb-3">
                        <label for="password" class="flex gap-0.5">
                            <span>New password</span>    
                            <span class="text-red-600">*</span>
                        </label>

                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Enter new password" class="border border-gray-400 p-2 pl-3 rounded-md w-full" />
                            <div class="absolute right-0.5 bottom-1 p-2">
                                <i data-lucide="mail" class="size-[18px]"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="cursor-pointer rounded-md bg-green-500 py-3 font-bold text-white shadow-xs transition hover:brightness-110 [box-shadow:0_4px_0_0_var(--color-green-700)] active:translate-y-[4px] active:shadow-none">Change</button>
                </form>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
