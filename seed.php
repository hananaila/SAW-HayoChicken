<?php
// Tampilkan error jika ada
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password = "";

// 1. KONEKSI KE SERVER MYSQL (Tanpa nama DB!)
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Kumpulan Query untuk Setup Database
$sql = "
CREATE DATABASE IF NOT EXISTS spk_hayo_chicken;
USE spk_hayo_chicken;

DROP TABLE IF EXISTS kuesioner_pembeli;
DROP TABLE IF EXISTS kuesioner_penjual;
DROP TABLE IF EXISTS data_penjual;
DROP TABLE IF EXISTS alternatif;
DROP TABLE IF EXISTS kriteria;

CREATE TABLE kriteria (
    id_kriteria VARCHAR(2) PRIMARY KEY,
    nama_kriteria VARCHAR(50),
    sifat ENUM('Benefit', 'Cost'),
    bobot FLOAT
);

INSERT INTO kriteria VALUES
('C1', 'Margin Keuntungan', 'Benefit', 0.25),
('C2', 'Popularitas/Frekuensi', 'Benefit', 0.20),
('C3', 'Kepuasan Pelanggan', 'Benefit', 0.25),
('C4', 'Penggunaan Stok Bahan', 'Benefit', 0.15),
('C5', 'Harga Jual', 'Cost', 0.15);

CREATE TABLE alternatif (
    id_alternatif VARCHAR(2) PRIMARY KEY,
    nama_paket VARCHAR(100),
    harga_paket INT
);

INSERT INTO alternatif VALUES
('A1', 'Ayam Geprek + Nasi + Es Teh', 16000),
('A2', 'Chicken Katsu + Nasi + Es Teh', 19000),
('A3', 'Chicken Saus + Nasi + Es Teh', 16000),
('A4', 'Crispy Chicken Steak + Nasi + Es Teh', 19000),
('A5', 'Ayam Lalapan 1/4 + Nasi + Es Teh', 19000);

CREATE TABLE kuesioner_penjual (
    id_kuesioner INT AUTO_INCREMENT PRIMARY KEY,
    nama_internal VARCHAR(50),
    id_alternatif VARCHAR(2),
    c1_untung INT,
    c2_sering INT,
    c4_habis INT,
    FOREIGN KEY (id_alternatif) REFERENCES alternatif(id_alternatif)
);

INSERT INTO kuesioner_penjual (nama_internal, id_alternatif, c1_untung, c2_sering, c4_habis) VALUES
('rahma', 'A1', 4, 3, 3), ('rahma', 'A2', 3, 5, 4), ('rahma', 'A3', 4, 3, 3), ('rahma', 'A4', 3, 3, 2), ('rahma', 'A5', 4, 4, 5),
('Okti Salminah', 'A1', 5, 5, 5), ('Okti Salminah', 'A2', 3, 4, 3), ('Okti Salminah', 'A3', 3, 3, 3), ('Okti Salminah', 'A4', 3, 3, 3), ('Okti Salminah', 'A5', 2, 2, 2),
('lina', 'A1', 4, 4, 5), ('lina', 'A2', 4, 5, 5), ('lina', 'A3', 4, 4, 3), ('lina', 'A4', 4, 4, 4), ('lina', 'A5', 4, 3, 4);

CREATE TABLE kuesioner_pembeli (
    id_kuesioner INT AUTO_INCREMENT PRIMARY KEY,
    nama_pembeli VARCHAR(50),
    id_alternatif VARCHAR(2),
    c2_menarik INT,
    c3_worth_it INT,
    FOREIGN KEY (id_alternatif) REFERENCES alternatif(id_alternatif)
);

INSERT INTO kuesioner_pembeli (nama_pembeli, id_alternatif, c2_menarik, c3_worth_it) VALUES
('naila', 'A1', 2, 4), ('naila', 'A2', 5, 5), ('naila', 'A3', 3, 3), ('naila', 'A4', 5, 5), ('naila', 'A5', 4, 5),
('nayli', 'A1', 4, 4), ('nayli', 'A2', 4, 3), ('nayli', 'A3', 4, 3), ('nayli', 'A4', 3, 3), ('nayli', 'A5', 2, 2),
('faizia', 'A1', 5, 4), ('faizia', 'A2', 5, 3), ('faizia', 'A3', 3, 4), ('faizia', 'A4', 4, 5), ('faizia', 'A5', 2, 1),
('Tita', 'A1', 5, 5), ('Tita', 'A2', 5, 5), ('Tita', 'A3', 5, 5), ('Tita', 'A4', 5, 5), ('Tita', 'A5', 5, 5),
('Aulia', 'A1', 5, 5), ('Aulia', 'A2', 5, 5), ('Aulia', 'A3', 5, 5), ('Aulia', 'A4', 5, 5), ('Aulia', 'A5', 5, 5),
('yunan', 'A1', 4, 4), ('yunan', 'A2', 3, 4), ('yunan', 'A3', 4, 4), ('yunan', 'A4', 3, 4), ('yunan', 'A5', 4, 3),
('Hardy', 'A1', 1, 1), ('Hardy', 'A2', 5, 5), ('Hardy', 'A3', 1, 1), ('Hardy', 'A4', 5, 5), ('Hardy', 'A5', 1, 1),
('Salma', 'A1', 3, 2), ('Salma', 'A2', 4, 4), ('Salma', 'A3', 4, 4), ('Salma', 'A4', 5, 4), ('Salma', 'A5', 3, 3),
('Ajeng', 'A1', 4, 4), ('Ajeng', 'A2', 5, 4), ('Ajeng', 'A3', 3, 3), ('Ajeng', 'A4', 4, 4), ('Ajeng', 'A5', 3, 3),
('Dera', 'A1', 4, 4), ('Dera', 'A2', 4, 4), ('Dera', 'A3', 4, 4), ('Dera', 'A4', 4, 4), ('Dera', 'A5', 4, 4),
('Amelia', 'A1', 4, 4), ('Amelia', 'A2', 4, 3), ('Amelia', 'A3', 4, 3), ('Amelia', 'A4', 4, 4), ('Amelia', 'A5', 4, 4),
('napi', 'A1', 5, 5), ('napi', 'A2', 3, 3), ('napi', 'A3', 5, 5), ('napi', 'A4', 3, 3), ('napi', 'A5', 3, 3),
('Zahra', 'A1', 4, 4), ('Zahra', 'A2', 3, 4), ('Zahra', 'A3', 1, 3), ('Zahra', 'A4', 5, 5), ('Zahra', 'A5', 2, 3),
('Alifah', 'A1', 2, 4), ('Alifah', 'A2', 5, 4), ('Alifah', 'A3', 5, 5), ('Alifah', 'A4', 3, 1), ('Alifah', 'A5', 3, 4),
('Danial', 'A1', 1, 2), ('Danial', 'A2', 2, 3), ('Danial', 'A3', 2, 3), ('Danial', 'A4', 1, 4), ('Danial', 'A5', 2, 5),
('Nadzare', 'A1', 5, 5), ('Nadzare', 'A2', 4, 5), ('Nadzare', 'A3', 4, 5), ('Nadzare', 'A4', 4, 5), ('Nadzare', 'A5', 4, 5),
('Rizki', 'A1', 5, 5), ('Rizki', 'A2', 3, 4), ('Rizki', 'A3', 2, 4), ('Rizki', 'A4', 5, 4), ('Rizki', 'A5', 3, 4),
('Dinda', 'A1', 2, 3), ('Dinda', 'A2', 4, 3), ('Dinda', 'A3', 1, 5), ('Dinda', 'A4', 2, 5), ('Dinda', 'A5', 3, 5),
('Intan A', 'A1', 1, 3), ('Intan A', 'A2', 5, 2), ('Intan A', 'A3', 5, 3), ('Intan A', 'A4', 5, 5), ('Intan A', 'A5', 4, 5),
('sky', 'A1', 5, 4), ('sky', 'A2', 3, 3), ('sky', 'A3', 3, 3), ('sky', 'A4', 2, 3), ('sky', 'A5', 3, 3),
('Caca', 'A1', 1, 5), ('Caca', 'A2', 3, 5), ('Caca', 'A3', 1, 5), ('Caca', 'A4', 5, 3), ('Caca', 'A5', 5, 5),
('Huri', 'A1', 4, 5), ('Huri', 'A2', 1, 3), ('Huri', 'A3', 2, 3), ('Huri', 'A4', 5, 5), ('Huri', 'A5', 4, 4),
('Lula', 'A1', 3, 4), ('Lula', 'A2', 5, 5), ('Lula', 'A3', 1, 5), ('Lula', 'A4', 5, 4), ('Lula', 'A5', 4, 5),
('Aurel', 'A1', 5, 5), ('Aurel', 'A2', 3, 5), ('Aurel', 'A3', 5, 5), ('Aurel', 'A4', 1, 3), ('Aurel', 'A5', 5, 5),
('Novia', 'A1', 5, 5), ('Novia', 'A2', 5, 5), ('Novia', 'A3', 5, 5), ('Novia', 'A4', 5, 5), ('Novia', 'A5', 5, 5),
('Ganda', 'A1', 5, 4), ('Ganda', 'A2', 5, 4), ('Ganda', 'A3', 5, 5), ('Ganda', 'A4', 1, 3), ('Ganda', 'A5', 2, 3),
('Gita', 'A1', 5, 3), ('Gita', 'A2', 5, 4), ('Gita', 'A3', 5, 3), ('Gita', 'A4', 5, 2), ('Gita', 'A5', 5, 3),
('Melody', 'A1', 1, 3), ('Melody', 'A2', 4, 5), ('Melody', 'A3', 5, 5), ('Melody', 'A4', 4, 5), ('Melody', 'A5', 3, 5),
('Wisnu', 'A1', 3, 5), ('Wisnu', 'A2', 5, 5), ('Wisnu', 'A3', 4, 5), ('Wisnu', 'A4', 5, 5), ('Wisnu', 'A5', 5, 5),
('adit', 'A1', 4, 4), ('adit', 'A2', 4, 4), ('adit', 'A3', 4, 4), ('adit', 'A4', 4, 4), ('adit', 'A5', 4, 4),
('Alip', 'A1', 4, 4), ('Alip', 'A2', 4, 4), ('Alip', 'A3', 5, 5), ('Alip', 'A4', 5, 5), ('Alip', 'A5', 4, 4),
('Intan', 'A1', 5, 5), ('Intan', 'A2', 4, 4), ('Intan', 'A3', 5, 4), ('Intan', 'A4', 4, 5), ('Intan', 'A5', 5, 5),
('saryy', 'A1', 3, 2), ('saryy', 'A2', 3, 2), ('saryy', 'A3', 3, 2), ('saryy', 'A4', 3, 2), ('saryy', 'A5', 4, 3);
";

if (mysqli_multi_query($conn, $sql)) {
    echo "<h2 style='color:green; font-family:sans-serif; text-align:center; margin-top:50px;'>✅ Seeding Database Berhasil!</h2>";
    echo "<p style='text-align:center; font-family:sans-serif;'>Semua tabel dan data riil sudah masuk. Silakan buka halaman <a href='index.php'>Dashboard</a>.</p>";
} else {
    echo "<h2 style='color:red;'>❌ Gagal melakukan seeding: " . mysqli_error($conn) . "</h2>";
}

mysqli_close($conn);
?>