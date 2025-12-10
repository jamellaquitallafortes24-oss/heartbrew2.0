<?php
session_start();
include "includes/db.php";

if(empty($_SESSION['cart'])){
    header('Location: cart.php');
    exit;
}

$total = 0;
foreach($_SESSION['cart'] as $item) $total += $item['price'] * $item['qty'];

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // create a simple guest user if not logged in
    if(!isset($_SESSION['user'])){

    $name  = trim($_POST['fullname']);
    $email = trim($_POST['email']);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if($result->num_rows > 0){
        // Use the existing user
        $user_id = $result->fetch_assoc()['id'];
    } else {
        // Create a temporary guest user
        $tmpPass = password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $name, $email, $tmpPass);
        $insert->execute();

        $user_id = $insert->insert_id;
    }

} else {
    // Logged in user
    $user_id = $_SESSION['user']['id'];
}

    // insert order
    $stmt = $conn->prepare("INSERT INTO orders (user_id,total) VALUES (?,?)");
    $stmt->bind_param('id',$user_id,$total);
    if($stmt->execute()){
        $order_id = $stmt->insert_id;
        // insert items
        $itstmt = $conn->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)");
        foreach($_SESSION['cart'] as $it){
            $itstmt->bind_param('iiid',$order_id,$it['id'],$it['qty'],$it['price']);
            $itstmt->execute();
        }
        unset($_SESSION['cart']);

header("Location: invoice.php?order_id=" . $order_id);
exit;

        $msg = 'Order placed! Your order ID is ' . $order_id;
    } else {
        $msg = 'Failed to create order: ' . $conn->error;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Checkout - Heart Brew</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <header class="site-header"><div class="container"><h1 class="brand">Heart Brew</h1></div></header>
  <main class="container">
    <h2>Checkout</h2>
    <?php if($msg): ?><p class="success"><?=htmlspecialchars($msg)?></p><?php else: ?>
    <div class="checkout-grid">
      <div>
        <h3>Order summary</h3>
        <ul class="summary">
          <?php foreach($_SESSION['cart'] as $it): ?>
            <li><?php echo htmlspecialchars($it['name']); ?> × <?php echo $it['qty']; ?> — ₱<?php echo number_format($it['price']*$it['qty'],2); ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="total">Total: ₱<?php echo number_format($total,2); ?></p>
      </div>
      <div>
        <h3>Billing</h3>
        <form method="POST" class="auth-form">
          <input name="fullname" placeholder="Full name" required>
          <input name="email" type="email" placeholder="Email" required>
          <p><em>Payment is simulated. This demo stores the order in the database only.</em></p>
          <button class="btn" type="submit">Place order</button>
        </form>
      </div>
    </div>
    <?php endif; ?>
  </main>
</body>
</html>
