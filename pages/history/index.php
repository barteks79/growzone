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


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $pg = (int)$_GET['page'];
    if ($pg < 1) {
        $pg = 1;
    }
    $offset = ($pg - 1) * 10;
} else {
    $pg = 1;
}

$stmt = $db_o->prepare('SELECT orders.order_date, IF(orders.delivered = 1, "Delivered", "Not Delivered"), order_addresses.street, order_addresses.building_number, order_addresses.apartment_number, order_addresses.city, order_addresses.postal_code, order_addresses.country, IF(orders.delivery_date IS NOT NULL, orders.delivery_date, "On The Way") as "status_dostawy", orders.order_id from orders inner join order_addresses on orders.order_address_id = order_addresses.order_address_id WHERE orders.user_id = ? ORDER BY orders.order_date DESC LIMIT 10 OFFSET ?');
if (!$stmt) {
    die("Query preparation failed: " . $db_o->error);
}
$stmt->bind_param('ii', $user['user_id'], $offset);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>History | GrowZone</title>

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
                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="settings" class="size-5"></i>Settings</button>

                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <a href="../../php/logout.php" class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-red-200"><i data-lucide="log-out" class="size-5"></i>Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    <?php if($result->num_rows == 0) : ?>
        <div class="flex justify-center items-center mt-10 px-4">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-5xl">
                <h1 class="text-3xl font-bold text-center mb-4">Your History</h1>
                <p class="text-center text-gray-600 mb-6">You have no orders.</p>
            </div>
        </div>
    <?php elseif(isset($_GET['type']) && $_GET['type'] == 'list' && $result->num_rows > 0) : ?>
    <div class="flex justify-center items-center mt-10 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-5xl">
            <h1 class="text-3xl font-bold text-center mb-4">Your History</h1>
            <p class="text-center text-gray-600 mb-6">Here you can view your past activities and orders.</p>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-neutral-700 text-sm text-left rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-black px-4 py-2">Order Date</th>
                            <th class="border border-black px-4 py-2">Status</th>
                            <th class="border border-black px-4 py-2">Shipping Address</th>
                            <th class="border border-black px-4 py-2">Delivery Date</th>
                            <th class="border border-black px-4 py-2">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($row = $result->fetch_row()) {
                            echo '<tr>';
                            echo '<td class="border border-black px-4 py-2">' . htmlspecialchars($row[0]) . '</td>';
                            echo '<td class="border border-black px-4 py-2">' . htmlspecialchars($row[1]) . '</td>';
                            echo '<td class="border border-black px-4 py-2">' .
                                htmlspecialchars($row[2]) . ' ' . htmlspecialchars($row[3]) .
                                (isset($row[4]) ? '/' . htmlspecialchars($row[4]) : '') . ', ' .
                                htmlspecialchars($row[5]) . ', ' . htmlspecialchars($row[6]) . ', ' . htmlspecialchars($row[7]) .
                                '</td>';
                            echo '<td class="border border-black px-4 py-2">' . htmlspecialchars($row[8]) . '</td>';
                            echo '<td class="border border-black px-4 py-2"><a href="index.php?type=details&dtid=' . $row[9] . '" class="hover:text-black transition-colors rounded-lg hover:bg-gray-200 px-2 py-1">See Details</a></td>';
                            echo '</tr>';
                        }
                        
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                <?php
                $stmt = $db_o->prepare('SELECT COUNT(*) FROM orders WHERE user_id = ?');
                $stmt->bind_param('i', $user['user_id']);
                $stmt->execute();
                $count_result = $stmt->get_result();
                $total_orders = $count_result->fetch_row()[0];
                $total_pages = ceil($total_orders / 10);
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $pg) {
                        echo '<span class="px-2 py-1 bg-green-300 rounded-md">' . $i . '</span> ';
                    } else {
                        echo '<a href="index.php?type=list&page=' . $i . '" class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300 transition">' . $i . '</a> ';
                    }
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['type']) && $_GET['type'] == 'details' && isset($_GET['dtid']) && is_numeric($_GET['dtid'])) : ?>
    <?php
    $dtid = $_GET['dtid'];
    $stmt = $db_o->prepare('SELECT products.title, order_items.quantity, products.price*order_items.quantity FROM products inner join order_items on products.product_id = order_items.product_id WHERE order_items.order_id = ?');
    if (!$stmt) {
        die("Query preparation failed: " . $db_o->error);
    }
    $stmt->bind_param('i', $dtid);
    $stmt->execute();
    $result = $stmt->get_result();

    ?>
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-5xl mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold text-center mb-4">Your Delivery Details</h1><br>
    <div class="flex justify-evenly gap-10">
        <div class="overflow-x-auto w-1/2">
            <table class="table-auto w-full text-sm text-left rounded-xl overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Product Name</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_row()) {
                        echo '<tr>';
                        echo '<td class="px-4 py-2">' . htmlspecialchars($row[0]) . '</td>';
                        echo '<td class="px-4 py-2">' . htmlspecialchars($row[1]) . '</td>';
                        echo '<td class="px-4 py-2">' . htmlspecialchars($row[2]) . 'zł</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        $stmt = $db_o->prepare('SELECT order_addresses.street, order_addresses.building_number, order_addresses.apartment_number, order_addresses.city, order_addresses.postal_code, order_addresses.country from order_addresses inner join orders on order_addresses.order_address_id = orders.order_address_id WHERE orders.order_id = ?');
        if (!$stmt) {
            die("Query preparation failed: " . $db_o->error);
        }
        $stmt->bind_param('i', $dtid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        ?>
        <div class="max-w-[35%] flex flex-col justify-start">
            <h2 class="text-2xl font-semibold mb-4">Buyer Information:</h2>
            <p>
                Name: <?= htmlspecialchars($user['first_name']) ?><br>
                Surname: <?= htmlspecialchars($user['last_name']) ?><br><br>
            </p>
            <h2 class="text-2xl font-semibold mb-4">Address:</h2>
            <p>
                Street: <?= htmlspecialchars($row[0]) . " " . htmlspecialchars($row[1]) . (isset($row[2]) ? '/' . htmlspecialchars($row[2]) : '')?><br>
                <?= htmlspecialchars($row[4]) . " " . htmlspecialchars($row[3])?><br>
                <?= htmlspecialchars($row[5]) ?> <br><br>
            </p>
            <h2 class="text-2xl font-semibold mb-4">Pay Type:</h2>
            <p>
                Bank: Nexus Bank
            </p>
        </div>
    </div>
</div>
    <?php endif; ?>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
