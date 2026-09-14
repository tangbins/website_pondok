<?php
// PENTING: sesuaikan ini kalau nama foldernya beda / ganti hosting.
// Kalau website ditaruh di localhost/website_pondok/  -> isi '/website_pondok'
// Kalau website ditaruh langsung di root domain (di hosting nanti) -> isi '' (string kosong)
define('BASE_URL', '/website_pondok');

// Konfigurasi koneksi database
// Sesuaikan kalau di hosting nanti username/password-nya beda

$db_host = 'sql103.infinityfree.com';
$db_name = 'if0_42886906_pesantren';
$db_user = 'if0_42886906';
$db_pass = 'Bintang0807';

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
    'alamat'    => 'Jl. Tol Ciawi No. 1 (Komplek Universitas Djuanda Bogor)',
    'telepon'   => '0895-1559-1058',
    'email'     => 'info@amaliah.sch.id',
    'ig_putra'  => '@ppbintaamaliyah',
    'ig_putri'  => '@ppbintaamaliyah_putri',
];
