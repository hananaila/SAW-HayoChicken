<?php
// --- LOGIKA PERHITUNGAN SAW ---
$weights = [];
$q_kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
while ($row = mysqli_fetch_assoc($q_kriteria)) {
    $weights[$row['id_kriteria']] = ['bobot' => $row['bobot'], 'sifat' => strtolower($row['sifat'])];
}

$matriks_x = [];
$q_alternatif = mysqli_query($conn, "SELECT * FROM alternatif");

while ($alt = mysqli_fetch_assoc($q_alternatif)) {
    $id = $alt['id_alternatif'];
    $q_pj = mysqli_query($conn, "SELECT AVG(c1_untung) as avg_c1, AVG(c2_sering) as avg_sering_pj, AVG(c4_habis) as avg_c4 FROM kuesioner_penjual WHERE id_alternatif='$id'");
    $pj = mysqli_fetch_assoc($q_pj);

    $q_pb = mysqli_query($conn, "SELECT AVG(c2_menarik) as avg_menarik_pb, AVG(c3_worth_it) as avg_worth_pb FROM kuesioner_pembeli WHERE id_alternatif='$id'");
    $pb = mysqli_fetch_assoc($q_pb);

    $matriks_x[$id] = [
        'nama' => $alt['nama_paket'],
        'C1' => $pj['avg_c1'],
        'C2' => ($pj['avg_sering_pj'] + $pb['avg_menarik_pb']) / 2,
        'C3' => ($pb['avg_menarik_pb'] + $pb['avg_worth_pb']) / 2,
        'C4' => $pj['avg_c4'],
        'C5' => $alt['harga_paket']
    ];
}

$max_min = [
    'C1' => $weights['C1']['sifat'] == 'benefit' ? 0 : 9999999,
    'C2' => $weights['C2']['sifat'] == 'benefit' ? 0 : 9999999,
    'C3' => $weights['C3']['sifat'] == 'benefit' ? 0 : 9999999,
    'C4' => $weights['C4']['sifat'] == 'benefit' ? 0 : 9999999,
    'C5' => $weights['C5']['sifat'] == 'benefit' ? 0 : 9999999
];

foreach ($matriks_x as $x) {
    foreach (['C1', 'C2', 'C3', 'C4', 'C5'] as $c) {
        if ($weights[$c]['sifat'] == 'benefit') {
            if ($x[$c] > $max_min[$c])
                $max_min[$c] = $x[$c];
        } else {
            if ($x[$c] < $max_min[$c])
                $max_min[$c] = $x[$c];
        }
    }
}

$hasil_v = [];
$matriks_r = [];
foreach ($matriks_x as $id => $val) {
    $r = [];
    foreach (['C1', 'C2', 'C3', 'C4', 'C5'] as $c) {
        if ($weights[$c]['sifat'] == 'benefit') {
            $r[$c] = $max_min[$c] != 0 ? $val[$c] / $max_min[$c] : 0;
        } else {
            $r[$c] = $val[$c] != 0 ? $max_min[$c] / $val[$c] : 0;
        }
    }
    $matriks_r[$id] = $r;

    $v = ($r['C1'] * $weights['C1']['bobot']) +
        ($r['C2'] * $weights['C2']['bobot']) +
        ($r['C3'] * $weights['C3']['bobot']) +
        ($r['C4'] * $weights['C4']['bobot']) +
        ($r['C5'] * $weights['C5']['bobot']);

    $hasil_v[] = ['id' => $id, 'nama' => $val['nama'], 'nilai' => $v];
}
usort($hasil_v, function ($a, $b) {
    return $b['nilai'] <=> $a['nilai'];
});
?>

<div class="space-y-8">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-red-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-lg">
                <i class="fa-solid fa-table"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">1. Matriks Keputusan (X)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest text-xs border-b border-gray-200">
                        <th class="px-6 py-4 font-bold">Alternatif</th>
                        <th class="px-4 py-4 font-bold text-center">C1</th>
                        <th class="px-4 py-4 font-bold text-center">C2</th>
                        <th class="px-4 py-4 font-bold text-center">C3</th>
                        <th class="px-4 py-4 font-bold text-center">C4</th>
                        <th class="px-4 py-4 font-bold text-right">C5 (Harga)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($matriks_x as $id => $val): ?>
                        <tr class="hover:bg-red-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-red-700 bg-red-50 px-3 py-1 rounded-lg mr-2"><?= $id ?></span>
                            </td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600"><?= round($val['C1'], 3) ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600"><?= round($val['C2'], 3) ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600"><?= round($val['C3'], 3) ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600"><?= round($val['C4'], 3) ?></td>
                            <td class="px-4 py-4 text-right font-bold text-gray-700">Rp
                                <?= number_format($val['C5'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-emerald-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-lg">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">2. Matriks Normalisasi (R)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest text-xs border-b border-gray-200">
                        <th class="px-6 py-4 font-bold">Alternatif</th>
                        <th class="px-4 py-4 font-bold text-center">C1</th>
                        <th class="px-4 py-4 font-bold text-center">C2</th>
                        <th class="px-4 py-4 font-bold text-center">C3</th>
                        <th class="px-4 py-4 font-bold text-center">C4</th>
                        <th class="px-4 py-4 font-bold text-center">C5</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($matriks_r as $id => $r_val): ?>
                        <tr class="hover:bg-emerald-50/30 transition-colors">
                            <td class="px-6 py-4">
                                <span
                                    class="font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg mr-2"><?= $id ?></span>
                            </td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600">
                                <?= number_format($r_val['C1'], 3, ',', '.') ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600">
                                <?= number_format($r_val['C2'], 3, ',', '.') ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600">
                                <?= number_format($r_val['C3'], 3, ',', '.') ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600">
                                <?= number_format($r_val['C4'], 3, ',', '.') ?></td>
                            <td class="px-4 py-4 text-center font-mono text-gray-600">
                                <?= number_format($r_val['C5'], 3, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-red-200 shadow-red-100">
        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-700 text-lg">
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800">3. Hasil Akhir / Preferensi (V)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-red-50 text-red-800 uppercase tracking-widest text-xs border-b border-red-200">
                        <th class="px-6 py-4 font-bold text-center">Peringkat</th>
                        <th class="px-4 py-4 font-bold text-center">Kode</th>
                        <th class="px-6 py-4 font-bold">Nama Paket</th>
                        <th class="px-6 py-4 font-bold text-right">Nilai Preferensi (V)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $rank = 1;
                    foreach ($hasil_v as $row):
                        $isFirst = $rank == 1;
                        ?>
                        <tr
                            class="transition-colors <?= $isFirst ? 'bg-red-50/50 hover:bg-red-100' : 'hover:bg-gray-50' ?>">
                            <td class="px-6 py-4 text-center">
                                <?php if ($isFirst): ?>
                                    <div
                                        class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center mx-auto shadow-md">
                                        <i class="fa-solid fa-trophy text-sm"></i>
                                    </div>
                                <?php else: ?>
                                    <span class="font-bold text-gray-500">#<?= $rank ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span
                                    class="font-bold text-red-700 bg-white border border-red-200 px-3 py-1 rounded-lg shadow-sm"><?= $row['id'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="<?= $isFirst ? 'font-bold text-red-800' : 'font-medium text-gray-700' ?> text-base">
                                    <?= $row['nama'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="<?= $isFirst ? 'text-red-700 bg-red-100' : 'text-gray-700 bg-gray-100' ?> font-mono font-bold px-3 py-1.5 rounded text-lg">
                                    <?= number_format($row['nilai'], 4) ?>
                                </span>
                            </td>
                        </tr>
                        <?php $rank++; endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>