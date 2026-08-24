<?php
// Jalankan file ini SEKALI lewat browser (contoh: localhost/pesantren-amaliah/generate_password.php)
// buat bikin hash password admin yang bener, soalnya hash di schema.sql cuma placeholder.
// Setelah dapet hash-nya, update manual lewat phpMyAdmin ke tabel `admin` kolom `password`.
// HAPUS FILE INI setelah dipakai, jangan sampai kebawa ke hosting production.

$password_baru = 'admin123'; // ganti sesuai password yang kamu mau
echo 'Hash untuk password "' . $password_baru . '":<br><br>';
echo password_hash($password_baru, PASSWORD_DEFAULT);
