<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Dashboard';

$jumlah_berita = $pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
$jumlah_pendaftar = $pdo->query("SELECT COUNT(*) FROM ppdb_pendaftar")->fetchColumn();
$jumlah_menunggu = $pdo->query("SELECT COUNT(*) FROM ppdb_pendaftar WHERE status='menunggu'")->fetchColumn();
$jumlah_fasilitas = $pdo->query("SELECT COUNT(*) FROM fasilitas")->fetchColumn();
$jumlah_pengajar = $pdo->query("SELECT COUNT(*) FROM pengajar")->fetchColumn();
$jumlah_galeri = $pdo->query("SELECT COUNT(*) FROM galeri")->fetchColumn();

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Halo, <?= e($_SESSION['admin_nama']) ?></h2>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin-bottom:20px;">
  <div class="admin-card">
    <div style="font-size:12px; color:#7a7a7a;">Total berita</div>
    <div style="font-size:24px; font-weight:600;"><?= $jumlah_berita ?></div>
  </div>
  <div class="admin-card">
    <div style="font-size:12px; color:#7a7a7a;">Pendaftar PSB</div>
    <div style="font-size:24px; font-weight:600;"><?= $jumlah_pendaftar ?></div>
  </div>
  <div class="admin-card">
    <div style="font-size:12px; color:#7a7a7a;">Menunggu verifikasi</div>
    <div style="font-size:24px; font-weight:600; color:#ee7a00;"><?= $jumlah_menunggu ?></div>
  </div>
</div>

<div class="admin-card">
  <h3 style="margin-bottom:10px; font-size:14px;">Menu</h3>
  <p style="font-size:13px; color:#6a6a6a; line-height:1.8;">
    &rarr; <a href="<?= BASE_URL ?>/admin/berita.php" class="btn" style="margin:4px 6px 4px 0;">Kelola Berita</a>
    &rarr; <a href="<?= BASE_URL ?>/admin/ppdb.php" class="btn" style="margin:4px 6px 4px 0;">Verifikasi PSB</a>
    &rarr; <a href="<?= BASE_URL ?>/admin/fasilitas.php" class="btn" style="margin:4px 6px 4px 0;">Kelola Fasilitas</a>
    &rarr; <a href="<?= BASE_URL ?>/admin/galeri.php" class="btn" style="margin:4px 6px 4px 0;">Kelola Galeri</a>
    &rarr; <a href="<?= BASE_URL ?>/admin/pengajar.php" class="btn" style="margin:4px 6px 4px 0;">Kelola Pengajar</a>
  </p>
  <p style="font-size:12px; color:#9a9a9a; margin-top:12px;">Catatan: halaman kelola fasilitas, galeri, dan pengajar
    belum dibuatkan CRUD-nya - polanya sama persis kayak berita.php, tinggal disalin dan disesuaikan nama
    tabel/kolomnya.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>