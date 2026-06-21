<?php
require 'config/database.php';

$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis = $_POST['jenis'] ?? '';
    $nama = trim($_POST['nama'] ?? '');
    $id_alternatif = $_POST['id_alternatif'] ?? '';

    if ($jenis === 'pembeli') {
        $c2 = (int)($_POST['c2_menarik'] ?? 0);
        $c3 = (int)($_POST['c3_worth_it'] ?? 0);
        if ($nama && $id_alternatif && $c2 >= 1 && $c3 >= 1) {
            $stmt = mysqli_prepare($conn, "INSERT INTO kuesioner_pembeli (nama_pembeli, id_alternatif, c2_menarik, c3_worth_it) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssii", $nama, $id_alternatif, $c2, $c3);
            if (mysqli_stmt_execute($stmt)) $success = true;
            else $error = 'Gagal menyimpan data.';
        } else { $error = 'Harap isi semua field dengan benar.'; }
    } elseif ($jenis === 'penjual') {
        $c1 = (int)($_POST['c1_untung'] ?? 0);
        $c2s = (int)($_POST['c2_sering'] ?? 0);
        $c4 = (int)($_POST['c4_habis'] ?? 0);
        if ($nama && $id_alternatif && $c1 >= 1 && $c2s >= 1 && $c4 >= 1) {
            $stmt = mysqli_prepare($conn, "INSERT INTO kuesioner_penjual (nama_internal, id_alternatif, c1_untung, c2_sering, c4_habis) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssiii", $nama, $id_alternatif, $c1, $c2s, $c4);
            if (mysqli_stmt_execute($stmt)) $success = true;
            else $error = 'Gagal menyimpan data.';
        } else { $error = 'Harap isi semua field dengan benar.'; }
    }
}

$alts = [];
$res = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY id_alternatif");
while ($row = mysqli_fetch_assoc($res)) $alts[] = $row;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei Hayo Chicken</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: linear-gradient(135deg, #fdf8f5 0%, #fae8e6 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.9);
            box-shadow: 0 25px 50px -12px rgba(220,38,38,0.15);
        }
        .tab-btn { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .tab-btn.active { 
            background: linear-gradient(135deg, #dc2626, #b91c1c); 
            color: white; 
            box-shadow: 0 10px 20px -5px rgba(220,38,38,0.4); 
            transform: translateY(-2px); 
            border-color: transparent !important;
        }
        .tab-btn.active .text-gray-400 { color: #fca5a5 !important; }
        .star-btn { cursor: pointer; transition: all 0.2s; font-size: 2rem; color: #e5e7eb; }
        .star-btn.active, .star-btn:hover { color: #f59e0b; transform: scale(1.15); }
        .pkg-option { cursor: pointer; transition: all 0.25s; border: 2px solid #f3f4f6; }
        .pkg-option.selected { border-color: #dc2626; background: #fef2f2; box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }
        .pkg-option:hover:not(.selected) { border-color: #fca5a5; background: #fef2f2; }
        .submit-btn { background: #dc2626; transition: all 0.3s; box-shadow: 0 8px 20px -5px rgba(220,38,38,0.4); }
        .submit-btn:hover { background: #b91c1c; transform: translateY(-2px); box-shadow: 0 12px 25px -5px rgba(220,38,38,0.5); }
        .input-field { border: 2px solid #f3f4f6; transition: all 0.3s; }
        .input-field:focus { outline: none; border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }
        .success-anim { animation: successPop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes successPop { from { transform: scale(0.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="antialiased py-10 px-4 flex items-center justify-center">

    <?php if ($success): ?>
    <div class="glass-card rounded-3xl p-12 text-center max-w-md w-full success-anim">
        <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner border-4 border-green-50">
            <i class="fa-solid fa-check"></i>
        </div>
        <h2 class="text-3xl font-black text-gray-800 mb-2">Terima Kasih!</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">Penilaian Anda sangat berharga bagi peningkatan mutu dan layanan <b>Hayo Chicken</b>.</p>
        <a href="form_kuesioner.php" class="submit-btn inline-block text-white font-bold py-3 px-8 rounded-xl w-full">
            Isi Kuesioner Lainnya <i class="fa-solid fa-arrow-right-rotate ml-2"></i>
        </a>
    </div>

    <?php else: ?>
    <!-- MAIN FORM -->
    <div class="max-w-2xl w-full">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-5 text-white shadow-lg" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                <i class="fa-solid fa-drumstick-bite text-4xl drop-shadow-md"></i>
            </div>
            <h1 class="text-4xl font-black text-gray-800 mb-2">Hayo Chicken!</h1>
            <p class="text-gray-500 text-lg">Bantu kami menentukan paket bundling terbaik.</p>
        </div>

        <?php if ($error): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-8 flex items-center gap-3 shadow-sm">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            <span class="font-medium"><?= htmlspecialchars($error) ?></span>
        </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="glass-card rounded-3xl overflow-hidden shadow-xl">

            <!-- Role Selector -->
            <div class="p-8 border-b border-gray-100 bg-gray-50/50">
                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4 text-center">Saya mengisi formulir sebagai:</p>
                <div class="grid grid-cols-2 gap-4" id="roleSelector">
                    <button type="button" onclick="setRole('pembeli')" id="btn-pembeli"
                        class="tab-btn active p-5 rounded-2xl font-bold text-gray-600 bg-white border border-gray-200 flex flex-col items-center gap-2 group">
                        <i class="fa-solid fa-basket-shopping text-3xl mb-1 transition-colors group-hover:text-red-500"></i>
                        <span class="text-base">Pelanggan Publik</span>
                        <span class="text-xs font-normal text-gray-400">Pembeli Menu</span>
                    </button>
                    <button type="button" onclick="setRole('penjual')" id="btn-penjual"
                        class="tab-btn p-5 rounded-2xl font-bold text-gray-600 bg-white border border-gray-200 flex flex-col items-center gap-2 group">
                        <i class="fa-solid fa-store text-3xl mb-1 transition-colors group-hover:text-red-500"></i>
                        <span class="text-base">Tim Internal</span>
                        <span class="text-xs font-normal text-gray-400">Staf Restoran</span>
                    </button>
                </div>
            </div>

            <form action="" method="POST" id="mainForm" class="p-8 space-y-8">
                <input type="hidden" name="jenis" id="jenis_field" value="pembeli">

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fa-solid fa-signature text-red-500 mr-1"></i> Nama Lengkap / Inisial
                    </label>
                    <input type="text" name="nama" required placeholder="Tulis nama Anda di sini..."
                        class="input-field w-full rounded-xl px-5 py-3.5 text-gray-700 font-medium bg-gray-50">
                </div>

                <!-- Pilih Paket -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">
                        <i class="fa-solid fa-utensils text-red-500 mr-1"></i> Pilih Paket Menu yang Dinilai
                    </label>
                    <input type="hidden" name="id_alternatif" id="selected_alternatif" required>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="paketList">
                        <?php foreach ($alts as $alt): ?>
                        <div class="pkg-option rounded-xl p-4 flex flex-col justify-between h-full bg-white"
                             onclick="selectPaket('<?= $alt['id_alternatif'] ?>', this)">
                            <div class="font-bold text-gray-800 text-sm mb-3 leading-tight"><?= htmlspecialchars($alt['nama_paket']) ?></div>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded font-mono">ID: <?= $alt['id_alternatif'] ?></span>
                                <span class="text-red-600 font-black text-sm">
                                    Rp <?= number_format($alt['harga_paket'], 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- PERTANYAAN PEMBELI -->
                <div id="section-pembeli" class="pt-2">
                    <div class="bg-red-50 rounded-xl p-4 mb-6 border border-red-100 flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-red-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs font-bold text-red-700 uppercase tracking-widest">Kriteria Pelanggan (C2, C3)</p>
                            <p class="text-xs text-red-600/80 mt-1">Skala: 1 Bintang (Sangat Buruk) s.d 5 Bintang (Sangat Baik)</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <label class="block text-base font-bold text-gray-800 mb-1">Daya Tarik / Popularitas</label>
                            <p class="text-sm text-gray-500 mb-4">Seberapa <b>menarik</b> paket ini sehingga Anda ingin membelinya lagi?</p>
                            <div class="flex gap-3" id="stars-c2">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <i class="fa-solid fa-star star-btn" onclick="setRating('c2_menarik', <?= $i ?>, 'stars-c2')"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="c2_menarik" id="c2_menarik" value="">
                            <div class="text-sm font-semibold text-red-600 mt-3 h-5" id="label-c2"></div>
                        </div>

                        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <label class="block text-base font-bold text-gray-800 mb-1">Tingkat Kepuasan Harga (Worth It)</label>
                            <p class="text-sm text-gray-500 mb-4">Apakah harga yang dibayar setimpal dengan porsi dan rasa yang didapat?</p>
                            <div class="flex gap-3" id="stars-c3">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <i class="fa-solid fa-star star-btn" onclick="setRating('c3_worth_it', <?= $i ?>, 'stars-c3')"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="c3_worth_it" id="c3_worth_it" value="">
                            <div class="text-sm font-semibold text-red-600 mt-3 h-5" id="label-c3"></div>
                        </div>
                    </div>
                </div>

                <!-- PERTANYAAN PENJUAL -->
                <div id="section-penjual" class="hidden pt-2">
                    <div class="bg-blue-50 rounded-xl p-4 mb-6 border border-blue-100 flex items-start gap-3">
                        <i class="fa-solid fa-clipboard-list text-blue-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs font-bold text-blue-700 uppercase tracking-widest">Kriteria Internal (C1, C2, C4)</p>
                            <p class="text-xs text-blue-600/80 mt-1">Skala: 1 Bintang (Sangat Rendah) s.d 5 Bintang (Sangat Tinggi)</p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <label class="block text-base font-bold text-gray-800 mb-1">Margin Keuntungan</label>
                            <p class="text-sm text-gray-500 mb-4">Seberapa besar <b>profit margin</b> kasar dari penjualan 1 porsi paket ini?</p>
                            <div class="flex gap-3" id="stars-c1">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <i class="fa-solid fa-star star-btn" onclick="setRating('c1_untung', <?= $i ?>, 'stars-c1')"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="c1_untung" id="c1_untung" value="">
                            <div class="text-sm font-semibold text-blue-600 mt-3 h-5" id="label-c1"></div>
                        </div>

                        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <label class="block text-base font-bold text-gray-800 mb-1">Frekuensi Penjualan</label>
                            <p class="text-sm text-gray-500 mb-4">Seberapa <b>sering</b> paket ini dipesan oleh pelanggan dalam seminggu?</p>
                            <div class="flex gap-3" id="stars-c2s">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <i class="fa-solid fa-star star-btn" onclick="setRating('c2_sering', <?= $i ?>, 'stars-c2s')"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="c2_sering" id="c2_sering" value="">
                            <div class="text-sm font-semibold text-blue-600 mt-3 h-5" id="label-c2s"></div>
                        </div>

                        <div class="p-5 rounded-2xl border border-gray-100 bg-gray-50/50">
                            <label class="block text-base font-bold text-gray-800 mb-1">Perputaran Stok Bahan</label>
                            <p class="text-sm text-gray-500 mb-4">Seberapa cepat bahan baku utama paket ini <b>habis</b> dan harus direstock?</p>
                            <div class="flex gap-3" id="stars-c4">
                                <?php for ($i=1; $i<=5; $i++): ?>
                                <i class="fa-solid fa-star star-btn" onclick="setRating('c4_habis', <?= $i ?>, 'stars-c4')"></i>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="c4_habis" id="c4_habis" value="">
                            <div class="text-sm font-semibold text-blue-600 mt-3 h-5" id="label-c4"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="submit-btn w-full text-white font-bold py-4 rounded-xl text-lg flex items-center justify-center gap-2">
                        Kirim Penilaian <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8 font-medium">© <?= date('Y') ?> Hayo Chicken System</p>
    </div>
    <?php endif; ?>

<script>
const labels = ['', 'Sangat Buruk 😞', 'Kurang Baik 😕', 'Cukup 😐', 'Baik 😊', 'Sangat Baik 🤩'];

function setRole(role) {
    document.getElementById('jenis_field').value = role;
    
    document.getElementById('btn-pembeli').classList.remove('active');
    document.getElementById('btn-penjual').classList.remove('active');
    
    document.getElementById('btn-' + role).classList.add('active');
    
    document.getElementById('section-pembeli').classList.toggle('hidden', role !== 'pembeli');
    document.getElementById('section-penjual').classList.toggle('hidden', role !== 'penjual');
}

function selectPaket(id, el) {
    document.querySelectorAll('.pkg-option').forEach(e => e.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selected_alternatif').value = id;
}

function setRating(field, val, starsId) {
    document.getElementById(field).value = val;
    const stars = document.getElementById(starsId).querySelectorAll('.star-btn');
    stars.forEach((s, i) => {
        s.classList.toggle('active', i < val);
    });
    
    const labelMap = { 'c2_menarik': 'label-c2', 'c3_worth_it': 'label-c3', 'c1_untung': 'label-c1', 'c2_sering': 'label-c2s', 'c4_habis': 'label-c4' };
    const lel = document.getElementById(labelMap[field]);
    if (lel) lel.textContent = 'Nilai: ' + val + ' / 5';
}
</script>
</body>
</html>