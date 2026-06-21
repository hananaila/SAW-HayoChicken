<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';
$navItems = [
    'beranda' => ['icon' => 'fa-solid fa-house', 'label' => 'Beranda'],
    'data_master' => ['icon' => 'fa-solid fa-database', 'label' => 'Data Master'],
    'hasil_rekomendasi' => ['icon' => 'fa-solid fa-chart-simple', 'label' => 'Hasil Rekomendasi'],
    'kesimpulan' => ['icon' => 'fa-solid fa-medal', 'label' => 'Kesimpulan'],
];
?>
<nav class="bg-red-700 shadow-md border-b-4 border-red-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Side: Brand -->
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-drumstick-bite text-white text-2xl drop-shadow-md"></i>
                <span class="text-white font-bold text-xl tracking-wide hidden sm:block">Hayo Chicken</span>
            </div>

            <!-- Right Side: Links & User -->
            <div class="flex items-center gap-1 sm:gap-4">
                <?php foreach ($navItems as $key => $item): ?>
                    <?php $isActive = ($page === $key); ?>
                    <a href="index.php?page=<?= $key ?>"
                        class="px-2 sm:px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center 
                   <?= $isActive ? 'bg-red-900 text-white shadow-inner' : 'text-red-100 hover:bg-red-600 hover:text-white' ?>">
                        <i
                            class="<?= $item['icon'] ?> <?= $isActive ? 'text-red-300' : '' ?> sm:mr-2 text-lg sm:text-sm"></i>
                        <span class="hidden md:block">
                            <?= $item['label'] ?>
                        </span>
                    </a>
                <?php endforeach; ?>

                <div class="h-6 w-px bg-red-500 mx-1 sm:mx-2"></div>

                <div class="flex items-center gap-3 ml-2">
                    <span class="text-red-100 font-medium text-sm hidden lg:block">Halo,
                        <?= $_SESSION['nama_user'] ?? 'Admin' ?>
                    </span>
                    <div
                        class="w-8 h-8 rounded-full bg-red-800 border-2 border-red-400 flex items-center justify-center text-white">
                        <i class="fa-solid fa-user-tie text-xs"></i>
                    </div>
                    <a href="logout.php" title="Logout"
                        class="p-2 ml-1 rounded-lg text-red-200 hover:bg-red-800 hover:text-white transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</nav>

<!-- Page Header Title under navbar -->
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 capitalize flex items-center gap-2">
            <i class="<?= $navItems[$page]['icon'] ?? 'fa-solid fa-cube' ?> text-red-600"></i>
            <?= str_replace('_', ' ', $page) ?>
        </h2>
        <a href="form_kuesioner.php" target="_blank"
            class="text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg transition-colors flex items-center gap-2 border border-red-100">
            <i class="fa-solid fa-up-right-from-square"></i> Buka Form Survei
        </a>
    </div>
</div>