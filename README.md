# Sistem Pendukung Keputusan: Penetapan Paket Bundling Hayo Chicken
Aplikasi Sistem Pendukung Keputusan (SPK) berbasis Web menggunakan algoritma komputasi Simple Additive Weighting (SAW).

**Akses Live Aplikasi (Deployed):** [https://hayo-chicken.infy.click/](https://hayo-chicken.infy.click/)

---

## Latar Belakang
Usaha mikro, kecil, dan menengah (UMKM) kuliner seperti Hayo Chicken kerap menghadapi tantangan dalam merancang strategi promosi paket makanan (*product bundling*). Selama ini, pemilihan paket sering didasarkan pada intuisi tanpa analisis data pendukung. Pendekatan ini berisiko memadukan menu dengan margin profit rendah, in-efisiensi perputaran stok bahan baku, dan terkadang tidak selaras dengan preferensi aktual pelanggan.

Sistem Pendukung Keputusan (SPK) ini dibangun untuk mendigitalisasi proses pengambilan keputusan strategis tersebut menggunakan metode SAW. Secara dinamis, sistem web ini mencari dan memberikan rekomendasi paket bundling paling optimal dengan mengevaluasi opini dari 2 perspektif secara adil: Pemilik Usaha (margin profit, frekuensi pemesanan, perputaran stok) dan Pelanggan Publik (kewajaran harga dan kepuasan daya tarik).

---

## Model Data Analitik

Berikut adalah penjabaran variabel yang digunakan dalam persamaan matematika *Simple Additive Weighting* pada aplikasi ini:

### 1. Data Alternatif Keputusan (A)
| Kode | Alternatif Bundling | Harga Jual |
|---|---|---|
| **A1** | Ayam Geprek + Nasi + Es Teh | Rp 16.000 |
| **A2** | Chicken Katsu + Nasi + Es Teh | Rp 19.000 |
| **A3** | Chicken Saus + Nasi + Es Teh | Rp 16.000 |
| **A4** | Crispy Chicken Steak + Nasi + Es Teh | Rp 19.000 |
| **A5** | Ayam Lalapan 1/4 + Nasi + Es Teh | Rp 19.000 |

### 2. Variabel Kriteria & Bobot (C)
Sistem mengklasifikasikan kriteria menjadi dua sifat mutlak: turunan atribut *Benefit* (semakin besar nilainya semakin baik) dan *Cost* (semakin kecil nilainya semakin baik).

| Kode | Kriteria | Sumber Penilaian Data | Sifat Atribut | Bobot Vektor |
|---|---|---|---|---|
| **C1** | Margin Keuntungan | Penjual | Benefit | 25% (0.25) |
| **C2** | Popularitas & Frekuensi | Penjual & Pembeli | Benefit | 20% (0.20) |
| **C3** | Tingkat Kepuasan (Worth It) | Pembeli | Benefit | 25% (0.25) |
| **C4** | Penggunaan Stok Bahan | Penjual | Benefit | 15% (0.15) |
| **C5** | Harga Jual Paket | Ketetapan Penjual | Cost | 15% (0.15) |


---

## Panduan Penggunaan dan Instalasi Sistem

Sebagai sebuah aplikasi interaktif, sistem ini memiliki komponen *Database Relational* otomatis dan lapisan antarmuka evaluasi yang terpisah antara Admin dan Responden Survei.

### Kebutuhan Sistem Operasional
- **Web Server Lokal**: Laragon (Rekomendasi Utama) atau XAMPP.
- **Bahasa Pemrograman**: PHP 7.4 / PHP 8.x.
- **Sistem Database**: MySQL / MariaDB.
- **Frontend / Antarmuka**: Tailwind CSS (dipanggil via metode CDN).

### Panduan Instalasi (Deployment)
1. **Clone Repository**: *Clone* (unduh) repository GitHub ini ke dalam direktori *Document Root* HTTP lokal instalasi Anda (`htdocs` jika XAMPP, atau `www` jika Laragon). Jalankan di terminal:
   ```bash
   git clone https://github.com/hananaila/SAW-HayoChicken.git
   ```
   Pastikan folder proyek hasil *clone* (atau hasil *rename* Anda) dapat diakses melalui browser.
2. **Aktivasi Modul Server**: Buka kontrol panel sistem Laragon atau XAMPP Anda. Nyalakan layanan (Start) pada modul utama **Apache** dan **MySQL**.
3. **Konfigurasi Seeding Database Otomatis**:
   - Untuk mematuhi kerangka data awal, buka browser apa saja dan jalankan URL berikut untuk instalasi sistem:
     `http://localhost/SAW-HayoChicken/seed.php`
   - *Script* pemandu tersebut akan secara otomatis membentuk struktur database bernama `spk_hayo_chicken`, merakit infrastruktur tabel, serta menyuntikkan data *seeding* entitas aktual (3 penjual internal & 33 konsumen publik) untuk mensimulasikan hasil penghitungan numerik awal secara paripurna. Atau, Anda dapat langsung meng-import file `database.sql` ke MySQL.

### Cara Mengoperasikan Aplikasi

Aplikasi berjalan pada dua lapisan portal fungsional utama:

**A. Mode Responden Survei (Formulir Publik & Karyawan)**
- Buka tautan navigasi berikut: `http://localhost/SAW-HayoChicken/form_kuesioner.php`.
- Responden diinstruksikan untuk memilih validasi peran / *Role* mereka (kategori *Tim Internal* atau *Pelanggan Konsumen Publik*).
- Pertanyaan antarmuka survei akan beradaptasi secara dinamis menyesuaikan kategori. Responden memberikan input validasi metrik antara bintang 1 hingga 5. Begitu rekaman dikirim melalui tombol "Kirim Penilaian", data kalkulasinya akan secara *real-time* merekalibrasi struktur analisis di panel administrator.

**B. Mode Dashboard Administrasi (Untuk Pemilik)**
- Akses portal dashboard sentral ini melalui tautan utama: `http://localhost/SAW-HayoChicken/`
- Anda akan diwajibkan melewati prosedur autentikasi gerbang masuk. Silakan gunakan kredensial portal berikut:
  *   **Username**: `okti`
  *   **Password**: `admin123`
- **Modul Beranda**: Menampilkan representasi panel *Live* terkait total korespondan data, serta konversi rata-rata pecahan koma (Skor Gabungan Staf dan Pelanggan) pada setiap kriteria menu paket.
- **Modul Data Master**: Manajemen pemantauan terkait paket *bundling* serta komposisi pembobotan fungsional yang berjalan.
- **Modul Hasil Rekomendasi**: Log area perhitungan algoritmik murni. Menyoroti perlakuan pengoperasian secara langkah-demi-langkah terkait penyusunan Matriks Keputusan (X), Normalisasi Komputasi, hingga perolehan urutan Peringkat Preferensi (V) secara berurutan.
- **Modul Kesimpulan**: Kesimpulan akhir analitik, di mana sistem mendefinisikan keputusan Paket Bundling Terbaik (Peringkat Teratas) yang paling menguntungkan serta optimalisasi kepuasan dalam parameter sasaran pemasaran masa mendatang.

*** 

