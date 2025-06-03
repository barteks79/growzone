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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script type="importmap">
        {
            "imports": {
                "three": "https://cdn.jsdelivr.net/npm/three@0.176.0/build/three.module.js",
                "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.176.0/examples/jsm/",
                "motion": "https://cdn.jsdelivr.net/npm/motion@12.12.2/+esm"
            }
        }
    </script>
    <script src="./script.js" type="module"></script>
</head>
<body class="font-[Inter]">
    <div class="relative h-dvh">
        <div class="primary-radial-background absolute inset-0 -z-[2]"></div>
        <canvas id="introduction-canvas" class="absolute size-full -z-[1]"></canvas>

        <nav class="px-[3vw] py-4 grid place-items-center grid-cols-3">
            <div class="justify-self-start">
                <a href="../home/index.php" class="drop-shadow-2xl drop-shadow-emerald-400 transition duration-200 hover:drop-shadow-lime-400">
                    <img src="../../public/images/icon.png" alt="growzone icon" width="42" />
                </a>
            </div>

            <div class="justify-self-center flex gap-10 font-semibold uppercase drop-shadow-2xl">
                <a href="../home/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Home</a>
                <a href="../search/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Plants</a>
                <a href="../search/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Tools</a>
                <a href="../search/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Sale</a>
                <a href="../search/index.php" class="hover:text-white transition-colors rounded-lg hover:bg-black px-2 py-1">Seasonal</a>
            </div>

            <div class="justify-self-end flex gap-8">
                <a href="../search/index.php" class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="search" class="size-full transition"></i>
                </a>

                <a href="../cart/index.php" class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="shopping-cart" class="size-full transition"></i>
                </a>

                <?php if ($user): ?>
                    <div class="relative group">
                        <button class="size-10 cursor-pointer relative">
                            <span class="avatar animate-pulse bg-neutral-300 font-bold text-white size-full rounded-full grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                            <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                                <i data-lucide="chevron-down" class="size-[14px]"></i>
                            </div>
                        </button>

                        <div class="absolute z-[2] -right-4 invisible group-hover:visible min-w-[15rem]">
                            <div class="bg-transparent h-4"></div>
                            <div class="group-hover:scale-y-100 group-hover:opacity-100 opacity-0 scale-y-0 origin-top transition grid px-2 py-4 rounded-md bg-white shadow-md">
                                <div class="flex items-center gap-3 px-4">
                                    <span class="avatar animate-pulse bg-neutral-300 text-white font-bold rounded-full size-9 grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                                    <div class="flex flex-col items-start">
                                        <span class="text-sm font-medium"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                                        <span class="text-xs"><?= htmlspecialchars($user['email']) ?></span>
                                    </div>
                                </div>
                                <div class="mt-4 grid gap-2">
                                    <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                    <?php if ($user['role'] == 'admin'): ?>
                                        <a href="../admin/index.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-emerald-200"><i data-lucide="shield-user" class="size-5"></i>Admin Panel</a>
                                    <?php endif; ?>

                                    <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="history" class="size-5"></i>History</button>
                                    <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="settings" class="size-5"></i>Settings</button>

                                    <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                    <a href="../../php/logout.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-red-200"><i data-lucide="log-out" class="size-5"></i>Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="../sign-in/index.php" class="box-border relative z-30 inline-flex items-center justify-center w-auto px-6 py-2 overflow-hidden font-bold text-white transition-all duration-300 bg-indigo-600 rounded-md cursor-pointer group ring-offset-2 ring-1 ring-indigo-300 ring-offset-indigo-200 hover:ring-offset-indigo-500 ease focus:outline-none">
                        <span class="absolute bottom-0 right-0 w-8 h-20 -mb-8 -mr-5 transition-all duration-300 ease-out transform rotate-45 translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
                        <span class="absolute top-0 left-0 w-20 h-8 -mt-1 -ml-12 transition-all duration-300 ease-out transform -rotate-45 -translate-x-1 bg-white opacity-10 group-hover:translate-x-0"></span>
                        <span class="relative z-20 flex items-center text-sm">
                            <i data-lucide="users" class="relative w-5 h-5 mr-2 text-white"></i>
                            Sign in
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="mt-[60px] ml-[100px]">
            <h2 class="animate-[enter-header_1000ms_ease-out] select-none grid gap-4 font-[GT_Walsheim_Pro] text-8xl text-[#2D2946]">
                <span>Nature your garden</span>
                <span class="flex gap-4 items-start">
                    <span>with</span>
                    <span id="header-product-text" class="text-emerald-400 text-shadow-[0_6px_var(--color-emerald-700)]">GrowZone</span>
                </span>
            </h2>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
