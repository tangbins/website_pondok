<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title ?? 'Admin') ?> - Panel Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <style>
    :root {
      --teal: #006b7d;
      --teal-deep: #013843;
      --orange: #ee7a00;
      --ink: #14262A;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f4f6f6;
      color: var(--ink);
    }

    .admin-nav {
      background: var(--teal-deep);
      color: #fff;
      padding: 14px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .admin-nav a {
      color: #cfe8ec;
      margin-right: 16px;
      font-size: 13.5px;
      text-decoration: none;
    }

    .admin-nav a.logout {
      color: var(--orange);
      font-weight: 600;
    }

    .admin-wrap {
      max-width: 960px;
      margin: 28px auto;
      padding: 0 20px;
    }

    .admin-card {
      background: #fff;
      border: 1px solid #e2e2e2;
      border-radius: 10px;
      padding: 22px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13.5px;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background: #f0f4f4;
      font-weight: 600;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 9px 10px;
      border: 1px solid #d6d6d6;
      border-radius: 6px;
      font-family: inherit;
      font-size: 13.5px;
      margin-bottom: 12px;
    }

    label {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      margin-bottom: 4px;
      color: var(--teal-deep);
    }

    .btn {
      background: var(--teal);
      color: #fff;
      border: none;
      padding: 9px 16px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .btn-danger {
      background: #c0392b;
    }

    .badge {
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
    }

    .badge-menunggu {
      background: #fdf1d6;
      color: #a3760a;
    }

    .badge-diverifikasi {
      background: #dcecfb;
      color: #1a5aa3;
    }

    .badge-diterima {
      background: #e3f4ea;
      color: #1c6b3d;
    }

    .badge-ditolak {
      background: #fbe7e7;
      color: #a13636;
    }

    .thumb-kecil {
      width: 48px;
      height: 48px;
      object-fit: cover;
      border-radius: 6px;
      background: #eee;
    }
  </style>
</head>

<body>
  <div class="admin-nav">
    <div>
      <a href="<?= BASE_URL ?>/admin/dashboard.php">Dashboard</a>
      <a href="<?= BASE_URL ?>/admin/berita.php">Berita</a>
      <a href="<?= BASE_URL ?>/admin/fasilitas.php">Fasilitas</a>
      <a href="<?= BASE_URL ?>/admin/pengajar.php">Pengajar</a>
      <a href="<?= BASE_URL ?>/admin/galeri.php">Galeri</a>
      <a href="<?= BASE_URL ?>/admin/ppdb.php">PSB Masuk</a>
    </div>
    <a href="<?= BASE_URL ?>/admin/logout.php" class="logout">Keluar</a>
  </div>
  <div class="admin-wrap">