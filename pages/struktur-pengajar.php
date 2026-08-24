<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Struktur & Pengajar';
$active = 'pengajar';

$pimpinan = $pdo->query("SELECT * FROM pengajar WHERE jenjang='pimpinan' ORDER BY urutan")->fetchAll(PDO::FETCH_ASSOC);
$struktural = $pdo->query("SELECT * FROM pengajar WHERE jenjang='struktural' ORDER BY urutan")->fetchAll(PDO::FETCH_ASSOC);
$smp = $pdo->query("SELECT * FROM pengajar WHERE jenjang='smp' ORDER BY urutan")->fetchAll(PDO::FETCH_ASSOC);
$sma = $pdo->query("SELECT * FROM pengajar WHERE jenjang='sma' ORDER BY urutan")->fetchAll(PDO::FETCH_ASSOC);

function inisial($nama) {
    $kata = explode(' ', trim($nama));
    return strtoupper(substr($kata[0], 0, 1) . (isset($kata[1]) ? substr($kata[1], 0, 1) : ''));
}

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">Kepengurusan</div>
    <h1>Struktur &amp; pengajar</h1>
    <p>Dibina langsung oleh pengasuh, dijalankan tim struktural, dan dididik oleh tenaga pengajar berpengalaman di bidangnya.</p>
  </div>
</section>

<?php
$sections = [
    ['label' => 'Pimpinan', 'data' => $pimpinan, 'tint' => false],
    ['label' => 'Struktural', 'data' => $struktural, 'tint' => true],
    ['label' => 'Pengajar Jenjang SMP', 'data' => $smp, 'tint' => false],
    ['label' => 'Pengajar Jenjang SMA', 'data' => $sma, 'tint' => true],
];
foreach ($sections as $s): if (empty($s['data'])) continue; ?>
<section class="section <?= $s['tint'] ? 'section-tint' : '' ?>">
  <div class="container">
    <h2><?= e($s['label']) ?></h2>
    <div class="pengajar-grid" style="margin-top:16px;">
      <?php foreach ($s['data'] as $p): ?>
        <div class="pengajar-card" data-aos="fade-up">
          <?php if (!empty($p['foto'])): ?>
            <img src="<?= BASE_URL ?>/assets/img/pengajar/<?= e($p['foto']) ?>" class="pengajar-avatar" style="object-fit:cover;" alt="<?= e($p['nama']) ?>">
          <?php else: ?>
            <div class="pengajar-avatar"><?= e(inisial($p['nama'])) ?></div>
          <?php endif; ?>
          <div class="pengajar-nama"><?= e($p['nama']) ?></div>
          <div class="pengajar-jabatan"><?= e($p['jabatan']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>