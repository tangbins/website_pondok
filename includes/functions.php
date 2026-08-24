<?php
// Kumpulan fungsi bantu yang dipakai berulang di banyak halaman

// Biar aman dari XSS pas nampilin data dari database
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Format angka jadi Rupiah, contoh: 750000 -> Rp750.000
function rupiah($angka) {
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

// Format tanggal Indonesia, contoh: 2026-07-12 -> 12 Juli 2026
function tanggal_indo($tanggal) {
    $bulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
        7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];
    $ts = strtotime($tanggal);
    return date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

// Bikin slug dari judul, dipakai pas admin nambah berita baru
function buat_slug($judul) {
    $slug = strtolower(trim($judul));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

// Upload gambar ke assets/img/{folder}, dipakai di admin fasilitas/pengajar/galeri
// Return: nama file kalau berhasil, null kalau ga ada file dipilih, false kalau gagal/format salah
function upload_gambar($file, $folder) {
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensi_diizinkan)) {
        return false;
    }

    $nama_file = uniqid() . '.' . $ekstensi;
    $tujuan = __DIR__ . '/../assets/img/' . $folder . '/' . $nama_file;

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        return $nama_file;
    }
    return false;
}

// Ambil ID video dari link YouTube (buat nampilin thumbnail-nya di galeri)
function youtube_id($url) {
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $match);
    return $match[1] ?? null;
}