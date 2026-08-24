# Website Pondok Pesantren Amaliah

Struktur awal website (PHP native + MySQL) sesuai perancangan yang udah kita diskusikan.

## Cara jalanin di lokal (Laragon/XAMPP)

1. Taruh folder `pesantren-amaliah` ini di `htdocs` (XAMPP) atau `www` (Laragon).
2. Buka phpMyAdmin, import `database/schema.sql` buat bikin database + tabel + data contoh.
3. Buka `http://localhost/pesantren-amaliah/generate_password.php` di browser, copy hash yang muncul.
4. Di phpMyAdmin, buka tabel `admin`, edit baris `admin` -> kolom `password`, paste hash tadi.
5. **Hapus `generate_password.php`** setelah itu (jangan sampai kebawa ke hosting).
6. Cek `includes/config.php` -> pastikan `$db_user`, `$db_pass` sesuai setup MySQL lokal kamu (default XAMPP/Laragon biasanya user `root`, password kosong).
7. Akses:
   - Website: `http://localhost/pesantren-amaliah/`
   - Panel admin: `http://localhost/pesantren-amaliah/admin/` (login: `admin` / `admin123` atau sesuai password yang kamu set)

## Struktur folder

```
pesantren-amaliah/
├── admin/              -> panel admin (login, kelola berita, verifikasi PSB)
│   └── includes/       -> header/footer/auth khusus admin
├── assets/
│   ├── css/style.css   -> semua styling situs (1 file, pakai CSS variables)
│   ├── img/            -> logo + folder upload (berita, fasilitas, galeri)
│   └── js/
├── includes/
│   ├── config.php      -> koneksi database + info kontak situs
│   ├── functions.php   -> fungsi bantu (format tanggal, rupiah, dll)
│   ├── header.php      -> navbar, dipakai di semua halaman publik
│   └── footer.php      -> footer, dipakai di semua halaman publik
├── pages/               -> semua halaman publik selain beranda
├── database/schema.sql  -> struktur tabel + data contoh
└── index.php             -> halaman beranda
```

## Yang masih perlu dikerjakan

- CRUD admin buat **fasilitas**, **pengajar**, dan **galeri** belum dibuat -> tinggal contek pola di `admin/berita.php` (form tambah + tabel + tombol hapus), disesuaikan nama tabel dan kolomnya.
- Upload foto asli buat fasilitas/berita/galeri (sekarang masih placeholder gradasi warna) -> taruh file di folder `assets/img/berita`, `assets/img/fasilitas`, atau `assets/img/galeri`, terus isi nama filenya di database lewat phpMyAdmin (atau bikinin form upload-nya nanti).
- Ganti ID video YouTube di `pages/profil-yayasan.php` dengan video profil yang udah ada.
- Isi data pengasuh dan pengajar asli di tabel `pengajar` (masih data contoh).
- Kalau udah siap ke hosting: upload semua file lewat File Manager/FTP, import `schema.sql` lewat phpMyAdmin hosting, terus update `includes/config.php` sesuai kredensial database hosting.

## Warna & font (biar konsisten kalau nambah halaman baru)

- Teal `#006b7d`, teal deep `#013843`, orange `#ee7a00`, gold `#B8901F`
- Font: Fraunces (judul), Plus Jakarta Sans (body), IBM Plex Mono (label kecil/tanggal)
- Semua token warna ada di `assets/css/style.css` bagian `:root`
