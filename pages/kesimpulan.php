<?php
// Ambil logika SAW (ringkas) untuk mendapatkan top 1
$weights = [];
$q_kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
while ($row = mysqli_fetch_assoc($q_kriteria)) {
    $weights[$row['id_kriteria']] = ['bobot' => $row['bobot']];
}

$matriks_x = [];
$q_alternatif = mysqli_query($conn, "SELECT * FROM alternatif");
while ($alt = mysqli_fetch_assoc($q_alternatif)) {
    $id = $alt['id_alternatif'];
    $q_pj = mysqli_query($conn, "SELECT AVG(c1_untung) as c1, AVG(c2_sering) as c2_pj, AVG(c4_habis) as c4 FROM kuesioner_penjual WHERE id_alternatif='$id'");
    $pj = mysqli_fetch_assoc($q_pj);
    $q_pb = mysqli_query($conn, "SELECT AVG(c2_menarik) as c2_pb, AVG(c3_worth_it) as c3_pb FROM kuesioner_pembeli WHERE id_alternatif='$id'");
    $pb = mysqli_fetch_assoc($q_pb);

    $matriks_x[$id] = ['nama' => $alt['nama_paket'], 'C1' => $pj['c1'], 'C2' => ($pj['c2_pj'] + $pb['c2_pb']) / 2, 'C3' => ($pb['c2_pb'] + $pb['c3_pb']) / 2, 'C4' => $pj['c4'], 'C5' => $alt['harga_paket']];
}

$max_min = ['C1' => 0, 'C2' => 0, 'C3' => 0, 'C4' => 0, 'C5' => 9999999];
foreach ($matriks_x as $x) {
    if ($x['C1'] > $max_min['C1'])
        $max_min['C1'] = $x['C1'];
    if ($x['C2'] > $max_min['C2'])
        $max_min['C2'] = $x['C2'];
    if ($x['C3'] > $max_min['C3'])
        $max_min['C3'] = $x['C3'];
    if ($x['C4'] > $max_min['C4'])
        $max_min['C4'] = $x['C4'];
    if ($x['C5'] < $max_min['C5'])
        $max_min['C5'] = $x['C5'];
}

$hasil_v = [];
foreach ($matriks_x as $id => $val) {
    $v = (($val['C1'] / $max_min['C1']) * $weights['C1']['bobot']) + (($val['C2'] / $max_min['C2']) * $weights['C2']['bobot']) + (($val['C3'] / $max_min['C3']) * $weights['C3']['bobot']) + (($val['C4'] / $max_min['C4']) * $weights['C4']['bobot']) + (($max_min['C5'] / $val['C5']) * $weights['C5']['bobot']);
    $hasil_v[] = ['nama' => $val['nama'], 'nilai' => $v];
}
usort($hasil_v, function ($a, $b) {
    return $b['nilai'] <=> $a['nilai'];
});
$top = $hasil_v[0];
?>

<div class="h-full flex flex-col justify-center max-w-4xl mx-auto py-10">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-black text-gray-800 mb-2">Kesimpulan Akhir</h2>
        <p class="text-gray-500">Berdasarkan kalkulasi otomatis metode SAW</p>
    </div>

    <!-- Highlight Card -->
    <div
        class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-10 text-white shadow-2xl shadow-red-900/20 relative overflow-hidden flex flex-col items-center justify-center border border-red-500">
        <!-- Abstract Decorations -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-red-400 opacity-20 rounded-full blur-3xl"></div>
        <div class="absolute top-10 right-10 text-[8rem] opacity-5 select-none pointer-events-none">
            <i class="fa-solid fa-award"></i>
        </div>

        <div class="relative z-10 text-center w-full">
            <div
                class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl text-white border border-white/20 shadow-lg mx-auto mb-6">
                <i class="fa-solid fa-crown text-yellow-300"></i>
            </div>

            <p class="text-sm font-bold tracking-[0.2em] uppercase mb-4 text-red-200">
                Rekomendasi Paket Utama Saat Ini
            </p>

            <h3 class="text-4xl md:text-5xl font-black mb-8 leading-tight px-4 break-words">
                <?= $top['nama']; ?>
            </h3>

            <div
                class="inline-flex flex-col items-center gap-1 bg-black/20 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/10 shadow-inner">
                <span class="text-red-200 text-xs uppercase tracking-widest font-semibold">Skor Preferensi</span>
                <span class="text-2xl font-mono font-bold tracking-wider"><?= number_format($top['nilai'], 4); ?></span>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center bg-white p-6 rounded-2xl border border-red-100 shadow-sm">
        <p class="text-gray-600 text-sm leading-relaxed">
            Paket <b class="text-red-700"><?= $top['nama'] ?></b> memegang peringkat pertama karena memiliki akumulasi
            rata-rata poin tertinggi di seluruh kriteria pembeli maupun tim internal. Pertimbangkan untuk mempromosikan
            menu ini lebih luas.
        </p>
    </div>
</div>