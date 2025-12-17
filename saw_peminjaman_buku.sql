-- ======================================
-- DATABASE: saw_peminjaman_buku
-- ======================================

CREATE DATABASE IF NOT EXISTS saw_peminjaman_buku;
USE saw_peminjaman_buku;

-- ======================================
-- TABEL: anggota
-- ======================================
CREATE TABLE anggota (
    id_anggota INT PRIMARY KEY,
    nama_anggota VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    alamat VARCHAR(150),
    status_anggota ENUM('aktif','nonaktif') NOT NULL
);

-- Contoh data anggota
INSERT INTO anggota VALUES
(4,'Satria','L','A6','Bandung','aktif'),
(5,'Alvin','L','A3','Bandung','aktif'),
(6,'Marsha','P','A1','Bandung','aktif');

-- ======================================
-- TABEL: buku
-- ======================================
CREATE TABLE buku (
    id_buku INT PRIMARY KEY,
    judul_buku VARCHAR(150) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    jumlah_buku INT NOT NULL
);

-- Contoh data buku
INSERT INTO buku VALUES
(1,'Algoritma dan Pemrograman','Rinaldi Munir','Informatika',2020,'Teknologi',5),
(2,'Basis Data','Abdul Kadir','Andi Offset',2019,'Teknologi',4),
(3,'Pemrograman Web PHP','Bambang Hariyanto','Elex Media',2021,'Teknologi',6),
(4,'Sistem Pendukung Keputusan','Kusrini','Andi Offset',2018,'Sistem Informasi',3);

-- ======================================
-- TABEL: kriteria
-- ======================================
CREATE TABLE kriteria (
    id_kriteria INT PRIMARY KEY,
    nama_kriteria VARCHAR(50) NOT NULL,
    tipe ENUM('benefit','cost') NOT NULL,
    bobot DECIMAL(5,2) NOT NULL
);

-- Contoh data kriteria
INSERT INTO kriteria VALUES
(1,'Jumlah Pinjaman','benefit',0.30),
(2,'Kedisiplinan','benefit',0.25),
(3,'Lama Pinjam','cost',0.25),
(4,'Frekuensi Pinjam','benefit',0.20);

-- ======================================
-- TABEL: nilai_kriteria
-- ======================================
CREATE TABLE nilai_kriteria (
    id_nilai INT AUTO_INCREMENT PRIMARY KEY,
    id_anggota INT NOT NULL,
    id_kriteria INT NOT NULL,
    nilai DECIMAL(5,2) NOT NULL
);

-- Contoh data nilai_kriteria
INSERT INTO nilai_kriteria VALUES
(37,4,1,5.00),
(38,4,2,90.00),
(39,4,3,7.00),
(40,4,4,10.00),
(41,5,1,3.00),
(42,5,2,80.00),
(43,5,3,10.00),
(44,5,4,8.00),
(45,6,1,4.00),
(46,6,2,95.00),
(47,6,3,5.00),
(48,6,4,12.00);

-- ======================================
-- TABEL: peminjaman
-- ======================================
CREATE TABLE peminjaman (
    id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
    id_anggota INT NOT NULL,
    id_buku INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE,
    status_peminjaman ENUM('dipinjam','dikembalikan') NOT NULL
);

-- Contoh data peminjaman
INSERT INTO peminjaman VALUES
(1,4,1,'2024-01-05',NULL,'dipinjam'),
(2,4,2,'2024-02-01','2024-02-10','dikembalikan');

-- ======================================
-- TABEL: hasil_saw
-- ======================================
CREATE TABLE hasil_saw (
    id_hasil INT AUTO_INCREMENT PRIMARY KEY,
    id_anggota INT NOT NULL,
    nilai_preferensi DECIMAL(6,4) NOT NULL,
    peringkat INT NOT NULL,
    tanggal_penilaian DATE NOT NULL
);

-- Contoh data hasil_saw
INSERT INTO hasil_saw VALUES
(1,6,0.9400,1,'2025-12-15'),
(2,4,0.8821,2,'2025-12-15'),
(3,5,0.6489,3,'2025-12-15');
