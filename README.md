# 🍗 SPK Hayo Chicken — Sistem Pendukung Keputusan
**Metode: Simple Additive Weighting (SAW)**

---

## 📁 Struktur Folder

```
spk-hayo-chicken/
├── config/
│   └── database.php          ← Konfigurasi koneksi MySQL
├── includes/
│   ├── header.php            ← Layout header + sidebar
│   ├── footer.php            ← Layout footer
│   └── saw_engine.php        ← Core engine perhitungan SAW
├── pages/
│   ├── kriteria.php          ← CRUD Data Kriteria
│   ├── alternatif.php        ← CRUD Data Alternatif
│   ├── penilaian.php         ← Form input nilai
│   └── hasil_saw.php         ← Proses & Hasil SAW (INTI)
├── assets/
│   ├── css/style.css         ← Stylesheet custom
│   └── js/app.js             ← JavaScript interaktif
├── database.sql              ← Query DDL + INSERT data awal
└── index.php                 ← Dashboard
```

---

## 🚀 Cara Instalasi

### 1. Siapkan Server
- PHP >= 7.4 atau PHP 8.x
- MySQL 5.7+ atau MariaDB 10.3+
- Apache/Nginx (XAMPP/Laragon/WAMP juga bisa)

### 2. Import Database
```sql
-- Buka phpMyAdmin atau MySQL CLI, lalu jalankan:
SOURCE /path/to/spk-hayo-chicken/database.sql;
```
Atau buka file `database.sql` di phpMyAdmin → Import.

### 3. Konfigurasi Koneksi
Edit file `config/database.php`:
```php
define('DB_HOST', 'localhost');    // Host MySQL
define('DB_USER', 'root');         // Username
define('DB_PASS', '');             // Password
define('DB_NAME', 'spk_hayo_chicken'); // Nama database
```

### 4. Letakkan di Web Root
Copy folder `spk-hayo-chicken/` ke dalam:
- XAMPP: `C:/xampp/htdocs/`
- Laragon: `C:/laragon/www/`

### 5. Akses Browser
```
http://localhost/spk-hayo-chicken/
```

---

## ⚙️ Alur Kerja Sistem

```
1. INPUT DATA MASTER
   Kriteria (C1–C5) + Bobot + Sifat (Benefit/Cost)
   Alternatif (A1–A6) = Paket Menu Hayo Chicken
         ↓
2. INPUT NILAI PENILAIAN
   Tabel penilaian: nilai x_ij untuk setiap pasang (alternatif, kriteria)
         ↓
3. PROSES SAW (saw_engine.php)
   a. Matriks Keputusan X = nilai mentah dari DB
   b. Normalisasi:
      - Benefit → r_ij = x_ij / max(x_j)
      - Cost    → r_ij = min(x_j) / x_ij
   c. Preferensi: V_i = Σ (w_j × r_ij)
   d. Ranking: sort descending by V_i
         ↓
4. OUTPUT HASIL
   Ranking lengkap + Rekomendasi Winner Card
```

---

## 📊 Data Awal (Sesuai Excel)

### Kriteria
| Kode | Nama              | Bobot | Sifat   |
|------|-------------------|-------|---------|
| C1   | Margin Keuntungan | 30%   | Benefit |
| C2   | Tingkat Popularitas | 25% | Benefit |
| C3   | Harga Jual        | 20%   | Cost    |
| C4   | Biaya Produksi    | 15%   | Cost    |
| C5   | Tingkat Kepuasan  | 10%   | Benefit |

### Alternatif
| Kode | Nama                      |
|------|---------------------------|
| A1   | Paket Ayam Geprek         |
| A2   | Paket Chicken Katsu       |
| A3   | Paket Ayam Bakar          |
| A4   | Paket Chicken Strips      |
| A5   | Paket Ayam Goreng Kremes  |
| A6   | Paket Spicy Chicken Burger|

---

## 🛠️ Fitur Utama

| Halaman          | Fitur                                             |
|------------------|---------------------------------------------------|
| Dashboard        | Stat cards, preview ranking, bobot chart          |
| Data Kriteria    | CRUD + bobot progress bar + validasi total 100%   |
| Data Alternatif  | CRUD + card view + status kelengkapan nilai       |
| Input Nilai      | Form dinamis per alternatif + rekap matriks       |
| Proses SAW       | 4 langkah transparan + winner card + bar chart    |

---

## 🎨 Teknologi

- **Backend**: PHP 8 (native, tanpa framework)
- **Database**: MySQL dengan PDO/MySQLi
- **CSS**: Custom design system (tanpa Bootstrap/Tailwind)
- **Font**: Plus Jakarta Sans (Google Fonts)
- **Icons**: Font Awesome 6
- **JS**: Vanilla JavaScript (modal, toast, sort)

---

*Dibuat untuk UMKM Hayo Chicken — Sistem SPK SAW*
