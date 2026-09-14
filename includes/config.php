<?php
// Deteksi otomatis: ini dibuka dari lokal (Laragon) atau dari hosting InfinityFree?
$host = $_SERVER['HTTP_HOST'] ?? '';
$is_local = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);

if ($is_local) {
    // ===== Konfigurasi buat development di Laragon =====
    define('BASE_URL', '/website_pondok'); // sesuaikan kalau nama folder lokal kamu beda
    $db_host = 'localhost';
    $db_name = 'pesantren_amaliah';
    $db_user = 'root';
    $db_pass = '';
} else {
    // ===== Konfigurasi buat production di InfinityFree =====
    define('BASE_URL', '');
    $db_host = 'sql103.infinityfree.com';
    $db_name = 'if0_42886906_pesantren';
    $db_user = 'if0_42886906';
    $db_pass = 'Bintang0807';
}

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