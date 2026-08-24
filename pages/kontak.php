<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kontak';
$active = 'kontak';

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Hubungi kami</div>
    <h1>Kontak</h1>
    <p>Ada pertanyaan seputar pondok atau PSB? Hubungi kami lewat kontak berikut.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="display:grid; grid-template-columns:1fr; gap:24px;">
    <div>
      <div class="eyebrow">Alamat</div>
      <p class="desc"><?= e($site['alamat']) ?></p>
      <div class="eyebrow">Telepon / WhatsApp</div>
      <p class="desc"><?= e($site['telepon']) ?></p>
      <div class="eyebrow">Email</div>
      <p class="desc"><?= e($site['email']) ?></p>
      <div class="eyebrow">Instagram</div>
      <p class="desc"><?= e($site['ig_putra']) ?> &middot; <?= e($site['ig_putri']) ?></p>
    </div>
    <div class="footer-map" style="min-height:280px; border-radius:12px;">peta lokasi (embed google maps di sini)</div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
