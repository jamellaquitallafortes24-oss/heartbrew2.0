<?php
session_start();
include "../includes/db.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header('Location: ../index.php'); exit;
}
$res = $conn->query("SELECT o.*, u.fullname FROM orders o LEFT JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC");
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Orders</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<div class="container">
  <h2>Orders</h2>
  <table class="cart-table">
    <thead><tr><th>ID</th><th>User</th><th>Total</th><th>Date</th></tr></thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
        <td>₱<?php echo number_format($row['total'],2); ?></td>
        <td><?php echo $row['created_at']; ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <p><a href="index.php">Back</a></p>
</div>
</body></html>
