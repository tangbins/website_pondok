<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Fasilitas';

// Hapus fasilitas
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM fasilitas WHERE id = :id");
    $stmt->execute([':id' => $_GET['hapus']]);
    header('Location: ' . BASE_URL . '/admin/fasilitas.php');
    exit;
}

// Ambil data buat mode edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM fasilitas WHERE id = :id");
    $stmt->execute([':id' => $_GET['edit']]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Simpan (tambah baru ATAU update kalau ada id)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = trim($_POST['nama']);
    $kategori = $_POST['kategori'];
    $deskripsi = trim($_POST['deskripsi']);
    $urutan = (int)($_POST['urutan'] ?? 0);

    // Upload gambar baru itu opsional pas edit - kalau ga diisi, gambar lama dipertahankan
    $nama_gambar = upload_gambar($_FILES['gambar'] ?? null, 'fasilitas');
    if ($nama_gambar === false) {
        $error = 'Upload gambar gagal. Pastikan format jpg/jpeg/png/webp dan ukuran di bawah 2MB.';
    } else {
        if ($id) {
            if ($nama_gambar !== null) {
                $stmt = $pdo->prepare("UPDATE fasilitas SET nama=:nama, kategori=:kategori, deskripsi=:deskripsi, gambar=:gambar, urutan=:urutan WHERE id=:id");
                $stmt->execute([':nama'=>$nama, ':kategori'=>$kategori, ':deskripsi'=>$deskripsi, ':gambar'=>$nama_gambar, ':urutan'=>$urutan, ':id'=>$id]);
            } else {
                $stmt = $pdo->prepare("UPDATE fasilitas SET nama=:nama, kategori=:kategori, deskripsi=:deskripsi, urutan=:urutan WHERE id=:id");
                $stmt->execute([':nama'=>$nama, ':kategori'=>$kategori, ':deskripsi'=>$deskripsi, ':urutan'=>$urutan, ':id'=>$id]);
            }
        } else {
            $stmt = $pdo->prepare("INSERT INTO fasilitas (nama, kategori, deskripsi, gambar, urutan) VALUES (:nama, :kategori, :deskripsi, :gambar, :urutan)");
            $stmt->execute([':nama'=>$nama, ':kategori'=>$kategori, ':deskripsi'=>$deskripsi, ':gambar'=>$nama_gambar, ':urutan'=>$urutan]);
        }
        header('Location: ' . BASE_URL . '/admin/fasilitas.php');
        exit;
    }
}

$semua_fasilitas = $pdo->query("SELECT * FROM fasilitas ORDER BY kategori, urutan ASC")->fetchAll(PDO::FETCH_ASSOC);
$label_kategori = ['belajar' => 'Belajar', 'ibadah' => 'Ibadah', 'penunjang' => 'Penunjang'];

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Kelola fasilitas</h2>

<div class="admin-card">
  <h3 style="margin-bottom:12px; font-size:14px;">
    <?= $edit_data ? 'Edit fasilitas' : 'Tambah fasilitas baru' ?>
    <?php if ($edit_data): ?> <a href="<?= BASE_URL ?>/admin/fasilitas.php" style="font-size:12px; font-weight:400;">(batal edit)</a><?php endif; ?>
  </h3>
  <?php if (!empty($error)): ?><div class="badge badge-ditolak" style="display:block; padding:10px; margin-bottom:12px;"><?= e($error) ?></div><?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <?php if ($edit_data): ?><input type="hidden" name="id" value="<?= $edit_data['id'] ?>"><?php endif; ?>

    <label for="nama">Nama fasilitas</label>
    <input type="text" id="nama" name="nama" required value="<?= e($edit_data['nama'] ?? '') ?>">

    <label for="kategori">Kategori</label>
    <select id="kategori" name="kategori">
      <option value="belajar" <?= ($edit_data['kategori'] ?? '')=='belajar'?'selected':'' ?>>Fasilitas Belajar</option>
      <option value="ibadah" <?= ($edit_data['kategori'] ?? '')=='ibadah'?'selected':'' ?>>Fasilitas Ibadah</option>
      <option value="penunjang" <?= ($edit_data['kategori'] ?? '')=='penunjang'?'selected':'' ?>>Fasilitas Penunjang</option>
    </select>

    <label for="deskripsi">Deskripsi singkat</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"><?= e($edit_data['deskripsi'] ?? '') ?></textarea>

    <label for="urutan">Urutan tampil (angka kecil tampil duluan)</label>
    <input type="number" id="urutan" name="urutan" value="<?= e($edit_data['urutan'] ?? '0') ?>">

    <?php if ($edit_data && $edit_data['gambar']): ?>
      <label>Foto saat ini</label>
      <img src="<?= BASE_URL ?>/assets/img/fasilitas/<?= e($edit_data['gambar']) ?>" class="thumb-kecil" style="margin-bottom:10px;">
    <?php endif; ?>
    <label for="gambar">Foto fasilitas (jpg/png/webp, maks 2MB<?= $edit_data ? ', kosongkan kalau ga mau ganti' : ', opsional' ?>)</label>
    <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp">

    <button type="submit" class="btn"><?= $edit_data ? 'Update fasilitas' : 'Simpan fasilitas' ?></button>
  </form>
</div>

<div class="admin-card">
  <h3 style="margin-bottom:12px; font-size:14px;">Daftar fasilitas</h3>
  <table>
    <tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Urutan</th><th>Aksi</th></tr>
    <?php foreach ($semua_fasilitas as $f): ?>
    <tr>
      <td>
        <?php if ($f['gambar']): ?>
          <img src="<?= BASE_URL ?>/assets/img/fasilitas/<?= e($f['gambar']) ?>" class="thumb-kecil" alt="">
        <?php else: ?>
          <div class="thumb-kecil"></div>
        <?php endif; ?>
      </td>
      <td><?= e($f['nama']) ?></td>
      <td><?= e($label_kategori[$f['kategori']] ?? $f['kategori']) ?></td>
      <td><?= (int)$f['urutan'] ?></td>
      <td>
        <a href="<?= BASE_URL ?>/admin/fasilitas.php?edit=<?= $f['id'] ?>" class="btn">Edit</a>
        <a href="<?= BASE_URL ?>/admin/fasilitas.php?hapus=<?= $f['id'] ?>" class="btn btn-danger" onclick="return confirm('Hapus fasilitas ini?')">Hapus</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($semua_fasilitas)): ?>
      <tr><td colspan="5" style="text-align:center; color:#9a9a9a;">Belum ada data fasilitas</td></tr>
    <?php endif; ?>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>