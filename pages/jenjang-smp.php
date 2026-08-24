<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Jenjang SMP';
$active = 'smp';

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <img src="<?= BASE_URL ?>/assets/img/logo-binta.png" alt="Logo Bina Tauhid Amaliyah" style="width:64px; height:64px; margin-bottom:16px;">
    <div class="hero-eyebrow">Jenjang SMP</div>
    <h1>Pondok Pesantren Bina Tauhid Amaliyah</h1>
    <p>Program tahfidz dasar, pembentukan karakter, dan penguatan akademik untuk santri usia SMP.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="eyebrow">Kurikulum</div>
    <h2>Yang dipelajari santri SMP</h2>
    <p class="desc">Kombinasi kurikulum diniyah (tahfidz, tahsin, kitab dasar) dengan kurikulum nasional (mapel umum sesuai jenjang SMP), diampu oleh ustadz/ustadzah dan guru bersertifikasi.</p>

    <div class="eyebrow">Ekstrakurikuler</div>
    <h2>Kegiatan penunjang</h2>
    <p class="desc">Pencak silat, futsal, seni kaligrafi, marawis, dan pramuka - membentuk santri yang seimbang antara akademik, keterampilan, dan fisik.</p>
  </div>
</section>

<section class="cta-band" data-aos="zoom-in">
  <h3>Tertarik mendaftarkan putra/putri ke jenjang SMP?</h3>
  <p>Cek jadwal dan syarat pendaftaran</p>
  <a href="<?= BASE_URL ?>/pages/psb.php"><button class="btn-white">Info PSB</button></a>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
