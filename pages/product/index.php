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

$product = null;

if (isset($_GET['id'])) {
    $product_uuid = $_GET['id'];

    $stmt = $db_o->prepare("SELECT products.*, categories.title AS category FROM products JOIN categories USING (category_id) WHERE products.uuid = ?");
    $stmt->bind_param("s", $product_uuid);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

if (!$product) {
    header('Location: ../search/index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($product['title']) ?> | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script src="./script.js" type="module" defer></script>
</head>
<body class="font-[Inter]">
    <div class="relative h-dvh flex flex-col">
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

                <?php if ($user): ?>
                    <div class="relative group">
                        <button class="size-10 cursor-pointer relative">
                            <span class="avatar [--primary:var(--color-neutral-300)] bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 font-bold text-white size-full rounded-full grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                            <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                                <i data-lucide="chevron-down" class="size-[14px]"></i>
                            </div>
                        </button>

                        <div class="absolute z-[2] -right-4 invisible group-hover:visible min-w-[15rem]">
                            <div class="bg-transparent h-4"></div>
                            <div class="group-hover:scale-y-100 group-hover:opacity-100 opacity-0 scale-y-0 origin-top transition grid px-2 py-4 rounded-md bg-white shadow-xl">
                                <div class="flex items-center gap-3 px-4">
                                    <span class="avatar [--primary:var(--color-neutral-300)] bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 text-white font-bold rounded-full size-9 grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
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

        <div class="px-8 pb-8 pt-2 h-[calc(100dvh_-_74px)]">
            <main class="h-full bg-white relative shadow-md flex flex-col gap-12 rounded-lg p-8">
                <div class="flex items-center gap-4 justify-center font-medium">
                    <a href="../search/index.php" class="text-neutral-600 hover:text-black">Search</a>
                    <span>&rightarrow;</span>
                    <a href="../search/index.php?productName=<?= urlencode($product['title']) ?>" class="text-neutral-600 hover:text-black"><?= htmlspecialchars($product['title']) ?></a>
                    <span>&rightarrow;</span>
                    <a href="">Product</a>
                </div>

                <div class="grid grid-cols-2 gap-12">
                    <div class="justify-self-end w-[25rem] h-[30rem] rounded-lg overflow-hidden">
                        <div class="bg-neutral-300 animate-pulse size-full"></div>
                    </div>
                    
                    <div class="flex flex-col gap-6 h-[30rem] max-w-[25rem]">
                        <h2 class="text-5xl font-semibold"><?= htmlspecialchars($product['title']) ?></h2>

                        <div class="flex items-center gap-6">
                            <span class="px-3 py-1 font-semibold bg-emerald-400 text-white rounded-md"><?= htmlspecialchars($product['category']) ?></span>

                            <span class="bg-yellow-400 rounded-full flex items-center px-3 py-1 gap-2 text-white">
                                <i data-lucide="star" class="fill-white size-[18px]"></i>
                                <span class="font-semibold"><?= htmlspecialchars($product['rating']) ?></span>
                            </span>
                        </div>

                        <p class="text-lg"><?= htmlspecialchars($product['description']) ?></p>

                        <h3 class="text-4xl font-semibold flex gap-1">
                            <span>$</span>
                            <?= htmlspecialchars($product['price']) ?>
                        </h3>

                        <?php if ($user): ?>
                        <a href="./add.php?product_id=<?= urlencode($product['product_id']) ?>" class="mt-auto mb-2 w-fit relative inline-flex items-center justify-center px-10 py-3 overflow-hidden font-medium transition duration-300 ease-out border-2 border-emerald-500 rounded-md shadow-md group">
                            <span class="absolute inset-0 flex items-center justify-center w-full h-full text-white duration-300 -translate-x-full bg-emerald-500 group-hover:translate-x-0 ease">
                                <i data-lucide="arrow-right" class="size-6"></i>
                            </span>

                            <span class="absolute flex items-center justify-center gap-3 w-full h-full text-emerald-500 transition-all duration-300 transform group-hover:translate-x-full ease">
                                <i data-lucide="shopping-cart"></i>
                                Add to Cart
                            </span>

                            <span class="relative invisible flex gap-3">
                                <i data-lucide="shopping-cart"></i>
                                Add to Cart
                            </span>
                        </a>
                        <?php else: ?>
                        <a href="../sign-in/index.php" class="mt-auto mb-2 w-fit relative inline-flex items-center justify-center px-10 py-3 overflow-hidden font-medium transition duration-300 ease-out border-2 border-emerald-500 rounded-md shadow-md group">
                            <span class="absolute inset-0 flex items-center justify-center w-full h-full text-white duration-300 -translate-x-full bg-emerald-500 group-hover:translate-x-0 ease">
                                <i data-lucide="arrow-right" class="size-6"></i>
                            </span>

                            <span class="absolute flex items-center justify-center gap-3 w-full h-full text-emerald-500 transition-all duration-300 transform group-hover:translate-x-full ease">
                                <i data-lucide="log-in"></i>
                                Sign in to Buy
                            </span>

                            <span class="relative invisible flex gap-3">
                                <i data-lucide="log-in"></i>
                                Sign in to Buy
                            </span>
                        </a>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
