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
    <title>Search | GrowZone</title>

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
            <main class="h-full bg-white relative shadow-md flex gap-6 z-[1] rounded-lg p-6">
                <div class="border-2 border-neutral-300 rounded-md flex flex-col gap-6 p-6 h-full w-[400px]">
                    <h2 class="text-2xl font-semibold">Filter</h2>

                    <div class="grid gap-2">
                        <h4 class="text-lg font-semibold">Availability</h4>
                        <div class="grid gap-2 px-2">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="in-stock" value="in-stock" class="accent-indigo-400" />
                                <label for="in-stock">In Stock</label>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="out-of-stock" value="out-of-stock" class="accent-indigo-400" />
                                <label for="out-of-stock">Out of Stock</label>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <h4 class="text-lg font-semibold">Price Range</h4>
                        <div class="grid gap-2">
                            <?php

                            $stmt = $db_o->prepare('SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM products');
                            $stmt->execute();

                            $prices = $stmt->get_result()->fetch_assoc();
                            $min_price = htmlspecialchars($prices['min_price']);
                            $max_price = htmlspecialchars($prices['max_price']);

                            ?>
                            <input type="range" min="<?= $min_price ?>" max="<?= $max_price ?>" value="100" id="price" class="accent-indigo-400" />
                            <div class="flex justify-between text-sm font-medium">
                                <span>$<?= $min_price ?></span>
                                <span>$<?= $max_price ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <h4 class="text-lg font-semibold">Categories</h4>
                        <div class="grid gap-2 px-2">
                            <?php

                            $stmt = $db_o->prepare('SELECT category_id, title FROM categories ORDER BY title');
                            $stmt->execute();
                            $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                            ?>
                            <?php foreach($categories as $category): ?>
                            <div class="flex items-center gap-2">
                                <?php 
                                
                                $title = htmlspecialchars($category['title']);
                                $id = 'category-' . htmlspecialchars($category['category_id']);

                                ?>
                                <input type="checkbox" value="<?= $title ?>" id="<?= $id ?>" class="category accent-indigo-400" />
                                <label for="<?= $id ?>"><?= $category['title'] ?></label>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6 w-full">
                    <div class="relative">
                        <?php

                        $stmt = $db_o->prepare("SELECT COUNT(*) AS product_count FROM products");
                        $stmt->execute();
                        $product_count = $stmt->get_result()->fetch_assoc()['product_count'];

                        ?>
                        <input type="search" placeholder="Search <?= htmlspecialchars($product_count) ?> products ..." id="product-name" class="border-2 font-medium border-neutral-300 py-2 pl-10 pr-30 rounded-md w-full" onmouseover="this.focus()" />
                        <i data-lucide="search" class="absolute left-2.5 top-2.5 size-[24px] stroke-neutral-400"></i>

                        <button class="absolute py-1 px-2 cursor-pointer hover:brightness-95 transition right-2.5 top-1.5 bg-neutral-300 rounded-md flex gap-2 items-center">
                            <i data-lucide="arrow-down-wide-narrow" class="size-[20px]"></i>
                            <span class="font-medium">Sort by</span>
                        </button>
                    </div>

                    <div id="product-container" class="flex flex-wrap gap-4 overflow-y-scroll">
                        <!-- Products -->
                    </div>

                    <template id="product-template">
                        <a class="product-link">
                            <div class="relative w-[20rem] h-[15rem] overflow-hidden rounded-md shadow-sm cursor-pointer transition hover:shadow-md">
                                <div class="absolute inset-0 bg-gray-50 -z-[1]"></div>

                                <div class="flex flex-col justify-between p-4 h-full">
                                    <div class="flex items-center justify-between">
                                        <span class="product-category px-2 py-0.5 text-sm font-semibold bg-emerald-400/20 text-emerald-500 rounded-sm"></span>
                                        
                                        <span data-available class="product-availability data-available:hidden px-2 py-1 flex items-center gap-1 text-xs font-semibold bg-red-400/20 text-red-500 rounded-sm">
                                            <span class="product-x-icon size-[12px] stroke-3"></span>
                                            <span>Not Available</span>
                                        </span>
                                    </div>
                                    <div class="grid gap-1">
                                        <div class="flex items-center justify-between font-semibold">
                                            <span class="product-title text-lg"></span>
                                            <span class="product-price text-xl"></span>
                                        </div>

                                        <div class="flex justify-between gap-2">
                                            <span class="product-description text-sm text-neutral-600"></span>
                                            <span class="bg-yellow-400 rounded-full flex items-center px-2 py-0.5 gap-1 text-white h-min">
                                                <span class="product-star-icon fill-white size-[14px]"></span>
                                                <span class="product-rating text-sm font-semibold"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </main>
        </div>
    </div>

    <i id="star-icon" data-lucide="star" class="hidden"></i>
    <i id="x-icon" data-lucide="x" class="hidden"></i>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
