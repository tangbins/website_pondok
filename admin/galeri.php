<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Galeri';

// Hapus item galeri
if (isset($_GET['hapus'])) {
	$stmt = $pdo->prepare("DELETE FROM galeri WHERE id = :id");
	$stmt->execute([':id' => $_GET['hapus']]);
	header('Location: ' . BASE_URL . '/admin/galeri.php');
	exit;
}

// Ambil data buat mode edit
$edit_data = null;
if (isset($_GET['edit'])) {
	$stmt = $pdo->prepare("SELECT * FROM galeri WHERE id = :id");
	$stmt->execute([':id' => $_GET['edit']]);
	$edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Simpan (tambah baru ATAU update kalau ada id)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = $_POST['id'] ?? null;
	$judul = trim($_POST['judul']);
	$jenis = $_POST['jenis'];
	$kategori = trim($_POST['kategori']);
	$link_video = trim($_POST['link_video'] ?? '');

	if ($jenis === 'video') {
		$file_path = $link_video;
		if ($file_path === '') {
			$error = 'Isi link video-nya dulu ya.';
		}
	} else {
		$file_path = upload_gambar($_FILES['file_foto'] ?? null, 'galeri');
		if ($file_path === false) {
			$error = 'Upload foto gagal. Pastikan format jpg/jpeg/png/webp dan ukuran di bawah 2MB.';
		} elseif ($file_path === null && !$id) {
			$error = 'Pilih dulu foto yang mau diupload.';
		} elseif ($file_path === null && $id) {
			// mode edit, ga upload baru -> pertahankan file lama
			$file_path = $edit_data['file_path'] ?? null;
		}
	}

	if (empty($error)) {
		if ($id) {
			$stmt = $pdo->prepare("UPDATE galeri SET judul=:judul, jenis=:jenis, file_path=:file_path, kategori=:kategori WHERE id=:id");
			$stmt->execute([':judul' => $judul, ':jenis' => $jenis, ':file_path' => $file_path, ':kategori' => $kategori, ':id' => $id]);
		} else {
			$stmt = $pdo->prepare("INSERT INTO galeri (judul, jenis, file_path, kategori) VALUES (:judul, :jenis, :file_path, :kategori)");
			$stmt->execute([':judul' => $judul, ':jenis' => $jenis, ':file_path' => $file_path, ':kategori' => $kategori]);
		}
		header('Location: ' . BASE_URL . '/admin/galeri.php');
		exit;
	}
}

$semua_galeri = $pdo->query("SELECT * FROM galeri ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<h2 style="margin-bottom:16px;">Kelola galeri</h2>

<div class="admin-card">
	<h3 style="margin-bottom:12px; font-size:14px;">
		<?= $edit_data ? 'Edit item galeri' : 'Tambah item galeri' ?>
		<?php if ($edit_data): ?> <a href="<?= BASE_URL ?>/admin/galeri.php"
				style="font-size:12px; font-weight:400;">(batal edit)</a><?php endif; ?>
	</h3>
	<?php if (!empty($error)): ?>
		<div class="badge badge-ditolak" style="display:block; padding:10px; margin-bottom:12px;"><?= e($error) ?></div>
	<?php endif; ?>
	<form method="POST" enctype="multipart/form-data">
		<?php if ($edit_data): ?><input type="hidden" name="id" value="<?= $edit_data['id'] ?>"><?php endif; ?>

		<label for="judul">Judul</label>
		<input type="text" id="judul" name="judul" required value="<?= e($edit_data['judul'] ?? '') ?>">

		<label for="jenis">Jenis</label>
		<select id="jenis" name="jenis"
			onchange="document.getElementById('blokFoto').style.display = this.value=='foto' ? 'block' : 'none'; document.getElementById('blokVideo').style.display = this.value=='video' ? 'block' : 'none';">
			<option value="foto" <?= ($edit_data['jenis'] ?? '') == 'foto' ? 'selected' : '' ?>>Foto</option>
			<option value="video" <?= ($edit_data['jenis'] ?? '') == 'video' ? 'selected' : '' ?>>Video</option>
		</select>

		<label for="kategori">Kategori (opsional)</label>
		<input type="text" id="kategori" name="kategori" value="<?= e($edit_data['kategori'] ?? '') ?>">

		<div id="blokFoto" style="<?= ($edit_data['jenis'] ?? 'foto') == 'video' ? 'display:none;' : '' ?>">
			<?php if ($edit_data && $edit_data['jenis'] == 'foto' && $edit_data['file_path']): ?>
				<label>Foto saat ini</label>
				<img src="<?= BASE_URL ?>/assets/img/galeri/<?= e($edit_data['file_path']) ?>" class="thumb-kecil"
					style="margin-bottom:10px;">
			<?php endif; ?>
			<label for="file_foto">Upload foto (jpg/png/webp, maks
				2MB<?= $edit_data ? ', kosongkan kalau ga mau ganti' : '' ?>)</label>
			<input type="file" id="file_foto" name="file_foto" accept=".jpg,.jpeg,.png,.webp">
		</div>

		<div id="blokVideo" style="<?= ($edit_data['jenis'] ?? 'foto') == 'video' ? '' : 'display:none;' ?>">
			<label for="link_video">Link video YouTube</label>
			<input type="text" id="link_video" name="link_video" placeholder="https://www.youtube.com/watch?v=..."
				value="<?= ($edit_data['jenis'] ?? '') == 'video' ? e($edit_data['file_path']) : '' ?>">
		</div>

		<button type="submit" class="btn"><?= $edit_data ? 'Update item' : 'Simpan ke galeri' ?></button>
	</form>
</div>

<div class="admin-card">
	<h3 style="margin-bottom:12px; font-size:14px;">Daftar galeri</h3>
	<table>
		<tr>
			<th>Preview</th>
			<th>Judul</th>
			<th>Jenis</th>
			<th>Kategori</th>
			<th>Aksi</th>
		</tr>
		<?php foreach ($semua_galeri as $g): ?>
			<tr>
				<td>
					<?php if ($g['jenis'] === 'foto' && $g['file_path']): ?>
						<img src="<?= BASE_URL ?>/assets/img/galeri/<?= e($g['file_path']) ?>" class="thumb-kecil" alt="">
					<?php else: ?>
						<span class="badge badge-diverifikasi">Video</span>
					<?php endif; ?>
				</td>
				<td><?= e($g['judul']) ?></td>
				<td><?= ucfirst(e($g['jenis'])) ?></td>
				<td><?= e($g['kategori']) ?></td>
				<td>
					<a href="<?= BASE_URL ?>/admin/galeri.php?edit=<?= $g['id'] ?>" class="btn">Edit</a>
					<a href="<?= BASE_URL ?>/admin/galeri.php?hapus=<?= $g['id'] ?>" class="btn btn-danger"
						onclick="return confirm('Hapus item ini?')">Hapus</a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (empty($semua_galeri)): ?>
			<tr>
				<td colspan="5" style="text-align:center; color:#9a9a9a;">Belum ada item galeri</td>
			</tr>
		<?php endif; ?>
	</table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>