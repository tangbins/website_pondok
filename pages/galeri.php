<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Galeri';
$active = 'galeri';

$galeri = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Dokumentasi</div>
    <h1>Galeri</h1>
    <p>Momen kegiatan santri, dari kelas hingga acara tahunan pondok.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="fasilitas-grid">
      <?php if (empty($galeri)): ?>
        <p class="desc">Belum ada foto/video di galeri. Tambahkan lewat panel admin.</p>
      <?php else:
        foreach ($galeri as $g): ?>
          <?php if ($g['jenis'] === 'video'):
            $yid = youtube_id($g['file_path']); ?>
            <a href="<?= e($g['file_path']) ?>" target="_blank" class="fasilitas-card" data-aos="fade-up">
              <div class="fasilitas-thumb"
                style="position:relative; <?= $yid ? "background-image:url('https://img.youtube.com/vi/{$yid}/mqdefault.jpg'); background-size:cover; background-position:center;" : '' ?>">
                <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                  <div
                    style="width:44px; height:44px; border-radius:50%; background:rgba(0,0,0,0.55); color:#fff; display:flex; align-items:center; justify-content:center; font-size:16px;">
                    &#9658;</div>
                </div>
              </div>
              <div class="fasilitas-body">
                <div class="f-title"><?= e($g['judul']) ?></div>
              </div>
            </a>
          <?php else: ?>
            <div class="fasilitas-card" data-aos="fade-up">
              <div class="fasilitas-thumb"
                style="<?= $g['file_path'] ? "background-image:url('" . BASE_URL . "/assets/img/galeri/{$g['file_path']}'); background-size:cover;" : '' ?>">
              </div>
              <div class="fasilitas-body">
                <div class="f-title"><?= e($g['judul']) ?></div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>