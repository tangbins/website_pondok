<?php
// PENTING: sesuaikan ini kalau nama foldernya beda / ganti hosting.
// Kalau website ditaruh di localhost/website_pondok/  -> isi '/website_pondok'
// Kalau website ditaruh langsung di root domain (di hosting nanti) -> isi '' (string kosong)
define('BASE_URL', '/website_pondok');

// Konfigurasi koneksi database
// Sesuaikan kalau di hosting nanti username/password-nya beda

$db_host = 'localhost';
$db_name = 'pesantren_amaliah';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Koneksi database gagal. Cek konfigurasi di includes/config.php');
}

// Info umum situs, dipakai di header/footer biar gampang diubah dari satu tempat
$site = [
    'nama'      => 'Pondok Pesantren Amaliah',
    'yayasan'   => 'Yayasan Pusat Studi Pengembangan Islam Amaliyah (YPSPIA)',
    'alamat'    => 'Jl. Raya Ciawi, Bogor, Jawa Barat',
    'telepon'   => '0895-1559-1058',
    'email'     => 'info@amaliah.sch.id',
    'ig_putra'  => '@ppbintaamaliyah',
    'ig_putri'  => '@ppbintaamaliyah_putri',
];
