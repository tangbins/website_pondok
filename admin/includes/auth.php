<?php
// Panggil file ini di awal setiap halaman admin (kecuali index.php/login)
// buat mastiin cuma admin yang login yang bisa akses

require_once __DIR__ . '/../../includes/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}
