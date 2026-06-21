<div class="space-y-8">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-red-100 flex flex-col justify-between">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 text-lg">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Tabel Kriteria & Bobot</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest text-xs">
                        <th class="px-6 py-4 font-bold border-b border-gray-200">Kode</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-200">Nama Kriteria</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-200 text-center">Sifat</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-200 text-center">Bobot</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
                    while ($k = mysqli_fetch_assoc($kriteria)):
                        $isBenefit = $k['sifat'] == 'Benefit';
                        ?>
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-700"><?= $k['id_kriteria'] ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $k['nama_kriteria'] ?></td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold <?= $isBenefit ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' ?>">
                                    <i
                                        class="fa-solid <?= $isBenefit ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' ?> mr-1"></i>
                                    <?= $k['sifat'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="font-mono bg-gray-100 px-2 py-1 rounded text-red-700 font-bold"><?= $k['bobot'] ?></span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-red-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-lg">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">Data Alternatif Menu</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest text-xs">
                        <th class="px-6 py-4 font-bold border-b border-gray-200 w-32">KODE</th>
                        <th class="px-6 py-4 font-bold border-b border-gray-200">Nama Paket Bundling</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $alternatif = mysqli_query($conn, "SELECT * FROM alternatif");
                    while ($a = mysqli_fetch_assoc($alternatif)): ?>
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <span
                                    class="font-bold text-red-600 bg-red-50 px-3 py-1 rounded-lg border border-red-100"><?= $a['id_alternatif'] ?></span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 font-medium text-base flex items-center gap-3">
                                <i class="fa-solid fa-utensils text-gray-300"></i>
                                <?= $a['nama_paket'] ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>