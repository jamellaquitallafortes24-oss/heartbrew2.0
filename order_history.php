<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

// Get all orders of the user
$orders = $conn->query("
    SELECT * FROM orders 
    WHERE user_id = $user_id 
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Your Orders</title>
<style>
body { font-family: Arial; padding: 20px; }
.order-box {
    background:#fff;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}
.order-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.products-list {
    margin-top:10px;
    padding-left:20px;
}
a.btn {
    padding:6px 12px;
    background:#333;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
.status-badge {
    padding:5px 10px;
    border-radius:5px;
    color:white;
    font-size:14px;
}
.status-Pending { background:orange; }
.status-Preparing { background:#007bff; }
.status-Ready { background:green; }
</style>
</head>

<body>

<h2>Your Orders</h2>

<?php while ($order = $orders->fetch_assoc()): ?>

<div class="order-box">
    
    <!-- ORDER HEADER -->
    <div class="order-header">
        <div>
            <h3>Order #<?= $order['id'] ?></h3>
            <p>Date: <?= $order['created_at'] ?></p>
            <p>Total: ₱<?= number_format($order['total'],2) ?></p>
            <p>Status: <span class="status-badge status-<?= str_replace(' ','',$order['status']) ?>">
                <?= $order['status'] ?>
            </span></p>
        </div>

        <div>
            <a href="invoice.php?order_id=<?= $order['id'] ?>" class="btn">View Receipt</a>
            <a href="reorder.php?order_id=<?= $order['id'] ?>" class="btn">Reorder</a>
        </div>
    </div>

    <!-- ORDERED ITEMS -->
    <div class="products-list">
        <strong>Items:</strong>
        <ul>
        <?php
            $oid = $order['id'];
            $items = $conn->query("
                SELECT oi.qty, oi.price, p.name 
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE order_id = $oid
            ");
            while ($it = $items->fetch_assoc()):
        ?>
            <li><?= $it['qty'] ?> × <?= $it['name'] ?> — ₱<?= number_format($it['price'],2) ?></li>
        <?php endwhile; ?>
        </ul>
    </div>

</div>

<?php endwhile; ?>

</body>
</html>
