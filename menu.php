<?php
session_start();
include "includes/db.php";

$products = [];
$res = $conn->query("SELECT * FROM products");
while($row = $res->fetch_assoc()) $products[] = $row;

// handle add-to-cart from POST
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])){
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['qty']);
    // find product
    $stmt = $conn->prepare("SELECT id,name,price FROM products WHERE id = ?");
    $stmt->bind_param('i',$pid);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if($r){
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        // if exists, increment
        $found = false;
        foreach($_SESSION['cart'] as &$item){
            if($item['id'] == $r['id']){
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }
        if(!$found) $_SESSION['cart'][] = ['id'=>$r['id'],'name'=>$r['name'],'price'=>$r['price'],'qty'=>$qty];
        header('Location: cart.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Menu - Heart Brew</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <header class="site-header">
    <div class="container">
      <h1 class="brand">Heart Brew</h1>
      <nav>
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="cart.php">Cart<?php if(!empty($_SESSION['cart'])) echo ' (' . array_sum(array_column($_SESSION['cart'],'qty')) . ')'; ?></a>
      </nav>
    </div>
  </header>

  <main class="container">
    <h2>Menu</h2>
    <div class="grid">
      <?php foreach($products as $p): ?>
      <div class="product-card">
        <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="" class="product-img">
        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
        <p class="muted"><?php echo htmlspecialchars($p['description']); ?></p>
        <p class="price">₱<?php echo number_format($p['price'],2); ?></p>
        <form method="POST" class="add-form">
          <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
          <input type="number" name="qty" value="1" min="1" class="qty">
          <button class="btn" type="submit">Add to cart</button>
        </form>
      </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="site-footer"><div class="container"><p>© Heart Brew</p></div></footer>
</body>
</html>
