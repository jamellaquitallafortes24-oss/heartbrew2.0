<?php
session_start();
include "includes/db.php";

if(isset($_GET['action']) && $_GET['action'] === 'clear'){
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){
    foreach($_POST['qty'] as $i => $q){
        if(isset($_SESSION['cart'][$i])){
            $_SESSION['cart'][$i]['qty'] = max(1, (int)$q);
        }
    }
    header('Location: cart.php');
    exit;
}
$total = 0;
if(!empty($_SESSION['cart'])){
    foreach($_SESSION['cart'] as $item) $total += $item['price'] * $item['qty'];
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Cart - Heart Brew</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <header class="site-header"><div class="container"><h1 class="brand">Heart Brew</h1></div></header>
  <main class="container">
    <h2>Your Cart</h2>
    <?php if(empty($_SESSION['cart'])): ?>
      <p>Your cart is empty. <a href="menu.php">Browse menu</a></p>
    <?php else: ?>
      <form method="POST">
        <table class="cart-table">
          <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
          <tbody>
            <?php foreach($_SESSION['cart'] as $i => $it): ?>
            <tr>
              <td><?php echo htmlspecialchars($it['name']); ?></td>
              <td>₱<?php echo number_format($it['price'],2); ?></td>
              <td><input name="qty[<?php echo $i; ?>]" type="number" value="<?php echo $it['qty']; ?>" min="1"></td>
              <td>₱<?php echo number_format($it['price'] * $it['qty'],2); ?></td>


            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p class="total">Total: ₱<?php echo number_format($total,2); ?></p>
        <div class="ca<div style="margin-top:20px; display:flex; gap:10px;">
    
    <!-- Add More Button -->
    <a href="menu.php">
        <button type="button" style="
            padding:12px 20px;
            background:#333;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            ← Add More Products
        </button>
    </a>

    <!-- Checkout Button -->
    <a href="checkout.php">
        <button type="button" style="
            padding:12px 20px;
            background:#28a745;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
        ">
            Proceed to Checkout →
        </button>
    </a>

      </form>
    <?php endif; ?>
  </main>
</body>
</html>
