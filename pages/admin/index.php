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

if (!$user || !$user['is_admin']) {
    header("Location: ../home/index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script type="importmap">
        {
            "imports": {
                "chart.js": "https://cdn.jsdelivr.net/npm/chart.js@4.4.9/+esm"
            }
        }
    </script>
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

                <div class="relative group">
                    <button class="size-10 cursor-pointer relative">
                        <span class="avatar [--primary:var(--color-neutral-300)] bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 font-bold text-white size-full rounded-full grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                        <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                            <i data-lucide="chevron-down" class="size-[14px]"></i>
                        </div>
                    </button>

                    <div class="absolute z-[2] -right-4 invisible group-hover:visible min-w-[15rem]">
                        <div class="bg-transparent h-4"></div>
                        <div class="group-hover:scale-y-100 group-hover:opacity-100 opacity-0 scale-y-0 origin-top transition grid px-2 py-4 rounded-md bg-white shadow-md">
                            <div class="flex items-center gap-3 px-4">
                                <span class="avatar [--primary:var(--color-neutral-300)] bg-[var(--primary)] ring-2 ring-[var(--primary)]/50 animate-pulse text-white font-bold rounded-full size-9 grid place-items-center" data-first-name="<?= htmlspecialchars($user['first_name']) ?>" data-last-name="<?= htmlspecialchars($user['last_name']) ?>">-</span>
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></span>
                                    <span class="text-xs"><?= htmlspecialchars($user['email']) ?></span>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-2">
                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <a href="../admin/index.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-emerald-200"><i data-lucide="shield-user" class="size-5"></i>Admin Panel</a>

                                <a href="../history/index.php?type=list&page=1" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="history" class="size-5"></i>History</a>
                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="settings" class="size-5"></i>Settings</button>

                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <a href="../../php/logout.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-red-200"><i data-lucide="log-out" class="size-5"></i>Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="px-8 pb-8 pt-2 h-[calc(100dvh_-_74px)]">
            <?php

            $tab = $_GET['tab'] ?? null;

            if ($tab != 'orders' && $tab != 'products' && $tab != 'images') {
                $tab = 'users';
            }

            ?>
            <main data-tab="<?= $tab ?>" id="main-container" class="h-full bg-white relative shadow-md flex gap-12 rounded-lg p-8">
                <div class="flex flex-col gap-1">
                    <a href="?tab=users" <?= $tab == 'users' ? 'data-active' : '' ?> class="flex items-center gap-3 pl-3 pr-6 py-2 rounded-md font-medium transition data-active:bg-emerald-400/20 hover:bg-emerald-400/20">
                        <i data-lucide="users-round" class="size-[20px]"></i>
                        Manage Users
                    </a>

                    <a href="?tab=orders" <?= $tab == 'orders' ? 'data-active' : '' ?> class="flex items-center gap-3 pl-3 pr-6 py-2 rounded-md font-medium transition data-active:bg-emerald-400/20 hover:bg-emerald-400/20">
                        <i data-lucide="shopping-cart" class="size-[20px]"></i>
                        Manage Orders
                    </a>

                    <a href="?tab=products" <?= $tab == 'products' ? 'data-active' : '' ?> class="flex items-center gap-3 pl-3 pr-6 py-2 rounded-md font-medium transition data-active:bg-emerald-400/20 hover:bg-emerald-400/20">
                        <i data-lucide="sprout" class="size-[20px]"></i>
                        Manage Products
                    </a>

                    <a href="?tab=images" <?= $tab == 'images' ? 'data-active' : '' ?> class="flex items-center gap-3 pl-3 pr-6 py-2 rounded-md font-medium transition data-active:bg-emerald-400/20 hover:bg-emerald-400/20">
                        <i data-lucide="image" class="size-[20px]"></i>
                        Uploaded Images
                    </a>

                    <button disabled id="save-changes" class="mt-6 flex items-center gap-3 pl-3 pr-6 py-2 rounded-md font-medium transition bg-amber-400/20 disabled:opacity-50 not-disabled:cursor-pointer not-disabled:hover:bg-amber-400/30">
                        <i data-lucide="file-up" class="size-[20px]"></i>
                        Save Changes
                    </button>

                    <div class="mt-auto flex flex-col gap-4">
                        <?php if($tab == 'users'): ?>
                        <?php
                        
                        $stmt = $db_o->prepare('SELECT SUM(IF(is_admin = FALSE, 1, 0)) AS users, SUM(IF(is_admin = TRUE, 1, 0)) AS admins FROM users ORDER BY user_id');
                        $stmt->execute();

                        $data = $stmt->get_result()->fetch_assoc();

                        ?>
                        <canvas data-users="<?= htmlspecialchars($data['users']) ?>" data-admins="<?= htmlspecialchars($data['admins']) ?>" id="users-chart" class="w-0"></canvas>
                        <?php elseif($tab == 'orders'): ?>
                        <?php

                        $stmt = $db_o->prepare('SELECT order_id, SUM(price * quantity) AS cost, AVG(price) AS average_cost FROM orders JOIN order_items USING (order_id) JOIN products USING (product_id) GROUP BY order_id ORDER BY order_id');
                        $stmt->execute();

                        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                        $stmt = $db_o->prepare('SELECT AVG(order_total) AS average_order FROM (SELECT SUM(price * quantity) AS order_total FROM orders JOIN order_items USING (order_id) JOIN products USING (product_id) GROUP BY order_id) AS order_totals');
                        $stmt->execute();

                        $average_order = $stmt->get_result()->fetch_assoc()['average_order'];

                        for ($i = 0; $i < count($data); ++$i) {
                            $data[$i]['average_order'] = $average_order;
                        }

                        ?>
                        <canvas data-orders='<?= json_encode($data) ?>' id="orders-chart" class="w-0 h-[15rem]"></canvas>
                        <?php elseif($tab == 'products'): ?>
                        <?php

                        $stmt = $db_o->prepare('SELECT product_id, ROUND(AVG(rating), 2) AS rating FROM products JOIN reviews USING (product_id) GROUP BY product_id ORDER BY product_id');
                        $stmt->execute();

                        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                        $stmt = $db_o->prepare('SELECT AVG(rating) AS average_rating FROM reviews');
                        $stmt->execute();

                        $average_rating = $stmt->get_result()->fetch_assoc()['average_rating'];

                        for ($i = 0; $i < count($data); ++$i) {
                            $data[$i]['average_rating'] = $average_rating;
                        }

                        ?>
                        <canvas data-products='<?= json_encode($data) ?>' id="products-chart" class="w-0 h-[15rem]"></canvas>
                        <?php endif ?>
                    </div>
                </div>

                <div class="relative flex flex-col gap-8 grow">
                    <?php if($tab == 'users'): ?>
                    <?php

                    $stmt = $db_o->prepare('SELECT user_id, first_name, last_name, email, is_admin FROM users ORDER BY user_id');
                    $stmt->execute();

                    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $userCount = count($users);

                    ?>
                    <h2 class="flex justify-center items-center gap-4 text-3xl font-semibold">
                        <span>Inspecting "Users"</span>
                        <span>&RightAngleBracket;</span>
                        <span><?= htmlspecialchars($userCount) ?> records</span>
                    </h2>

                    <div class="grid overflow-y-scroll no-scrollbar pb-4">
                        <div class="flex border-t font-semibold bg-emerald-50">
                            <div class="border-l py-2 w-[6rem] text-center">User ID</div>
                            <div class="border-l py-2 basis-0 grow text-center">First name</div>
                            <div class="border-l py-2 basis-0 grow text-center">Last name</div>
                            <div class="border-l py-2 basis-0 grow-[1.5] text-center">Email</div>
                            <div class="border-l py-2 w-[5rem] text-center">Admin</div>
                            <div class="border-x py-2 w-[5rem] text-center">Delete</div>
                        </div>

                        <?php foreach($users as $user): ?>
                        <div data-id="<?= htmlspecialchars($user['user_id']) ?>" class="record flex border-t last:border-b odd:bg-emerald-50">
                            <div class="border-l w-[6rem] grid place-items-center font-medium"><?= htmlspecialchars($user['user_id']) ?></div>
                            <div class="border-l basis-0 grow">
                                <input type="text" name="first-name" placeholder="First name" value="<?= htmlspecialchars($user['first_name']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l basis-0 grow">
                                <input type="text" name="last-name" placeholder="Last name" value="<?= htmlspecialchars($user['last_name']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l basis-0 grow-[1.5]">
                                <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l w-[5rem] grid place-items-center">
                                <input type="checkbox" name="is-admin" <?= $user['is_admin'] ? 'checked' : '' ?> />
                            </div>
                            <div class="border-x w-[5rem] grid place-items-center">
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <?php elseif($tab == 'orders'): ?>
                    <?php

                    $stmt = $db_o->prepare('SELECT order_id, first_name, last_name, order_date, delivered, delivery_date FROM orders JOIN users USING (user_id) ORDER BY order_id');
                    $stmt->execute();

                    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $ordersCount = count($orders);

                    ?>
                    <h2 class="flex justify-center items-center gap-4 text-3xl font-semibold">
                        <span>Inspecting "Orders"</span>
                        <span>&RightAngleBracket;</span>
                        <span><?= htmlspecialchars($ordersCount) ?> records</span>
                    </h2>

                    <div class="grid overflow-y-scroll no-scrollbar pb-4">
                        <div class="flex border-t font-semibold bg-emerald-50">
                            <div class="border-l py-2 w-[6rem] text-center">Order ID</div>
                            <div class="border-l py-2 basis-0 grow text-center">First name</div>
                            <div class="border-l py-2 basis-0 grow text-center">Last name</div>
                            <div class="border-l py-2 basis-0 grow-2 text-center">Order date</div>
                            <div class="border-l py-2 w-[6rem] text-center">Delivered</div>
                            <div class="border-l py-2 basis-0 grow-2 text-center">Delivery date</div>
                            <div class="border-x py-2 w-[5rem] text-center">Delete</div>
                        </div>

                        <?php foreach($orders as $order): ?>
                        <div data-id="<?= htmlspecialchars($order['order_id']) ?>" class="record flex border-t last:border-b odd:bg-emerald-50">
                            <div class="border-l w-[6rem] grid place-items-center font-medium"><?= htmlspecialchars($order['order_id']) ?></div>
                            <div class="border-l basis-0 grow grid place-items-center"><?= htmlspecialchars($order['first_name']) ?></div>
                            <div class="border-l basis-0 grow grid place-items-center"><?= htmlspecialchars($order['last_name']) ?></div>
                            <div class="border-l basis-0 grow-2">
                                <input type="date" name="order-date" placeholder="Order date" value="<?= htmlspecialchars($order['order_date']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l w-[6rem] grid place-items-center">
                                <input type="checkbox" name="delivered" <?= $order['delivered'] ? 'checked' : '' ?> />
                            </div>
                            <div class="border-l basis-0 grow-2">
                                <input type="date" name="delivery-date" placeholder="Delivery date" value="<?= htmlspecialchars($order['delivery_date']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-x w-[5rem] grid place-items-center">
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <?php elseif($tab == 'products'): ?>
                    <?php

                    $stmt = $db_o->prepare('SELECT product_id, title, price, description, in_stock FROM products ORDER BY product_id');
                    $stmt->execute();

                    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $productsCount = count($products);

                    ?>
                    <h2 class="flex justify-center items-center gap-4 text-3xl font-semibold">
                        <span>Inspecting "Products"</span>
                        <span>&RightAngleBracket;</span>
                        <span><?= htmlspecialchars($productsCount) ?> records</span>
                    </h2>

                    <div class="grid overflow-y-scroll no-scrollbar pb-4">
                        <div class="flex border-t font-semibold bg-emerald-50">
                            <div class="border-l py-2 w-[6rem] text-center">Product ID</div>
                            <div class="border-l py-2 basis-0 grow-2 text-center">Title</div>
                            <div class="border-l py-2 basis-0 grow text-center">Price</div>
                            <div class="border-l py-2 basis-0 grow-3 text-center">Description</div>
                            <div class="border-l py-2 w-[5rem] text-center">In stock</div>
                            <div class="border-x py-2 w-[5rem] text-center">Delete</div>
                        </div>

                        <?php foreach($products as $product): ?>
                        <div data-id="<?= htmlspecialchars($product['product_id']) ?>" class="record flex border-t last:border-b odd:bg-emerald-50">
                            <div class="border-l w-[6rem] grid place-items-center font-medium"><?= htmlspecialchars($product['product_id']) ?></div>
                            <div class="border-l basis-0 grow-2">
                                <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($product['title']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l basis-0 grow">
                                <input type="number" name="price" min="0" step="0.01" placeholder="Price" value="<?= htmlspecialchars($product['price']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l basis-0 grow-3">
                                <input type="text" name="description" placeholder="Description" value="<?= htmlspecialchars($product['description']) ?>" class="px-3 py-2 w-full" />
                            </div>
                            <div class="border-l w-[5rem] grid place-items-center">
                                <input type="checkbox" name="in-stock" <?= $product['in_stock'] ? 'checked' : '' ?> />
                            </div>
                            <div class="border-x w-[5rem] grid place-items-center">
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <?php elseif($tab == 'images'): ?>
                    <button id="image-upload-button" class="border-gray-300 flex cursor-pointer flex-col items-center rounded-md border-2 border-dashed py-8 hover:bg-gray-50/50">
                        <div class="bg-green-100 rounded-lg p-4">
                            <i data-lucide="upload" class="size-[36px] stroke-lime-600"></i>
                        </div>
                        <span class="font-medium mt-6">Drop your images here, or <span class="text-emerald-500">browse</span></span>
                        <span class="text-xs text-neutral-600 mt-2">Supports PNG, JPG & WEBP up to any size</span>
                    </button>

                    <div class="grid gap-4 overflow-y-scroll pb-4 no-scrollbar">
                        <?php for ($i = 0; $i < 10; ++$i): ?>
                        <div class="flex items-center gap-4 px-6 py-4 rounded-md bg-gray-100">
                            <img src="../../public/images/png-file.png" width="42" alt="png file" />

                            <div class="grid gap-0.5">
                                <span class="text-sm font-semibold">Picture name.png</span>
                                <span class="text-sm text-neutral-600">200 KB</span>
                            </div>

                            <div class="ml-auto flex items-center gap-4">
                                <span class="font-medium">2024-06-04</span>
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 px-6 py-4 rounded-md bg-gray-100">
                            <img src="../../public/images/jpg-file.png" width="42" alt="jpg file" />

                            <div class="grid gap-0.5">
                                <span class="text-sm font-semibold">Picture name.jpg</span>
                                <span class="text-sm text-neutral-600">200 KB</span>
                            </div>

                            <div class="ml-auto flex items-center gap-4">
                                <span class="font-medium">2024-06-04</span>
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 px-6 py-4 rounded-md bg-gray-100">
                            <img src="../../public/images/webp-file.png" width="42" alt="webp file" />

                            <div class="grid gap-0.5">
                                <span class="text-sm font-semibold">Picture name.webp</span>
                                <span class="text-sm text-neutral-600">200 KB</span>
                            </div>

                            <div class="ml-auto flex items-center gap-4">
                                <span class="font-medium">2024-06-04</span>
                                <button class="delete p-1.5 cursor-pointer hover:bg-red-300 transition rounded-md bg-red-400">
                                    <i data-lucide="trash-2" class="size-[18px] stroke-white"></i>
                                </button>
                            </div>
                        </div>
                        <?php endfor ?>
                    </div>
                    <?php endif ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>