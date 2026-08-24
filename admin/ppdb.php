<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'PSB Masuk';

// Update status pendaftar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE ppdb_pendaftar SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $_POST['status'], ':id' => $_POST['id']]);
    header('Location: ' . BASE_URL . '/admin/ppdb.php');
    exit;
}

$pendaftar = $pdo->query("SELECT * FROM ppdb_pendaftar ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Data pendaftar PSB</h2>

<div class="admin-card">
  <table>
    <tr><th>Nama</th><th>Jenjang</th><th>Orang tua</th><th>No. HP</th><th>Status</th><th>Aksi</th></tr>
    <?php foreach ($pendaftar as $p): ?>
    <tr>
      <td><?= e($p['nama_lengkap']) ?></td>
      <td><?= strtoupper(e($p['jenjang_pilihan'])) ?></td>
      <td><?= e($p['nama_ortu']) ?></td>
      <td><?= e($p['no_hp']) ?></td>
      <td><span class="badge badge-<?= e($p['status']) ?>"><?= e($p['status']) ?></span></td>
      <td>
        <form method="POST" style="display:flex; gap:6px; margin:0;">
          <input type="hidden" name="id" value="<?= $p['id'] ?>">
          <select name="status" style="margin:0; width:auto;" onchange="this.form.submit()">
            <option value="menunggu" <?= $p['status']=='menunggu'?'selected':'' ?>>Menunggu</option>
            <option value="diverifikasi" <?= $p['status']=='diverifikasi'?'selected':'' ?>>Diverifikasi</option>
            <option value="diterima" <?= $p['status']=='diterima'?'selected':'' ?>>Diterima</option>
            <option value="ditolak" <?= $p['status']=='ditolak'?'selected':'' ?>>Ditolak</option>
          </select>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($pendaftar)): ?>
      <tr><td colspan="6" style="text-align:center; color:#9a9a9a;">Belum ada pendaftar</td></tr>
    <?php endif; ?>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
