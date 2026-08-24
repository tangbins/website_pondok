<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
  $stmt->execute([':username' => $username]);
  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($admin && password_verify($password, $admin['password'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_nama'] = $admin['nama_lengkap'];
    header('Location: ' . BASE_URL . '/admin/dashboard.php');
    exit;
  } else {
    $error = 'Username atau password salah.';
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Pondok Pesantren Amaliah</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
    rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    body {
      background: #006b7d;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background: #fff;
      border-radius: 12px;
      padding: 32px;
      width: 100%;
      max-width: 340px;
    }

    h1 {
      font-size: 18px;
      color: #013843;
      margin-bottom: 4px;
    }

    p {
      font-size: 13px;
      color: #6a6a6a;
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 12.5px;
      font-weight: 600;
      margin-bottom: 5px;
      color: #013843;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #d6d6d6;
      border-radius: 6px;
      margin-bottom: 14px;
      font-size: 13.5px;
    }

    button {
      width: 100%;
      background: #ee7a00;
      color: #fff;
      border: none;
      padding: 11px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 13.5px;
      cursor: pointer;
    }

    .error {
      background: #fbe7e7;
      color: #a13636;
      padding: 10px 12px;
      border-radius: 6px;
      font-size: 13px;
      margin-bottom: 14px;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <h1>Panel admin</h1>
    <p>Pondok Pesantren Amaliah</p>
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required autofocus>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Masuk</button>
    </form>
  </div>
</body>

</html>