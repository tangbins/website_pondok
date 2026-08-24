<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Pengajar';

// Hapus pengajar
if (isset($_GET['hapus'])) {
	$stmt = $pdo->prepare("DELETE FROM pengajar WHERE id = :id");
	$stmt->execute([':id' => $_GET['hapus']]);
	header('Location: ' . BASE_URL . '/admin/pengajar.php');
	exit;
}

// Ambil data buat mode edit
$edit_data = null;
if (isset($_GET['edit'])) {
	$stmt = $pdo->prepare("SELECT * FROM pengajar WHERE id = :id");
	$stmt->execute([':id' => $_GET['edit']]);
	$edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Simpan (tambah baru ATAU update kalau ada id)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'] ?? null;
	$nama = trim($_POST['nama']);
	$jabatan = trim($_POST['jabatan']);
	$jenjang = $_POST['jenjang'];
	$bidang = trim($_POST['bidang']);
	$urutan = (int) ($_POST['urutan'] ?? 0);

	$nama_foto = upload_gambar($_FILES['foto'] ?? null, 'pengajar');
	if ($nama_foto === false) {
		$error = 'Upload foto gagal. Pastikan format jpg/jpeg/png/webp dan ukuran di bawah 2MB.';
	} else {
		if ($id) {
			if ($nama_foto !== null) {
				$stmt = $pdo->prepare("UPDATE pengajar SET nama=:nama, jabatan=:jabatan, jenjang=:jenjang, bidang=:bidang, foto=:foto, urutan=:urutan WHERE id=:id");
				$stmt->execute([':nama' => $nama, ':jabatan' => $jabatan, ':jenjang' => $jenjang, ':bidang' => $bidang, ':foto' => $nama_foto, ':urutan' => $urutan, ':id' => $id]);
			} else {
				$stmt = $pdo->prepare("UPDATE pengajar SET nama=:nama, jabatan=:jabatan, jenjang=:jenjang, bidang=:bidang, urutan=:urutan WHERE id=:id");
				$stmt->execute([':nama' => $nama, ':jabatan' => $jabatan, ':jenjang' => $jenjang, ':bidang' => $bidang, ':urutan' => $urutan, ':id' => $id]);
			}
		} else {
			$stmt = $pdo->prepare("INSERT INTO pengajar (nama, jabatan, jenjang, bidang, foto, urutan) VALUES (:nama, :jabatan, :jenjang, :bidang, :foto, :urutan)");
			$stmt->execute([':nama' => $nama, ':jabatan' => $jabatan, ':jenjang' => $jenjang, ':bidang' => $bidang, ':foto' => $nama_foto, ':urutan' => $urutan]);
		}
		header('Location: ' . BASE_URL . '/admin/pengajar.php');
		exit;
	}
}

$semua_pengajar = $pdo->query("SELECT * FROM pengajar ORDER BY FIELD(jenjang,'pimpinan','struktural','smp','sma'), urutan ASC")->fetchAll(PDO::FETCH_ASSOC);
$label_jenjang = ['pimpinan' => 'Pimpinan', 'struktural' => 'Struktural', 'smp' => 'Pengajar SMP', 'sma' => 'Pengajar SMA'];

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Kelola pengajar</h2>

<div class="admin-card">
	<h3 style="margin-bottom:12px; font-size:14px;">
		<?= $edit_data ? 'Edit pengajar' : 'Tambah pengajar baru' ?>
		<?php if ($edit_data): ?> <a href="<?= BASE_URL ?>/admin/pengajar.php"
				style="font-size:12px; font-weight:400;">(batal edit)</a><?php endif; ?>
	</h3>
	<?php if (!empty($error)): ?>
		<div class="badge badge-ditolak" style="display:block; padding:10px; margin-bottom:12px;"><?= e($error) ?></div>
	<?php endif; ?>
	<form method="POST" enctype="multipart/form-data">
		<?php if ($edit_data): ?><input type="hidden" name="id" value="<?= $edit_data['id'] ?>"><?php endif; ?>

		<label for="nama">Nama lengkap</label>
		<input type="text" id="nama" name="nama" required value="<?= e($edit_data['nama'] ?? '') ?>">

		<label for="jabatan">Jabatan</label>
		<input type="text" id="jabatan" name="jabatan" placeholder="contoh: Kepala Sekolah, Ustadz Tahfidz"
			value="<?= e($edit_data['jabatan'] ?? '') ?>">

		<label for="jenjang">Jenjang</label>
		<select id="jenjang" name="jenjang">
			<option value="pimpinan" <?= ($edit_data['jenjang'] ?? '') == 'pimpinan' ? 'selected' : '' ?>>Pimpinan</option>
			<option value="struktural" <?= ($edit_data['jenjang'] ?? '') == 'struktural' ? 'selected' : '' ?>>Struktural
			</option>
			<option value="smp" <?= ($edit_data['jenjang'] ?? '') == 'smp' ? 'selected' : '' ?>>Pengajar SMP</option>
			<option value="sma" <?= ($edit_data['jenjang'] ?? '') == 'sma' ? 'selected' : '' ?>>Pengajar SMA</option>
		</select>

		<label for="bidang">Bidang (opsional)</label>
		<input type="text" id="bidang" name="bidang" placeholder="contoh: Tahfidz, Matematika"
			value="<?= e($edit_data['bidang'] ?? '') ?>">

		<label for="urutan">Urutan tampil (angka kecil tampil duluan)</label>
		<input type="number" id="urutan" name="urutan" value="<?= e($edit_data['urutan'] ?? '0') ?>">

		<?php if ($edit_data && $edit_data['foto']): ?>
			<label>Foto saat ini</label>
			<img src="<?= BASE_URL ?>/assets/img/pengajar/<?= e($edit_data['foto']) ?>" class="thumb-kecil"
				style="margin-bottom:10px;">
		<?php endif; ?>
		<label for="foto">Foto (jpg/png/webp, maks
			2MB<?= $edit_data ? ', kosongkan kalau ga mau ganti' : ', opsional' ?>)</label>
		<input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp">

		<button type="submit" class="btn"><?= $edit_data ? 'Update pengajar' : 'Simpan pengajar' ?></button>
	</form>
</div>

<div class="admin-card">
	<h3 style="margin-bottom:12px; font-size:14px;">Daftar pengajar</h3>
	<table>
		<tr>
			<th>Foto</th>
			<th>Nama</th>
			<th>Jabatan</th>
			<th>Jenjang</th>
			<th>Aksi</th>
		</tr>
		<?php foreach ($semua_pengajar as $p): ?>
			<tr>
				<td>
					<?php if ($p['foto']): ?>
						<img src="<?= BASE_URL ?>/assets/img/pengajar/<?= e($p['foto']) ?>" class="thumb-kecil" alt="">
					<?php else: ?>
						<div class="thumb-kecil"></div>
					<?php endif; ?>
				</td>
				<td><?= e($p['nama']) ?></td>
				<td><?= e($p['jabatan']) ?></td>
				<td><?= e($label_jenjang[$p['jenjang']] ?? $p['jenjang']) ?></td>
				<td>
					<a href="<?= BASE_URL ?>/admin/pengajar.php?edit=<?= $p['id'] ?>" class="btn">Edit</a>
					<a href="<?= BASE_URL ?>/admin/pengajar.php?hapus=<?= $p['id'] ?>" class="btn btn-danger"
						onclick="return confirm('Hapus data pengajar ini?')">Hapus</a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (empty($semua_pengajar)): ?>
			<tr>
				<td colspan="5" style="text-align:center; color:#9a9a9a;">Belum ada data pengajar</td>
			</tr>
		<?php endif; ?>
	</table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>