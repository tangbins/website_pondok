<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Profil Yayasan';
$active = 'profil';

$stmt = $pdo->prepare("SELECT * FROM halaman_statis WHERE slug = 'profil-yayasan'");
$stmt->execute();
$halaman = $stmt->fetch(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Tentang kami</div>
    <h1><?= e($halaman['judul'] ?? 'Tentang Yayasan YPSPIA') ?></h1>
  </div>
</section>

<section class="section">
  <div class="container">
    <p class="desc" style="font-size:15px;"><?= nl2br(e($halaman['konten'] ?? '')) ?></p>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="eyebrow">Video profil</div>
    <h2>Kenali pondok lebih dekat</h2>
    <div style="position:relative; padding-bottom:56.25%; height:0; border-radius:12px; overflow:hidden; background:#000;">
      <iframe src="https://www.youtube.com/embed/GANTI_DENGAN_ID_VIDEO" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;" allowfullscreen></iframe>
    </div>
    <p style="font-size:12.5px; color:#6a6a6a; margin-top:10px;">Ganti tautan video di atas dengan video profil pondok yang sudah ada.</p>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
