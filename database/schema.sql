-- =========================================================
-- Database Pondok Pesantren Amaliah
-- Import file ini lewat phpMyAdmin atau: mysql -u root -p < schema.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS pesantren_amaliah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pesantren_amaliah;

-- ---------------------------------------------------------
-- Admin (buat login panel admin)
-- ---------------------------------------------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- password default: admin123 (sudah di-hash pakai password_hash PHP)
INSERT INTO admin (username, password, nama_lengkap) VALUES
('admin', '$2y$10$5Vf5j8n2b0m8Z1uQ0lYFB.Kv2XY2iZ7dQ0vQwq0m9d3Q7Bq0m9d3Q', 'Admin Pesantren Amaliah');
-- CATATAN: hash di atas cuma placeholder, generate ulang lewat generate_password.php (disertakan)

-- ---------------------------------------------------------
-- Berita & kegiatan
-- ---------------------------------------------------------
CREATE TABLE berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    slug VARCHAR(220) UNIQUE NOT NULL,
    ringkasan TEXT,
    isi TEXT,
    gambar VARCHAR(255) DEFAULT NULL,
    tanggal DATE NOT NULL,
    status ENUM('draft','publish') DEFAULT 'publish',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO berita (judul, slug, ringkasan, isi, tanggal, status) VALUES
('Haflah Akhirussanah Tahun Ajaran Ini', 'haflah-akhirussanah', 'Acara pelepasan santri kelas akhir berlangsung khidmat di aula utama.', 'Isi lengkap berita di sini...', '2026-07-12', 'publish'),
('Kajian Tafsir Bulanan Bersama Ustadz', 'kajian-tafsir-bulanan', 'Kajian rutin membahas tafsir surat Al-Kahfi bersama para asatidz.', 'Isi lengkap berita di sini...', '2026-07-05', 'publish'),
('Santri Raih Juara Lomba Pencak Silat', 'santri-juara-pencak-silat', 'Tim ekstrakurikuler pencak silat pondok meraih juara 1 tingkat kabupaten.', 'Isi lengkap berita di sini...', '2026-06-28', 'publish');

-- ---------------------------------------------------------
-- Galeri (foto/video kegiatan)
-- ---------------------------------------------------------
CREATE TABLE galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150),
    jenis ENUM('foto','video') DEFAULT 'foto',
    file_path VARCHAR(255),
    kategori VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Fasilitas
-- ---------------------------------------------------------
CREATE TABLE fasilitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    kategori ENUM('belajar','ibadah','penunjang') DEFAULT 'penunjang',
    deskripsi TEXT,
    gambar VARCHAR(255) DEFAULT NULL,
    urutan INT DEFAULT 0
);

INSERT INTO fasilitas (nama, kategori, deskripsi, urutan) VALUES
('Ruang Kelas', 'belajar', 'Ruang kelas ber-AC dengan kapasitas 30 santri, dilengkapi proyektor.', 1),
('Perpustakaan', 'belajar', 'Koleksi buku pelajaran umum dan kitab keislaman.', 2),
('Laboratorium Komputer', 'belajar', 'Lab komputer untuk pembelajaran IT dan ujian berbasis komputer.', 3),
('Masjid Utama', 'ibadah', 'Masjid dengan kapasitas 500 jamaah untuk sholat berjamaah dan kajian.', 1),
('Asrama Putra', 'penunjang', 'Asrama santri putra dengan kapasitas per kamar 8-10 santri.', 1),
('Asrama Putri', 'penunjang', 'Asrama santri putri dengan kapasitas per kamar 8-10 santri.', 2),
('Klinik Kesehatan', 'penunjang', 'Layanan kesehatan dasar dengan tenaga medis siaga.', 3),
('Lapangan Olahraga', 'penunjang', 'Lapangan futsal dan bulutangkis untuk kegiatan ekstrakurikuler.', 4);

-- ---------------------------------------------------------
-- Pengajar & struktur
-- ---------------------------------------------------------
CREATE TABLE pengajar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    jabatan VARCHAR(150),
    jenjang ENUM('pimpinan','struktural','smp','sma') DEFAULT 'smp',
    bidang VARCHAR(100),
    foto VARCHAR(255) DEFAULT NULL,
    urutan INT DEFAULT 0
);

INSERT INTO pengajar (nama, jabatan, jenjang, bidang, urutan) VALUES
('KH. (Nama Pengasuh)', 'Pengasuh Pondok Pesantren', 'pimpinan', 'Pimpinan', 1),
('(Nama Bendahara)', 'Bendahara Yayasan', 'struktural', 'Keuangan', 1),
('(Nama Kepala TU)', 'Kepala Tata Usaha', 'struktural', 'Administrasi', 2),
('(Nama Kepala Sekolah SMP)', 'Kepala Sekolah', 'smp', 'Manajemen', 1),
('(Nama Kepala Sekolah SMA)', 'Kepala Sekolah', 'sma', 'Manajemen', 1);

-- ---------------------------------------------------------
-- PSB - gelombang pendaftaran
-- ---------------------------------------------------------
CREATE TABLE ppdb_gelombang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_gelombang VARCHAR(100),
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    biaya_pendaftaran DECIMAL(12,0)
);

INSERT INTO ppdb_gelombang (nama_gelombang, tanggal_mulai, tanggal_selesai, biaya_pendaftaran) VALUES
('Gelombang 1', '2026-11-01', '2026-12-31', 150000),
('Gelombang 2', '2027-01-01', '2027-02-28', 200000);

-- ---------------------------------------------------------
-- PSB - rincian biaya per jenjang
-- ---------------------------------------------------------
CREATE TABLE ppdb_biaya (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenjang ENUM('smp','sma') NOT NULL,
    komponen VARCHAR(150) NOT NULL,
    jumlah DECIMAL(12,0) NOT NULL,
    keterangan VARCHAR(255),
    urutan INT DEFAULT 0
);

INSERT INTO ppdb_biaya (jenjang, komponen, jumlah, keterangan, urutan) VALUES
('smp', 'Uang Pangkal / Dana Pembangunan', 5000000, 'Dibayarkan sekali saat masuk', 1),
('smp', 'SPP Bulanan', 750000, 'Termasuk makan 3x sehari', 2),
('smp', 'Seragam & Perlengkapan', 1500000, 'Dibayarkan sekali saat masuk', 3),
('sma', 'Uang Pangkal / Dana Pembangunan', 6000000, 'Dibayarkan sekali saat masuk', 1),
('sma', 'SPP Bulanan', 850000, 'Termasuk makan 3x sehari', 2),
('sma', 'Seragam & Perlengkapan', 1750000, 'Dibayarkan sekali saat masuk', 3);

-- ---------------------------------------------------------
-- PSB - data pendaftar (masuk dari form online)
-- ---------------------------------------------------------
CREATE TABLE ppdb_pendaftar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(150) NOT NULL,
    nik VARCHAR(20),
    jenjang_pilihan ENUM('smp','sma') NOT NULL,
    asal_sekolah VARCHAR(150),
    nama_ortu VARCHAR(150),
    no_hp VARCHAR(20) NOT NULL,
    email VARCHAR(150),
    alamat TEXT,
    status ENUM('menunggu','diverifikasi','ditolak','diterima') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------------------
-- Halaman statis (biar admin bisa edit teks profil dsb tanpa ubah kode)
-- ---------------------------------------------------------
CREATE TABLE halaman_statis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) UNIQUE NOT NULL,
    judul VARCHAR(200),
    konten TEXT
);

INSERT INTO halaman_statis (slug, judul, konten) VALUES
('profil-yayasan', 'Tentang Yayasan YPSPIA', 'Yayasan Pusat Studi Pengembangan Islam Amaliyah menaungi Pondok Pesantren Bina Tauhid Amaliyah, membina santri dari jenjang SMP hingga SMA dalam satu ekosistem pendidikan tahfidz yang berkesinambungan. Tulis sejarah dan visi misi lengkap di sini melalui panel admin.');
