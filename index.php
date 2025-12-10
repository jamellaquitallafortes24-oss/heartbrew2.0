<?php
session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Heart Brew</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="container">
      <h1 class="brand">Heart Brew</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="cart.php">Cart<?php if(!empty($_SESSION['cart'])) echo ' (' . array_sum(array_column($_SESSION['cart'],'qty')) . ')'; ?></a>
        <?php if(isset($_SESSION['user'])): ?>
  <a href="order_history.php">Orders</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Login</a>
          <a href="register.php">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="hero">
    <div class="container">
<a href="index.php" class="logo">
    <img src="assets/images/logo.png" alt="Heart Brew" style="height:250px;">
</a>

      <h2>Freshly Brewed Happiness</h2>
      <p class="lead">Simple, fast, and delightful — order your favorite coffee and pastries.</p>
      <a class="btn" href="menu.php" >View Menu</a>
    </div>
  </main>

  <section class="features container">
    <div class="card">
      <h3>Quality beans</h3>
      <p>We roast with care for rich flavor.</p>
    </div>
    <div class="card">
      <h3>Fast pickup</h3>
      <p>Order online and pick up in-store.</p>
    </div>
    <div class="card">
      <h3>Friendly staff</h3>
      <p>We're here to make your day better.</p>
    </div>
  </section>

  <footer class="site-footer">
    <div class="container">
      <p>© Heart Brew</p>
    </div>
  </footer>
</body>
</html>
