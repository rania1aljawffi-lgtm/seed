<?php
// header.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>مشروع بذور</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <h1 class="brand">شركة بذور البطاطس</h1>
    <nav>
      <a href="products.php">المنتجات</a>
      <a href="cart.php">السلة (<?php echo isset($_SESSION['cart'])? array_sum($_SESSION['cart']) : 0; ?>)</a>
      <?php if(!empty($_SESSION['user'])): ?>
        <a href="logout.php">تسجيل خروج</a>
        <span class="welcome">مرحبا، <?php echo htmlspecialchars($_SESSION['user']['fullname']); ?></span>
      <?php else: ?>
        <a href="login.php">تسجيل دخول</a>
        <a href="register.php">إنشاء حساب</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">