<?php
// Hitung statistik real dari database
$q_pembeli_unique = mysqli_query($conn, "SELECT COUNT(DISTINCT nama_pembeli) as total FROM kuesioner_pembeli");
$total_pembeli = mysqli_fetch_assoc($q_pembeli_unique)['total'];

$q_penjual_unique = mysqli_query($conn, "SELECT COUNT(DISTINCT nama_internal) as total FROM kuesioner_penjual");
$total_penjual = mysqli_fetch_assoc($q_penjual_unique)['total'];

$q_total_respon = mysqli_query($conn, "SELECT (SELECT COUNT(DISTINCT nama_pembeli) FROM kuesioner_pembeli) + (SELECT COUNT(DISTINCT nama_internal) FROM kuesioner_penjual) as total");
$total_responden = mysqli_fetch_assoc($q_total_respon)['total'];

// Daftar semua pengisi kuesioner pembeli
$q_daftar_pembeli = mysqli_query($conn, "SELECT nama_pembeli, COUNT(*) as jml_paket, AVG(c2_menarik) as avg_menarik, AVG(c3_worth_it) as avg_worth FROM kuesioner_pembeli GROUP BY nama_pembeli ORDER BY nama_pembeli ASC");

// Daftar pengisi kuesioner penjual
$q_daftar_penjual = mysqli_query($conn, "SELECT nama_internal, COUNT(*) as jml_paket, AVG(c1_untung) as avg_untung, AVG(c2_sering) as avg_sering, AVG(c4_habis) as avg_habis FROM kuesioner_penjual GROUP BY nama_internal ORDER BY nama_internal ASC");

// Rata-rata per paket dari pembeli
$q_per_paket = mysqli_query($conn, "SELECT a.id_alternatif, a.nama_paket, a.harga_paket, COUNT(DISTINCT pb.nama_pembeli) as jml_pembeli, AVG(pb.c2_menarik) as avg_menarik, AVG(pb.c3_worth_it) as avg_worth, AVG(pj.c1_untung) as avg_untung, AVG(pj.c2_sering) as avg_sering, AVG(pj.c4_habis) as avg_habis FROM alternatif a LEFT JOIN kuesioner_pembeli pb ON a.id_alternatif = pb.id_alternatif LEFT JOIN kuesioner_penjual pj ON a.id_alternatif = pj.id_alternatif GROUP BY a.id_alternatif ORDER BY a.id_alternatif");
$per_paket = [];
while ($row = mysqli_fetch_assoc($q_per_paket))
    $per_paket[] = $row;
?>

<div class="space-y-8">

    <!-- HEADER WELCOME -->
    <div
        class="bg-gradient-to-r from-red-600 to-red-800 rounded-3xl p-8 text-white relative overflow-hidden shadow-lg border border-red-900 border-opacity-50">
        <div class="absolute -top-12 -right-12 text-[12rem] opacity-5 select-none"><i
                class="fa-solid fa-chart-line"></i></div>
        <div class="relative z-10 flex items-center gap-6">
            <div
                class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-red-600 text-3xl shadow-md border-4 border-red-300">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <p class="text-red-200 text-sm font-bold uppercase tracking-widest mb-1">Selamat Datang di Sistem</p>
                <h1 class="text-3xl font-black mb-1"><?= $_SESSION['nama_user'] ?? 'Admin' ?></h1>
                <p class="text-red-100 text-base">Dashboard Monitoring Keputusan Penentuan Paket Bundling</p>
            </div>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 flex flex-col items-center justify-center text-xl text-orange-600">
                    <i class="fa-solid fa-users-viewfinder"></i>
                </div>
                <span
                    class="text-xs font-bold text-orange-700 bg-orange-100 px-3 py-1 rounded-full uppercase tracking-wide">Live</span>
            </div>
            <div>
                <p class="text-4xl font-black text-gray-800"><?= $total_pembeli ?></p>
                <p class="text-sm font-bold text-gray-500 mt-1">Responden Pembeli</p>
                <p class="text-xs text-gray-400 mt-1">Berkontribusi di kriteria C2 & C3</p>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-xl text-blue-600">
                    <i class="fa-solid fa-user-lock"></i>
                </div>
                <span
                    class="text-xs font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full uppercase tracking-wide">Internal</span>
            </div>
            <div>
                <p class="text-4xl font-black text-gray-800"><?= $total_penjual ?></p>
                <p class="text-sm font-bold text-gray-500 mt-1">Responden Penjual</p>
                <p class="text-xs text-gray-400 mt-1">Berkontribusi di kriteria C1, C2, C4</p>
            </div>
        </div>

        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 hover:shadow-md transition-all relative overflow-hidden">
            <div class="absolute inset-0 bg-red-50 opacity-50 z-0"></div>
            <div class="relative z-10 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-2">
                    <div
                        class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-xl text-red-600 border border-red-200">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
                <div>
                    <p class="text-4xl font-black text-red-700"><?= $total_responden ?></p>
                    <p class="text-sm font-bold text-red-900 mt-1">Total Responden Valid</p>
                    <p class="text-xs text-red-600/80 mt-1">Akumulasi seluruh entitas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RATA-RATA PER PAKET -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 text-sm">
                <i class="fa-solid fa-magnifying-glass-chart"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg">Rata-rata Penilaian per Alternatif Paket</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-widest border-b border-gray-200">
                        <th class="px-6 py-4 text-left font-bold">Paket Menu</th>
                        <th class="px-4 py-4 text-center font-bold"><span class="text-red-600"
                                title="Sifat: Cost (Semakin murah semakin bagus)">C5 Harga</span></th>
                        <th class="px-4 py-4 text-center font-bold"><span class="text-blue-600" title="Dari Internal">C1
                                Untung</span></th>
                        <th class="px-4 py-4 text-center font-bold"><span class="text-purple-600"
                                title="Gabungan Internal & Pembeli">C2 Menarik</span></th>
                        <th class="px-4 py-4 text-center font-bold"><span class="text-orange-600"
                                title="Dari Pembeli">C3 Worth</span></th>
                        <th class="px-4 py-4 text-center font-bold"><span class="text-blue-600" title="Dari Internal">C4
                                Stok Habis</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($per_paket as $pkg): ?>
                        <tr class="hover:bg-red-50/40 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl border border-gray-200 bg-white shadow-sm flex items-center justify-center text-red-500">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm">
                                            <?= htmlspecialchars($pkg['nama_paket']) ?>
                                        </div>
                                        <div class="text-gray-400 text-xs font-mono mt-0.5">Kode:
                                            <?= $pkg['id_alternatif'] ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center">
                                <span
                                    class="inline-block text-xs font-bold px-3 py-1.5 rounded-lg border border-red-100 text-red-700 bg-red-50">
                                    Rp <?= number_format($pkg['harga_paket'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="px-4 py-5 text-center">
                                <div class="font-bold text-gray-800 text-lg">
                                    <?= number_format($pkg['avg_untung'] ?? 0, 2) ?>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center bg-gray-50/50">
                                <?php
                                $c2_avg = (($pkg['avg_sering'] ?? 0) + ($pkg['avg_menarik'] ?? 0)) / 2;
                                ?>
                                <div class="font-bold text-gray-800 text-lg"><?= number_format($c2_avg, 2) ?></div>
                                <div class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">
                                    STAF: <?= number_format($pkg['avg_sering'] ?? 0, 1) ?> | CUST:
                                    <?= number_format($pkg['avg_menarik'] ?? 0, 1) ?>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center">
                                <div class="font-bold text-gray-800 text-lg"><?= number_format($pkg['avg_worth'] ?? 0, 2) ?>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center bg-gray-50/50">
                                <div class="font-bold text-gray-800 text-lg"><?= number_format($pkg['avg_habis'] ?? 0, 2) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- DATA PENGISI: 2 columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- LIST PEMBELI -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-orange-50/50">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping text-orange-600 text-lg"></i>
                    <h4 class="font-bold text-gray-800">Daftar Responden Publik (Pembeli)</h4>
                </div>
                <span
                    class="text-xs font-bold text-orange-700 bg-orange-100 px-3 py-1 rounded-full border border-orange-200">
                    <?= $total_pembeli ?> Terdata
                </span>
            </div>
            <div class="overflow-y-auto max-h-[350px]">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 border-b border-gray-200 z-10">
                        <tr class="text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Nama Entitas</th>
                            <th class="px-4 py-3 text-center"># Rate</th>
                            <th class="px-4 py-3 text-center">Avg Menarik</th>
                            <th class="px-4 py-3 text-center">Avg Worth</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        while ($pb = mysqli_fetch_assoc($q_daftar_pembeli)): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-800 flex items-center gap-2">
                                        <i class="fa-regular fa-user text-gray-400"></i>
                                        <?= htmlspecialchars($pb['nama_pembeli']) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 font-mono text-xs"><?= $pb['jml_paket'] ?>
                                    pkt</td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">
                                    <?= number_format($pb['avg_menarik'], 2) ?>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">
                                    <?= number_format($pb['avg_worth'], 2) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LIST PENJUAL -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-blue-50/50">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-users-gear text-blue-600 text-lg"></i>
                    <h4 class="font-bold text-gray-800">Daftar Responden Internal</h4>
                </div>
                <span class="text-xs font-bold text-blue-700 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">
                    <?= $total_penjual ?> Terdata
                </span>
            </div>
            <div class="overflow-y-auto max-h-[350px]">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 border-b border-gray-200 z-10">
                        <tr class="text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 text-left">Nama Staf</th>
                            <th class="px-4 py-3 text-center">C1 Untung</th>
                            <th class="px-4 py-3 text-center">C2 Sering</th>
                            <th class="px-4 py-3 text-center">C4 Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        while ($pj = mysqli_fetch_assoc($q_daftar_penjual)): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-800 flex items-center gap-2">
                                        <i class="fa-solid fa-id-badge text-gray-400"></i>
                                        <?= htmlspecialchars($pj['nama_internal']) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">
                                    <?= number_format($pj['avg_untung'], 2) ?>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">
                                    <?= number_format($pj['avg_sering'], 2) ?>
                                </td>
                                <td class="px-4 py-3 text-center font-bold text-gray-700">
                                    <?= number_format($pj['avg_habis'], 2) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>