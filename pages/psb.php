<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Penerimaan Santri Baru';
$active = 'psb';

$gelombang = $pdo->query("SELECT * FROM ppdb_gelombang ORDER BY tanggal_mulai ASC")->fetchAll(PDO::FETCH_ASSOC);
$biaya_smp = $pdo->query("SELECT * FROM ppdb_biaya WHERE jenjang='smp' ORDER BY urutan ASC")->fetchAll(PDO::FETCH_ASSOC);
$biaya_sma = $pdo->query("SELECT * FROM ppdb_biaya WHERE jenjang='sma' ORDER BY urutan ASC")->fetchAll(PDO::FETCH_ASSOC);

// pesan sukses/error dikirim dari psb-proses.php lewat query string
$pesan = $_GET['status'] ?? '';

include __DIR__ . '/../includes/header.php';
?>

<section class="hero" data-aos="fade-in" style="padding-bottom:40px;">
  <div class="hero-inner">
    <div class="hero-eyebrow">PSB <?= date('Y') ?>/<?= date('Y')+1 ?></div>
    <h1>Penerimaan santri baru</h1>
    <p>Bergabung menjadi bagian dari keluarga besar Pondok Pesantren Amaliah. Ikuti alur pendaftaran di bawah ini.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="eyebrow">Jadwal</div>
    <h2>Gelombang pendaftaran</h2>
    <table class="tabel-biaya">
      <tr><th>Gelombang</th><th>Periode</th><th>Biaya Pendaftaran</th></tr>
      <?php foreach ($gelombang as $g): ?>
      <tr>
        <td><?= e($g['nama_gelombang']) ?></td>
        <td><?= tanggal_indo($g['tanggal_mulai']) ?> - <?= tanggal_indo($g['tanggal_selesai']) ?></td>
        <td class="jumlah"><?= rupiah($g['biaya_pendaftaran']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

    <div class="eyebrow">Syarat</div>
    <h2>Syarat pendaftaran</h2>
    <p class="desc">
      Fotokopi Kartu Keluarga &middot; Fotokopi Akta Kelahiran &middot; Fotokopi Ijazah/Rapor terakhir &middot;
      Pas foto 3x4 (3 lembar) &middot; Surat keterangan sehat dari dokter &middot; Mengisi formulir pendaftaran online di bawah
    </p>

    <div class="eyebrow">Alur</div>
    <h2>Proses pendaftaran</h2>
    <div class="alur-list">
      <div class="alur-item" data-aos="fade-up"><div><div class="alur-num">01</div><div>Isi formulir online</div></div></div>
      <div class="alur-item" data-aos="fade-up"><div><div class="alur-num">02</div><div>Bayar biaya pendaftaran</div></div></div>
      <div class="alur-item" data-aos="fade-up"><div><div class="alur-num">03</div><div>Tes &amp; wawancara</div></div></div>
      <div class="alur-item" data-aos="fade-up"><div><div class="alur-num">04</div><div>Pengumuman kelulusan</div></div></div>
      <div class="alur-item" data-aos="fade-up"><div><div class="alur-num">05</div><div>Daftar ulang</div></div></div>
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="container">
    <div class="eyebrow">Rincian biaya</div>
    <h2>Biaya jenjang SMP</h2>
    <table class="tabel-biaya">
      <tr><th>Komponen</th><th>Keterangan</th><th>Jumlah</th></tr>
      <?php foreach ($biaya_smp as $b): ?>
      <tr><td><?= e($b['komponen']) ?></td><td><?= e($b['keterangan']) ?></td><td class="jumlah"><?= rupiah($b['jumlah']) ?></td></tr>
      <?php endforeach; ?>
    </table>

    <h2>Biaya jenjang SMA</h2>
    <table class="tabel-biaya">
      <tr><th>Komponen</th><th>Keterangan</th><th>Jumlah</th></tr>
      <?php foreach ($biaya_sma as $b): ?>
      <tr><td><?= e($b['komponen']) ?></td><td><?= e($b['keterangan']) ?></td><td class="jumlah"><?= rupiah($b['jumlah']) ?></td></tr>
      <?php endforeach; ?>
    </table>
    <p style="font-size:12.5px; color:#6a6a6a;">*Biaya dapat berubah sewaktu-waktu. Hubungi admin untuk info terbaru.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="eyebrow">Formulir</div>
    <h2>Daftar sekarang</h2>

    <?php if ($pesan === 'sukses'): ?>
      <div class="alert alert-success">Pendaftaran berhasil dikirim. Tim kami akan menghubungi Anda lewat WhatsApp/telepon.</div>
    <?php elseif ($pesan === 'gagal'): ?>
      <div class="alert alert-error">Ada data yang belum lengkap, mohon dicek kembali.</div>
    <?php endif; ?>

    <form class="form-box" data-aos="fade-up" action="<?= BASE_URL ?>/pages/psb-proses.php" method="POST">
      <div class="form-group">
        <label for="nama_lengkap">Nama lengkap calon santri</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>
      </div>
      <div class="form-group">
        <label for="nik">NIK</label>
        <input type="text" id="nik" name="nik" maxlength="16">
      </div>
      <div class="form-group">
        <label for="jenjang_pilihan">Jenjang yang dipilih</label>
        <select id="jenjang_pilihan" name="jenjang_pilihan" required>
          <option value="">Pilih jenjang</option>
          <option value="smp">SMP - Bina Tauhid Amaliyah</option>
          <option value="sma">SMA - ITBS Amaliah</option>
        </select>
      </div>
      <div class="form-group">
        <label for="asal_sekolah">Asal sekolah</label>
        <input type="text" id="asal_sekolah" name="asal_sekolah">
      </div>
      <div class="form-group">
        <label for="nama_ortu">Nama orang tua/wali</label>
        <input type="text" id="nama_ortu" name="nama_ortu" required>
      </div>
      <div class="form-group">
        <label for="no_hp">No. HP/WhatsApp orang tua</label>
        <input type="text" id="no_hp" name="no_hp" required>
      </div>
      <div class="form-group">
        <label for="email">Email (opsional)</label>
        <input type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="alamat">Alamat lengkap</label>
        <textarea id="alamat" name="alamat" rows="3"></textarea>
      </div>
      <button type="submit" class="btn-primary" style="width:100%;">Kirim pendaftaran</button>
    </form>
  </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
