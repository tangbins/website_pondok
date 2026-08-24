<?php
require_once __DIR__ . '/../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/pages/psb.php');
    exit;
}

// Ambil data dari form, trim biar ga ada spasi nyasar
$nama_lengkap   = trim($_POST['nama_lengkap'] ?? '');
$nik            = trim($_POST['nik'] ?? '');
$jenjang        = trim($_POST['jenjang_pilihan'] ?? '');
$asal_sekolah   = trim($_POST['asal_sekolah'] ?? '');
$nama_ortu      = trim($_POST['nama_ortu'] ?? '');
$no_hp          = trim($_POST['no_hp'] ?? '');
$email          = trim($_POST['email'] ?? '');
$alamat         = trim($_POST['alamat'] ?? '');

// Validasi field wajib
if ($nama_lengkap === '' || $jenjang === '' || $nama_ortu === '' || $no_hp === '') {
    header('Location: ' . BASE_URL . '/pages/psb.php?status=gagal');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO ppdb_pendaftar (nama_lengkap, nik, jenjang_pilihan, asal_sekolah, nama_ortu, no_hp, email, alamat)
     VALUES (:nama_lengkap, :nik, :jenjang, :asal_sekolah, :nama_ortu, :no_hp, :email, :alamat)"
);
$stmt->execute([
    ':nama_lengkap' => $nama_lengkap,
    ':nik'          => $nik,
    ':jenjang'      => $jenjang,
    ':asal_sekolah' => $asal_sekolah,
    ':nama_ortu'    => $nama_ortu,
    ':no_hp'        => $no_hp,
    ':email'        => $email,
    ':alamat'       => $alamat,
]);

header('Location: ' . BASE_URL . '/pages/psb.php?status=sukses');
exit;
