<?php
// =============================================
// header.php — Komponen Header & Navbar
// Include di setiap halaman setelah config.php
// =============================================
$pageTitle = $pageTitle ?? 'Aku & Kamu';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?> — Aku & Kamu</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=DM+Serif+Display&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if (isLoggedIn()): ?>
<nav class="navbar">
  <div class="nav-brand">
    <span class="dot"></span>
    <a href="forum.php" style="color:inherit;text-decoration:none">Aku &amp; Kamu</a>
  </div>
  <div class="nav-right">
    <span class="badge-user">
      👤 <?= e($_SESSION['user']['nama']) ?>
      <small>(<?= e($_SESSION['user']['kategori']) ?>)</small>
    </span>
    <a href="logout.php" class="btn-logout">Keluar</a>
  </div>
</nav>
<?php endif; ?>
