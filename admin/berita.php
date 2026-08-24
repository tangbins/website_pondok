<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Berita';

// Hapus berita
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM berita WHERE id = :id");
    $stmt->execute([':id' => $_GET['hapus']]);
    header('Location: ' . BASE_URL . '/admin/berita.php');
    exit;
}

// Ambil data buat mode edit (kalau ada ?edit=ID di URL)
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = :id");
    $stmt->execute([':id' => $_GET['edit']]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Simpan (tambah baru ATAU update kalau ada id)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $judul = trim($_POST['judul']);
    $ringkasan = trim($_POST['ringkasan']);
    $isi = trim($_POST['isi']);
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    if ($id) {
        // mode update - slug ga diubah biar link lama ga rusak
        $stmt = $pdo->prepare(
            "UPDATE berita SET judul=:judul, ringkasan=:ringkasan, isi=:isi, tanggal=:tanggal, status=:status WHERE id=:id"
        );
        $stmt->execute([
            ':judul' => $judul, ':ringkasan' => $ringkasan, ':isi' => $isi,
            ':tanggal' => $tanggal, ':status' => $status, ':id' => $id,
        ]);
    } else {
        // mode tambah baru
        $slug = buat_slug($judul) . '-' . time();
        $stmt = $pdo->prepare(
            "INSERT INTO berita (judul, slug, ringkasan, isi, tanggal, status) VALUES (:judul, :slug, :ringkasan, :isi, :tanggal, :status)"
        );
        $stmt->execute([
            ':judul' => $judul, ':slug' => $slug, ':ringkasan' => $ringkasan,
            ':isi' => $isi, ':tanggal' => $tanggal, ':status' => $status,
        ]);
    }
    header('Location: ' . BASE_URL . '/admin/berita.php');
    exit;
}

$semua_berita = $pdo->query("SELECT * FROM berita ORDER BY tanggal DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Kelola berita</h2>

<div class="admin-card">
  <h3 style="margin-bottom:12px; font-size:14px;">
    <?= $edit_data ? 'Edit berita' : 'Tambah berita baru' ?>
    <?php if ($edit_data): ?> <a href="<?= BASE_URL ?>/admin/berita.php" style="font-size:12px; font-weight:400;">(batal edit)</a><?php endif; ?>
  </h3>
  <form method="POST">
    <?php if ($edit_data): ?><input type="hidden" name="id" value="<?= $edit_data['id'] ?>"><?php endif; ?>

    <label for="judul">Judul</label>
    <input type="text" id="judul" name="judul" required value="<?= e($edit_data['judul'] ?? '') ?>">

    <label for="ringkasan">Ringkasan singkat</label>
    <input type="text" id="ringkasan" name="ringkasan" value="<?= e($edit_data['ringkasan'] ?? '') ?>">

    <label for="isi">Isi lengkap</label>
    <textarea id="isi" name="isi" rows="5"><?= e($edit_data['isi'] ?? '') ?></textarea>

    <label for="tanggal">Tanggal</label>
    <input type="date" id="tanggal" name="tanggal" required value="<?= e($edit_data['tanggal'] ?? '') ?>">

    <label for="status">Status</label>
    <select id="status" name="status">
      <option value="publish" <?= ($edit_data['status'] ?? '') == 'publish' ? 'selected' : '' ?>>Publish</option>
      <option value="draft" <?= ($edit_data['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
    </select>

    <button type="submit" class="btn"><?= $edit_data ? 'Update berita' : 'Simpan berita' ?></button>
  </form>
</div>

<div class="admin-card">
  <h3 style="margin-bottom:12px; font-size:14px;">Daftar berita</h3>
  <table>
    <tr><th>Judul</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
    <?php foreach ($semua_berita as $b): ?>
    <tr>
      <td><?= e($b['judul']) ?></td>
      <td><?= tanggal_indo($b['tanggal']) ?></td>
      <td><span class="badge badge-<?= $b['status']=='publish'?'diterima':'menunggu' ?>"><?= e($b['status']) ?></span></td>
      <td>
        <a href="<?= BASE_URL ?>/admin/berita.php?edit=<?= $b['id'] ?>" class="btn">Edit</a>
        <a href="<?= BASE_URL ?>/admin/berita.php?hapus=<?= $b['id'] ?>" class="btn btn-danger" onclick="return confirm('Hapus berita ini?')">Hapus</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>