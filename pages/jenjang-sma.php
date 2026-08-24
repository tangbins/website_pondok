<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Jenjang SMA';
$active = 'sma';

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <img src="<?= BASE_URL ?>/assets/img/logo-itbs.png" alt="Logo ITBS Amaliah" style="width:64px; height:64px; margin-bottom:16px;">
    <div class="hero-eyebrow">Jenjang SMA</div>
    <h1>ITBS Amaliah - International Tahfidz Boarding School</h1>
    <p>Pendalaman tahfidz lanjutan dengan wawasan internasional dan persiapan studi lanjut santri.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="eyebrow">Kurikulum</div>
    <h2>Yang dipelajari santri SMA</h2>
    <p class="desc">Target penyelesaian hafalan 30 juz, pendalaman bahasa Arab dan Inggris, kurikulum nasional jenjang SMA, serta pembinaan persiapan studi lanjut ke perguruan tinggi dalam maupun luar negeri.</p>

    <div class="eyebrow">Ekstrakurikuler</div>
    <h2>Kegiatan penunjang</h2>
    <p class="desc">Debat bahasa Arab/Inggris, jurnalistik, olimpiade sains, panahan, dan organisasi santri (OSSA) untuk melatih kepemimpinan.</p>
  </div>
</section>

<section class="cta-band" data-aos="zoom-in">
  <h3>Tertarik mendaftarkan putra/putri ke jenjang SMA?</h3>
  <p>Cek jadwal dan syarat pendaftaran</p>
  <a href="<?= BASE_URL ?>/pages/psb.php"><button class="btn-white">Info PSB</button></a>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
