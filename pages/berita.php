<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Berita & Kegiatan';
$active = 'berita';

$berita = $pdo->query("SELECT * FROM berita WHERE status='publish' ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Update</div>
    <h1>Berita &amp; kegiatan</h1>
    <p>Kabar terbaru seputar kegiatan santri, prestasi, dan agenda pondok.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="berita-grid">
      <?php if (empty($berita)): ?>
        <p class="desc">Belum ada berita.</p>
      <?php else: foreach ($berita as $b): ?>
        <a href="<?= BASE_URL ?>/pages/berita-detail.php?slug=<?= e($b['slug']) ?>" class="berita-card" data-aos="fade-up">
          <div class="berita-thumb" style="<?= $b['gambar'] ? "background-image:url('" . BASE_URL . "/assets/img/berita/{$b['gambar']}'); background-size:cover;" : '' ?>"></div>
          <div class="berita-body">
            <div class="berita-date"><?= tanggal_indo($b['tanggal']) ?></div>
            <div class="berita-title"><?= e($b['judul']) ?></div>
            <div class="berita-ringkasan"><?= e($b['ringkasan']) ?></div>
          </div>
        </a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
