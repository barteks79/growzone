<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Grow Zone</title>

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
<body class="font-[Sofia_Pro]">
    <div class="relative h-dvh">
        <div class="primary-radial-background absolute inset-0 -z-[2]"></div>
        <canvas id="introduction-canvas" class="absolute size-full -z-[1] data-focus:z-10"></canvas>

        <nav class="px-[5vw] py-6 grid place-items-center grid-cols-3">
            <div class="justify-self-start">
                <a href="#" class="drop-shadow-2xl drop-shadow-emerald-400 transition duration-200 hover:drop-shadow-lime-400">
                    <img src="../../public/images/icon.png" alt="growzone icon" width="42" />
                </a>
            </div>

            <div class="justify-self-center flex gap-10 font-medium uppercase *:hover:text-emerald-600 *:transition-colors drop-shadow-2xl">
                <a href="../home/index.php">Home</a>
                <a href="../plants/index.php">Plants</a>
                <a href="#">Tools</a>
                <a href="#">Sale</a>
                <a href="#">Seasonal</a>
            </div>

            <div class="justify-self-end flex gap-8">
                <button class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer">
                    <i data-lucide="search" class="size-full"></i>
                </button>

                <button class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer">
                    <i data-lucide="shopping-cart" class="size-full"></i>
                </button>

                <button class="size-10 cursor-pointer relative">
                    <span class="bg-orange-400 text-lg pt-1 font-bold text-white size-full rounded-full grid place-items-center">PL</span>
                    <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                        <i data-lucide="chevron-down" class="size-[14px]"></i>
                    </div>
                </button>
            </div>
        </nav>

        <div class="mt-[60px] ml-[100px]">
            <h2 class="animate-[enter-header_1000ms_ease-out] select-none grid gap-4 font-[GT_Walsheim_Pro] text-8xl text-[#2D2946]">
                <span>Nature your garden</span>
                <span>with <span id="header-product-text" class="pb-2 text-emerald-400 text-shadow-[0_6px_var(--color-emerald-700)] overflow-clip">Growzone</span></span>
            </h2>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
