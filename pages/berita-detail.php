<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM berita WHERE slug = :slug AND status = 'publish'");
$stmt->execute([':slug' => $slug]);
$b = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$b) {
    header('Location: ' . BASE_URL . '/pages/berita.php');
    exit;
}

$page_title = $b['judul'];
$active = 'berita';

include __DIR__ . '/../includes/header.php';
?>

<section class="section" data-aos="fade-up">
  <div class="container max-w-3xl">
    <div class="eyebrow"><?= tanggal_indo($b['tanggal']) ?></div>
    <h1 class="font-display font-semibold text-2xl text-teal-deep mb-5"><?= e($b['judul']) ?></h1>
    <div class="berita-thumb h-64 rounded-xl mb-5 <?= $b['gambar'] ? '' : '' ?>" style="<?= $b['gambar'] ? "background-image:url('" . BASE_URL . "/assets/img/berita/{$b['gambar']}'); background-size:cover;" : '' ?>"></div>
    <p class="desc text-[15px]"><?= nl2br(e($b['isi'])) ?></p>
    <a href="<?= BASE_URL ?>/pages/berita.php" class="link-arrow text-teal">&larr; Kembali ke berita</a>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
