<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$page_title = 'Beranda';
$active = 'home';

// Ambil 3 berita terbaru yang statusnya publish
$stmt = $pdo->query("SELECT * FROM berita WHERE status='publish' ORDER BY tanggal DESC LIMIT 3");
$berita_terbaru = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<section class="hero" data-aos="fade-in">
  <div class="hero-inner">
    <div class="hero-eyebrow">Selamat datang</div>
    <h1>Mendidik generasi penghafal Al-Qur'an yang berakhlak</h1>
    <p>Pondok Pesantren Amaliah membina santri jenjang SMP dan SMA dengan program tahfidz, akademik, dan kehidupan asrama yang terarah.</p>
    <div class="hero-ctas">
      <a href="<?= BASE_URL ?>/pages/psb.php"><button class="btn-primary">Daftar PSB</button></a>
      <a href="<?= BASE_URL ?>/pages/profil-yayasan.php"><button class="btn-ghost">Lihat profil</button></a>
    </div>
  </div>
  <div class="arch-wrap">
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,60 L0,40 Q0,10 90,8 Q180,6 270,8 Q360,10 450,4 Q600,-6 750,4 Q840,10 930,8 Q1020,6 1110,8 Q1200,10 1200,40 L1200,60 Z" fill="#ffffff"/></svg>
  </div>
</section>

<div class="stats">
  <div class="stat" data-aos="fade-up"><div class="num">2</div><div class="label">Jenjang</div></div>
  <div class="stat" data-aos="fade-up"><div class="num">600+</div><div class="label">Santri</div></div>
  <div class="stat" data-aos="fade-up"><div class="num">30 juz</div><div class="label">Target tahfidz</div></div>
  <div class="stat" data-aos="fade-up"><div class="num">15+</div><div class="label">Tahun berdiri</div></div>
</div>

<section class="section">
  <div class="container">
    <div class="eyebrow">Tentang kami</div>
    <h2>Di bawah Yayasan YPSPIA</h2>
    <p class="desc">Yayasan Pusat Studi Pengembangan Islam Amaliyah menaungi Pondok Pesantren Bina Tauhid Amaliyah, membina santri dari jenjang SMP hingga SMA dalam satu ekosistem pendidikan tahfidz yang berkesinambungan.</p>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="eyebrow">Jenjang pendidikan</div>
    <h2>Pilih jenjang santri</h2>
    <div class="jenjang-grid">
      <div class="jenjang-card smp" data-aos="fade-up">
        <div class="jenjang-top">
          <img src="<?= BASE_URL ?>/assets/img/logo-binta.png" alt="Logo Bina Tauhid Amaliyah">
          <div>
            <div class="jt-name">Bina Tauhid Amaliyah</div>
            <div class="jt-tag">Jenjang SMP</div>
          </div>
        </div>
        <p>Program tahfidz dasar, pembentukan karakter, dan penguatan akademik untuk santri usia SMP.</p>
        <a class="link-arrow" href="<?= BASE_URL ?>/pages/jenjang-smp.php">Lihat detail &rarr;</a>
      </div>
      <div class="jenjang-card sma" data-aos="fade-up" data-aos-delay="100">
        <div class="jenjang-top">
          <img src="<?= BASE_URL ?>/assets/img/logo-itbs.png" alt="Logo ITBS Amaliah">
          <div>
            <div class="jt-name">ITBS Amaliah</div>
            <div class="jt-tag">Jenjang SMA</div>
          </div>
        </div>
        <p>Pendalaman tahfidz lanjutan dengan wawasan internasional dan persiapan studi lanjut santri.</p>
        <a class="link-arrow" href="<?= BASE_URL ?>/pages/jenjang-sma.php">Lihat detail &rarr;</a>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="eyebrow">Program unggulan</div>
    <h2>Kegiatan santri sehari-hari</h2>
    <div class="program-list">
      <div class="program-item" data-aos="fade-up">
        <div class="p-icon">01</div>
        <div class="p-text"><div class="p-title">Tahfidz &amp; tahsin</div><div class="p-sub">Setoran hafalan harian dengan pembimbing tetap</div></div>
      </div>
      <div class="program-item" data-aos="fade-up">
        <div class="p-icon">02</div>
        <div class="p-text"><div class="p-title">Kajian &amp; majelis</div><div class="p-sub">Ratib, sholawat, dan kajian tafsir rutin</div></div>
      </div>
      <div class="program-item" data-aos="fade-up">
        <div class="p-icon">03</div>
        <div class="p-text"><div class="p-title">Ekstrakurikuler</div><div class="p-sub">Futsal, panahan, pencak silat, renang</div></div>
      </div>
      <div class="program-item" data-aos="fade-up">
        <div class="p-icon">04</div>
        <div class="p-text"><div class="p-title">Kehidupan asrama</div><div class="p-sub">Pembinaan disiplin dan kemandirian santri</div></div>
      </div>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="eyebrow">Update</div>
    <h2>Berita &amp; kegiatan</h2>
    <div class="berita-grid">
      <?php if (empty($berita_terbaru)): ?>
        <p class="desc">Belum ada berita. Tambahkan lewat panel admin.</p>
      <?php else: foreach ($berita_terbaru as $b): ?>
        <a href="<?= BASE_URL ?>/pages/berita-detail.php?slug=<?= e($b['slug']) ?>" class="berita-card" data-aos="fade-up">
          <div class="berita-thumb" style="<?= $b['gambar'] ? "background-image:url('" . BASE_URL . "/assets/img/berita/{$b['gambar']}'); background-size:cover;" : '' ?>"></div>
          <div class="berita-body">
            <div class="berita-date"><?= tanggal_indo($b['tanggal']) ?></div>
            <div class="berita-title"><?= e($b['judul']) ?></div>
          </div>
        </a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<section class="cta-band" data-aos="zoom-in">
  <h3>Pendaftaran santri baru dibuka</h3>
  <p>Isi formulir online, tim kami akan menghubungi Anda</p>
  <a href="<?= BASE_URL ?>/pages/psb.php"><button class="btn-white">Daftar sekarang</button></a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
