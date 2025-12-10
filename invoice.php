<?php
session_start();
include "includes/db.php";

// Get order ID from URL
if (!isset($_GET['order_id'])) {
    die("Invalid invoice.");
}
$order_id = $_GET['order_id'];

// Get order info
$order = $conn->query("SELECT * FROM orders WHERE id = $order_id")->fetch_assoc();

// Get order items
$items = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");

?>
<!DOCTYPE html>
<html>
<head>
<title>Invoice #<?php echo $order_id; ?></title>
<style>
body { font-family: Arial; margin: 40px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
table, th, td { border: 1px solid #ccc; padding: 10px; }
.total { text-align: right; font-size: 20px; margin-top: 20px; }
.print-btn { padding: 10px 20px; background: black; color: white; border: none; margin-top: 20px; cursor: pointer; }
</style>
</head>

<body>

<h1>Heart Brew — Invoice</h1>
<p><b>Order #:</b> <?php echo $order_id; ?></p>
<p><b>Date:</b> <?php echo $order['created_at']; ?></p>

<table>
<tr>
    <th>Item</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Subtotal</th>
</tr>

<?php while ($row = $items->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['qty']; ?></td>
    <td>₱<?php echo $row['price']; ?></td>
    <td>₱<?php echo $row['qty'] * $row['price']; ?></td>
</tr>
<?php endwhile; ?>

</table>

<div class="total">
<b>Total: ₱<?php echo $order['total']; ?></b>
</div>

<div style="text-align:right; margin-top:30px;">
    <a href="index.php" 
       style="
           padding:10px 20px;
           background:#333;
           color:#fff;
           text-decoration:none;
           border-radius:5px;
           font-size:16px;
       ">
        Exit 
    </a>

    <p align="center"><i>Thank you for purchasing</i></p>

</div>


</body>
</html>
