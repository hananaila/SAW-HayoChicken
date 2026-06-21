-- ============================================================
-- DATABASE: spk_hayo_chicken
-- Sistem Pendukung Keputusan (SPK) - Metode SAW
-- UMKM Hayo Chicken
-- ============================================================



-- ------------------------------------------------------------
-- TABEL: kriteria
-- Menyimpan daftar kriteria beserta bobot dan sifatnya
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS kriteria (
    id_kriteria   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_kriteria VARCHAR(10)    NOT NULL UNIQUE,
    nama_kriteria VARCHAR(100)   NOT NULL,
    bobot         DECIMAL(5,2)   NOT NULL COMMENT 'Bobot dalam persen, total = 100',
    sifat         ENUM('Benefit','Cost') NOT NULL COMMENT 'Benefit = max lebih baik, Cost = min lebih baik',
    keterangan    TEXT           NULL,
    created_at    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABEL: alternatif
-- Menyimpan daftar paket menu Hayo Chicken
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS alternatif (
    id_alternatif   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_alternatif VARCHAR(10)  NOT NULL UNIQUE,
    nama_alternatif VARCHAR(150) NOT NULL,
    deskripsi       TEXT         NULL,
    harga           DECIMAL(10,0) NULL COMMENT 'Harga jual dalam Rupiah',
    gambar          VARCHAR(255) NULL,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- TABEL: penilaian
-- Menyimpan nilai setiap alternatif terhadap setiap kriteria
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS penilaian (
    id_penilaian    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_alternatif   INT UNSIGNED NOT NULL,
    id_kriteria     INT UNSIGNED NOT NULL,
    nilai           DECIMAL(10,4) NOT NULL COMMENT 'Nilai mentah dari survei/data',
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_alt_krit (id_alternatif, id_kriteria),
    FOREIGN KEY (id_alternatif) REFERENCES alternatif(id_alternatif) ON DELETE CASCADE,
    FOREIGN KEY (id_kriteria)   REFERENCES kriteria(id_kriteria)     ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- DATA AWAL: KRITERIA
-- Bobot total = 100%
-- ============================================================
INSERT INTO kriteria (kode_kriteria, nama_kriteria, bobot, sifat, keterangan) VALUES
('C1', 'Margin Keuntungan', 30.00, 'Benefit', 'Persentase keuntungan bersih per paket menu'),
('C2', 'Tingkat Popularitas', 25.00, 'Benefit', 'Tingkat peminatan/pemesanan berdasarkan survei pelanggan (skala 1-5)'),
('C3', 'Harga Jual',          20.00, 'Cost',    'Harga jual paket menu kepada pelanggan (Rupiah)'),
('C4', 'Biaya Produksi',      15.00, 'Cost',    'Total biaya bahan baku & operasional per porsi (Rupiah)'),
('C5', 'Tingkat Kepuasan',    10.00, 'Benefit', 'Rata-rata skor kepuasan pelanggan dari kuesioner (skala 1-5)');

-- ============================================================
-- DATA AWAL: ALTERNATIF (Paket Menu Hayo Chicken)
-- ============================================================
INSERT INTO alternatif (kode_alternatif, nama_alternatif, deskripsi, harga) VALUES
('A1', 'Paket Ayam Geprek',        'Ayam goreng crispy dengan sambal geprek, nasi, dan lalapan',                   18000),
('A2', 'Paket Chicken Katsu',       'Chicken katsu saus asam manis, nasi, dan salad kol',                          22000),
('A3', 'Paket Ayam Bakar',          'Ayam bakar bumbu kecap/kuning, nasi, lalapan, dan sambal',                    20000),
('A4', 'Paket Chicken Strips',      'Chicken strips crispy dengan saus ranch atau BBQ, nasi, dan coleslaw',         25000),
('A5', 'Paket Ayam Goreng Kremes',  'Ayam goreng tradisional dengan kremes renyah, nasi, dan sambal terasi',       19000),
('A6', 'Paket Spicy Chicken Burger','Burger ayam pedas dengan selada, tomat, keju, dan kentang goreng',            28000);

-- ============================================================
-- DATA AWAL: PENILAIAN
-- Nilai untuk setiap alternatif terhadap setiap kriteria
-- C1: Margin (%)  | C2: Popularitas (1-5) | C3: Harga Jual (Rp)
-- C4: Biaya Prod (Rp) | C5: Kepuasan (1-5)
-- ============================================================
INSERT INTO penilaian (id_alternatif, id_kriteria, nilai) VALUES
-- A1 - Paket Ayam Geprek
(1, 1, 45.00),   -- C1: Margin 45%
(1, 2,  4.50),   -- C2: Popularitas 4.5/5
(1, 3, 18000),   -- C3: Harga Jual Rp18.000
(1, 4,  9900),   -- C4: Biaya Produksi Rp9.900
(1, 5,  4.30),   -- C5: Kepuasan 4.3/5

-- A2 - Paket Chicken Katsu
(2, 1, 40.00),   -- C1: Margin 40%
(2, 2,  4.20),   -- C2: Popularitas 4.2/5
(2, 3, 22000),   -- C3: Harga Jual Rp22.000
(2, 4, 13200),   -- C4: Biaya Produksi Rp13.200
(2, 5,  4.10),   -- C5: Kepuasan 4.1/5

-- A3 - Paket Ayam Bakar
(3, 1, 38.00),   -- C1: Margin 38%
(3, 2,  3.80),   -- C2: Popularitas 3.8/5
(3, 3, 20000),   -- C3: Harga Jual Rp20.000
(3, 4, 12400),   -- C4: Biaya Produksi Rp12.400
(3, 5,  4.00),   -- C5: Kepuasan 4.0/5

-- A4 - Paket Chicken Strips
(4, 1, 36.00),   -- C1: Margin 36%
(4, 2,  3.60),   -- C2: Popularitas 3.6/5
(4, 3, 25000),   -- C3: Harga Jual Rp25.000
(4, 4, 16000),   -- C4: Biaya Produksi Rp16.000
(4, 5,  3.90),   -- C5: Kepuasan 3.9/5

-- A5 - Paket Ayam Goreng Kremes
(5, 1, 42.00),   -- C1: Margin 42%
(5, 2,  4.00),   -- C2: Popularitas 4.0/5
(5, 3, 19000),   -- C3: Harga Jual Rp19.000
(5, 4, 11020),   -- C4: Biaya Produksi Rp11.020
(5, 5,  4.20),   -- C5: Kepuasan 4.2/5

-- A6 - Paket Spicy Chicken Burger
(6, 1, 35.00),   -- C1: Margin 35%
(6, 2,  3.50),   -- C2: Popularitas 3.5/5
(6, 3, 28000),   -- C3: Harga Jual Rp28.000
(6, 4, 18200),   -- C4: Biaya Produksi Rp18.200
(6, 5,  3.70);   -- C5: Kepuasan 3.7/5
