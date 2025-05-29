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
        <canvas id="introduction-canvas" class="absolute size-full -z-[1] data-focus:z-[1]"></canvas>

        <nav class="px-[5vw] py-6 grid place-items-center grid-cols-3">
            <div class="justify-self-start">
                <a href="#" class="drop-shadow-2xl drop-shadow-emerald-400 transition duration-200 hover:drop-shadow-lime-400">
                    <img src="../../public/images/icon.png" alt="growzone icon" width="42" />
                </a>
            </div>

            <div class="justify-self-center flex gap-10 font-medium uppercase *:hover:text-emerald-400 *:transition-colors drop-shadow-2xl">
                <a href="../home/index.php">Home</a>
                <a href="../plants/index.php">Plants</a>
                <a href="#">Tools</a>
                <a href="#">Sale</a>
                <a href="#">Seasonal</a>
            </div>

            <div class="justify-self-end flex gap-8">
                <button class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="search" class="size-full transition"></i>
                </button>

                <button class="size-10 p-2.5 grid place-items-center bg-white rounded-full cursor-pointer transition hover:bg-black hover:*:stroke-white">
                    <i data-lucide="shopping-cart" class="size-full transition"></i>
                </button>

                <div class="relative group">
                    <button class="size-10 cursor-pointer relative">
                        <span class="bg-orange-400 font-bold text-white size-full rounded-full grid place-items-center">PL</span>
                        <div class="absolute bg-white p-0.5 rounded-full grid place-items-center -bottom-1.5 -right-1">
                            <i data-lucide="chevron-down" class="size-[14px]"></i>
                        </div>
                    </button>

                    <div class="absolute z-[2] -right-4 invisible group-hover:visible">
                        <div class="bg-transparent h-4"></div>
                        <div class="group-hover:scale-y-100 group-hover:opacity-100 opacity-50 scale-y-0 origin-top transition grid px-2 py-4 rounded-md bg-white shadow-md">
                            <div class="flex items-center gap-2 px-4">
                                <span class="bg-orange-400 text-white font-bold rounded-full size-9 grid place-items-center">PL</span>
                                <div class="flex flex-col items-start">
                                    <span class="text-sm font-medium">Piotr Lesiak</span>
                                    <span class="text-xs">piotrlesiak12@gmail.com</span>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-2">
                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-emerald-200"><i data-lucide="shield-user" class="size-5"></i>Admin Panel</button>
                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="history" class="size-5"></i>History</button>
                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-neutral-200"><i data-lucide="settings" class="size-5"></i>Settings</button>

                                <span class="w-full h-[2px] rounded-full bg-black/20"></span>

                                <button class="px-4 py-1.5 mx-2 flex items-center gap-3 font-medium rounded-md transition duration-100 cursor-pointer hover:bg-red-200"><i data-lucide="log-out" class="size-5"></i>Log Out</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mt-[60px] ml-[100px]">
            <h2 class="animate-[enter-header_1000ms_ease-out] select-none grid gap-4 font-[GT_Walsheim_Pro] text-8xl text-[#2D2946]">
                <span>Nature your garden</span>
                <span class="flex gap-4 items-start">
                    <span>width</span>    
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
