<?php
session_start();
include "../includes/db.php";

$orders = $conn->query("
    SELECT o.*, u.name AS customer
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    ORDER BY o.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Orders</title>
<style>
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
td, th { border: 1px solid #ccc; padding: 10px; }
</style>
</head>

<body>
<h2>All Orders</h2>

<table>
<tr>
    <th>Order #</th>
    <th>Customer</th>
    <th>Date</th>
    <th>Total</th>
    <th>View</th>
</tr>

<?php while ($row = $orders->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['customer']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>₱<?php echo $row['total']; ?></td>
    <td><a href="../invoice.php?order_id=<?php echo $row['id']; ?>">Invoice</a></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
