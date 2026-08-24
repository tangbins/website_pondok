<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Fasilitas';
$active = 'fasilitas';

$stmt = $pdo->query("SELECT * FROM fasilitas ORDER BY kategori, urutan ASC");
$semua = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kelompokkan berdasarkan kategori biar gampang di-loop per section
$kategori_label = ['belajar' => 'Fasilitas Belajar', 'ibadah' => 'Fasilitas Ibadah', 'penunjang' => 'Fasilitas Penunjang'];
$grouped = ['belajar' => [], 'ibadah' => [], 'penunjang' => []];
foreach ($semua as $f) {
    $grouped[$f['kategori']][] = $f;
}

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Sarana &amp; prasarana</div>
    <h1>Fasilitas pondok</h1>
    <p>Lingkungan belajar dan tinggal yang mendukung santri fokus menghafal, belajar, dan tumbuh mandiri.</p>
  </div>
</section>

<?php foreach ($grouped as $kategori => $items): if (empty($items)) continue; ?>
<section class="section <?= $kategori == 'ibadah' ? 'section-tint' : '' ?>">
  <div class="container">
    <span class="fasilitas-kategori-label"><?= e($kategori_label[$kategori]) ?></span>
    <div class="fasilitas-grid">
      <?php foreach ($items as $f): ?>
        <div class="fasilitas-card" data-aos="fade-up">
          <div class="fasilitas-thumb" style="<?= $f['gambar'] ? "background-image:url('" . BASE_URL . "/assets/img/fasilitas/{$f['gambar']}'); background-size:cover;" : '' ?>"></div>
          <div class="fasilitas-body">
            <div class="f-title"><?= e($f['nama']) ?></div>
            <div class="f-desc"><?= e($f['deskripsi']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
