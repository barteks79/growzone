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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script src="./script.js" type="module" defer></script>
</head>
<body class="font-[Inter]">
    <div class="relative h-dvh">
        <div class="primary-radial-background absolute inset-0 -z-[1]"></div>

        <nav class="px-[3vw] py-4 grid place-items-center grid-cols-3">
            <div class="justify-self-start">
                <a href="../home/index.php" class="drop-shadow-2xl drop-shadow-emerald-400 transition duration-200 hover:drop-shadow-lime-400">
                    <img src="../../public/images/icon.png" alt="growzone icon" width="42" />
                </a>
            </div>

            <div class="justify-self-center flex gap-10 font-semibold uppercase drop-shadow-2xl">
                <a href="../home/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Home</a>
                <a href="../search/index.php?category=seeds" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Seeds</a>
                <a href="../search/index.php?category=tools" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Tools</a>
                <a href="../search/index.php?category=pots" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Pots</a>
                <a href="../search/index.php?category=fertilizers" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Fertilizers</a>
            </div>

            <div class="justify-self-end flex gap-8">
                <a href="../search/index.php" class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="search" class="size-full transition"></i>
                </a>

                <a href="../cart/index.php" class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="shopping-cart" class="size-full transition"></i>
                </a>

                <div class="relative group">
                    <button class="size-10 cursor-pointer relative">
                        <span class="avatar [--primary:var(--color-neutral-300)] bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 animate-pulse font-bold text-white size-full rounded-full grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                        <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                            <i data-lucide="chevron-down" class="size-[14px]"></i>
                        </div>
                    </button>

                    <div class="absolute z-[2] -right-4 invisible group-hover:visible min-w-[15rem]">
                        <div class="bg-transparent h-4"></div>
                            <div class="group-hover:scale-y-100 group-hover:opacity-100 opacity-0 scale-y-0 origin-top transition grid px-2 py-4 rounded-md bg-white shadow-md">
                                <div class="flex items-center gap-3 px-4">
                                    <span class="[--primary:var(--color-neutral-300)] avatar animate-pulse bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 text-white font-bold rounded-full size-9 grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                                    <span class="text-xs"><?= htmlspecialchars($user['email']) ?></span>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-2">
                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <?php if ($user['is_admin']): ?>
                                    <a href="../admin/index.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-emerald-200"><i data-lucide="shield-user" class="size-5"></i>Admin Panel</a>
                                <?php endif; ?>

                                <a href="../history/index.php?type=list&page=1" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="history" class="size-5"></i>History</a>
                                <a href="../settings/index.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="settings" class="size-5"></i>Settings</a>

                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <a href="../../php/logout.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-red-200"><i data-lucide="log-out" class="size-5"></i>Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-5xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-center mb-4">Your Settings</h1><br>
        <div class="flex justify-evenly gap-10 w-2/3 mt-4">
            <div class="flex items-center justify-start gap-6">
                <span class="[--primary:var(--color-neutral-300)] avatar animate-pulse bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 text-white font-bold rounded-full size-9 grid place-items-center"
                        style="width: 128px; height: 128px; font-size: 64px;"
                        data-first-name="<?= htmlspecialchars($user['first_name']) ?>"
                        data-last-name="<?= htmlspecialchars($user['last_name']) ?>">
                    -
                </span>
            </div>
            <div>
                <div class="flex items-center justify-center h-[128px]">
                    <span style="font-size: 60px;"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                </div>
            </div>
        </div>
        <hr class="my-8 border-t-2 border-gray-200 rounded-full mt-10">
        <div class="mt-8 space-y-6 text-base p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-4">
                <div>
                    <p class="text-gray-500 font-medium">First Name</p>
                    <p class="text-black font-semibold"><?= htmlspecialchars($user['first_name']) ?></p>
                </div>

                <div>
                    <p class="text-gray-500 font-medium">Surname</p>
                    <p class="text-black font-semibold"><?= htmlspecialchars($user['last_name']) ?></p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-gray-500 font-medium">Email</p>
                    <p class="text-black font-semibold"><?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>

            <div>
                <a href="./change-password.php"
                        class="mt-4 inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                    <i data-lucide="lock"></i>
                    Change Password
                </a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
