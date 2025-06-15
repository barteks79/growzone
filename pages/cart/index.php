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
    header("Location: ../sign-in/index.php");
    exit();
}

$stmt = $db_o->prepare('SELECT * FROM carts WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart | GrowZone</title>

    <link rel="shortcut icon" href="../../public/images/icon.png" />
    <link rel="stylesheet" href="./styles.css" />

    <script src="https://unpkg.com/@tailwindcss/browser@4.1.7"></script>
    <script src="https://unpkg.com/lucide@0.511.0"></script>
    <script src="./script.js" type="module" defer></script>
</head>
<body class="font-[Inter]">
    <div class="relative min-h-dvh">
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
                </div>
            </nav>
            
            <main class="flex justify-center items-center mt-10">
                <div class="flex flex-col gap-3 bg-white rounded-xl shadow-lg py-4 px-10 max-w-[1100px] w-2/3 min-w-[950px]">                
                    <?php 
                        if (!isset($_GET['strona'])) { 
                            $nastepna_strona = 'dostawa'; 
                        } else if ($_GET['strona'] === 'dostawa') { 
                            $nastepna_strona ='podsumowanie'; 
                        } else if ($_GET['strona'] === 'podsumowanie') {
                            $nastepna_strona = 'platnosc';
                        } 
                    ?>    
                    <menu class="flex items-center gap-10 py-6 border-b border-gray-300">
                        <div class="flex items-center gap-5">
                            <div <?php if ($nastepna_strona === 'podsumowanie' || $nastepna_strona === 'platnosc') echo 'data-done' ?> data-active class="group grid place-items-center aspect-square shadow-xl bg-gray-600 data-active:bg-emerald-500 h-10 rounded-xl text-white">
                                <p class="group-data-done:hidden">1</p>
                                <i data-lucide="check" class="hidden group-data-done:block"></i>
                            </div>
                            <p class="text-xl font-medium">Koszyk i dostawa</p>
                        </div>
                        
                        <div class="h-[1px] flex-1 bg-gray-400 rounded-md"></div>
                        
                        <div class="flex items-center gap-5">
                            <div <?php if ($nastepna_strona === 'podsumowanie' || $nastepna_strona === 'platnosc') echo 'data-active' ?> <?php if ($nastepna_strona === 'platnosc') echo 'data-done' ?> class="group grid place-items-center aspect-square shadow-xl bg-gray-600 data-active:bg-emerald-500 h-10 rounded-xl text-white">
                                <p class="group-data-done:hidden">2</p>
                                <i data-lucide="check" class="hidden group-data-done:block"></i>
                            </div>
                            <p class="text-xl font-medium">Dane dostawy</p>
                        </div>
                        
                        <div class="h-[1px] flex-1 bg-gray-400 rounded-md"></div>
                        
                        <div class="flex items-center gap-5">
                            <div <?php if ($nastepna_strona === 'platnosc') echo 'data-active' ?>  class="group grid place-items-center aspect-square shadow-xl bg-gray-600 data-active:bg-emerald-500 h-10 rounded-xl text-white">
                                <p class="group-data-done:hidden">3</p>
                                <i data-lucide="check" class="hidden group-data-done:block"></i>
                            </div>
                            <p class="text-xl font-medium">Podsumowanie</p>
                        </div>
                    </menu>
                    
                    <?php if (!isset($_GET['strona'])): ?>
                        <section id="cart_section" class="flex flex-col gap-8 py-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-3xl font-medium">Twój koszyk</h3>
                                <div class="flex gap-4 items-center">
                                    <p class="flex items-center gap-1 text-lg font-semibold"><span id="cart_value_span">
                                    <?php
                                        if (isset($cart['cart_id'])) {
                                            $cart_id = $cart['cart_id'];
                                            $stmt = $db_o->prepare('SELECT SUM(ci.quantity * p.price) AS wartosc FROM carts c JOIN cart_items ci ON c.cart_id = ci.cart_id JOIN  products p ON ci.product_id = p.product_id WHERE c.cart_id = ?');
                                            $stmt->bind_param('i', $cart_id);
                                            $stmt->execute();
                                            $cart_value = $stmt->get_result()->fetch_assoc()['wartosc'];
                                            echo htmlspecialchars(number_format($cart_value, 2));
                                        } else {
                                            echo htmlspecialchars(number_format(0, 2));
                                        }
                                    ?></span> PLN</p>
                                    <button id="clear_cart" class="grid place-items-center border border-gray-400 size-8 rounded-md cursor-pointer">
                                        <i data-lucide="trash" class="size-4 font-normal pointer-events-none"></i>
                                    </button>
                                </div>
                            </div>

                            <?php
                                $cart_items = [];

                                if (isset($cart['cart_id'])) { 
                                    $cart_id = $cart['cart_id'];
                                    $stmt = $db_o->prepare('SELECT _ci.quantity, _p.* FROM cart_items _ci INNER JOIN products _p ON _ci.product_id = _p.product_id WHERE cart_id = ?');
                                    $stmt->bind_param('i', $cart_id);
                                    $stmt->execute();
                                    $cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                }
                            ?>

                            <ul class="flex flex-col gap-3">
                                <?php foreach ($cart_items as $cart_item) { ?>
                                <li data-product-price="<?= htmlspecialchars($cart_item['price']) ?>" data-product-id="<?= htmlspecialchars($cart_item['product_id']) ?>" class="flex items-center justify-between">
                                    <div class="flex gap-5">
                                        <div class="size-16 bg-gray-400 rounded-sm"></div>
                                        
                                        <div class="flex flex-col justify-center">
                                            <h2 class="text-3xl"><?= htmlspecialchars($cart_item['title']) ?></h2>
                                            <p class="uppercase">kod produktu: <span>000000</span></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-7">
                                        <div class="flex gap-4 pl-8 items-center">
                                            <p data-price="true" class="text-lg font-semibold"><span><?= htmlspecialchars(number_format($cart_item['price'] * $cart_item['quantity'], 2)) ?></span> PLN</p>
                                        </div>
                                        
                                        <div class="flex items-center border border-gray-400 rounded-md">
                                            <button data-action="increase" class="grid place-items-center cursor-pointer border-r border-gray-400 size-8">
                                                <i data-lucide="plus" class="size-4 font-normal pointer-events-none"></i>
                                            </button>
                                            
                                            <input disabled value="<?= htmlspecialchars($cart_item['quantity']) ?>" class="text-center size-8 text-sm" />
                                            
                                            <button data-action="decrease" class="grid place-items-center cursor-pointer border-l border-gray-400 size-8">
                                                <i data-lucide="minus" class="size-4 font-normal pointer-events-none"></i>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <?php }; ?>
                                <!-- koniec pętli wyświetlającej produkty w koszyku -->
                            </ul>

                            <p <?php if (count($cart_items) === 0) echo "data-shown"; ?> class="hidden text-center text-gray-600 data-shown:inline" id="cart_text">Nie masz żadnych produktów w koszyku</p>
                        </section>

                        <section class="flex flex-col gap-8 py-4">
                            <h2 class="text-3xl font-medium">Dostawa</h3>

                            <div id="shipping_companies" class="grid grid-cols-4 gap-5">
                                <article <?php if ($_SESSION['company'] === 'inpost') echo 'data-selected'; ?> data-company="inpost" class="flex flex-col items-center justify-center aspect-square border border-gray-300 rounded-lg data-selected:border-3 data-selected:border-gray-400 not-data-selected:cursor-pointer">
                                    <img src="../../public/images/inpost.jpg" alt="Inpost Logo" class="h-24 pointer-events-none" />    
                                </article>

                                <article <?php if ($_SESSION['company'] === 'dpd') echo 'data-selected'; ?> data-company="dpd" class="flex flex-col items-center justify-center aspect-square border border-gray-300 rounded-lg data-selected:border-3 data-selected:border-gray-400 not-data-selected:cursor-pointer">
                                    <img src="../../public/images/dpd.jpg" alt="DPD Logo" class="h-24 pointer-events-none" />    
                                </article>

                                <article <?php if ($_SESSION['company'] === 'poczta_polska') echo 'data-selected'; ?> data-company="poczta_polska" class="flex flex-col items-center justify-center aspect-square border border-gray-300 rounded-lg data-selected:border-3 data-selected:border-gray-400 not-data-selected:cursor-pointer">
                                    <img src="../../public/images/poczta_polska.png" alt="Pocza Polska Logo" class="h-24 pointer-events-none" />    
                                </article>

                                <article <?php if ($_SESSION['company'] === 'dhl') echo 'data-selected'; ?> data-company="dhl" class="flex flex-col items-center justify-center aspect-square border border-gray-300 rounded-lg data-selected:border-3 data-selected:border-gray-400 not-data-selected:cursor-pointer">
                                    <img src="../../public/images/dhl.jpg" alt="DHL Logo" class="h-24 pointer-events-none" />    
                                </article>
                            </div>
                        </section>

                    <?php endif; ?> 
                    <!-- koniec sekcji koszyk i dostawa -->

                    <?php if ($nastepna_strona === 'podsumowanie'): ?>
                        <section id="sekcja_dostawy" class="flex flex-col gap-8 py-4">
                            <h2 class="text-3xl font-medium">Dane Dostawy</h2>
                            <div class="grid grid-cols-2 gap-5">
                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Kraj<span class="text-red-500 ml-1">*<span></label>
                                    <select class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black">
                                        <option disabled selected value="">Wybierz kraj</option>
                                        <option value="pl">Polska</option>
                                        <option value="ne">Niger</option>
                                    </select>
                                </div>

                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Miasto<span class="text-red-500 ml-1">*<span></label>
                                    <input name="miasto" placeholder="Warszawa" class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black" />
                                </div>
                                
                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Ulica<span class="text-red-500 ml-1">*<span></label>
                                    <input name="ulica" placeholder="Polna" class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black" />
                                </div>

                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Kod pocztowy<span class="text-red-500 ml-1">*<span></label>
                                    <input name="kod_pocztowy" placeholder="00-000" class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black" />
                                </div>

                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Numer budynku<span class="text-red-500 ml-1">*<span></label>
                                    <input name="budynek" placeholder="7" class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black" />
                                </div>
                                
                                <div class="flex flex-col w-full gap-1 text-gray-700">
                                    <label>Numer mieszkania</label>
                                    <input data-optional class="flex-1 border px-4 py-2 rounded-md border-gray-400 text-black" />
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <menu class="flex items-center justify-end gap-5">
                        <?php if ($nastepna_strona !== 'dostawa'): ?>
                            <button data-previous="<?php 
                                    if ($nastepna_strona === "podsumowanie") echo "index";
                                    if ($nastepna_strona === "platnosc") echo "dostawa";
                                ?>" class="px-12 py-2 rounded-md border border-gray-300 cursor-pointer hover:bg-gray-200/50" id="previousBtn">Wróć</button>
                        <?php endif; ?>
    
                        <?php if ($nastepna_strona === 'dostawa'): ?>
                            <button disabled data-next="<?= $nastepna_strona ?>" class="bg-emerald-600 text-white px-12 not-disabled:cursor-pointer disabled:opacity-50 not-disabled:hover:bg-emerald-700 py-2 rounded-md" id="nextBtnKoszyk">Dalej</button>
                        <?php endif; ?>

                        <?php if ($nastepna_strona === 'podsumowanie'): ?>
                            <button disabled data-next="<?= $nastepna_strona ?>" class="bg-emerald-600 text-white px-12 not-disabled:cursor-pointer disabled:opacity-50 not-disabled:hover:bg-emerald-700 py-2 rounded-md" id="nextBtnDostawa">Dalej</button>
                        <?php endif; ?>
                    </menu>
                </div>
            </div>
        </div>
        
    <script src="./actions.js"></script>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>