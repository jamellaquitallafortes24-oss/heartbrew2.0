<?php
session_start();
include "../includes/db.php";
// Today's sales
$today = date("Y-m-d");
$today_sales = $conn->query("SELECT IFNULL(SUM(total),0) AS total FROM orders WHERE DATE(created_at)='$today'")->fetch_assoc()['total'];

// Total orders
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];

// Average order value
$avg_order = $conn->query("SELECT IFNULL(AVG(total),0) AS avg FROM orders")->fetch_assoc()['avg'];

// Top product
$top = $conn->query("
    SELECT product_name, SUM(qty) AS total_qty
    FROM order_items
    GROUP BY product_name
    ORDER BY total_qty DESC
    LIMIT 1
")->fetch_assoc();

// Prevent access if not admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

/* =============================
   1. CALCULATE DASHBOARD NUMBERS
   ============================= */

// TODAY'S DATE RANGE
$today = date("Y-m-d");
$start = $today . " 00:00:00";
$end   = $today . " 23:59:59";

// 1) Today's Sales
$stmt = $conn->prepare("SELECT IFNULL(SUM(total),0) AS today_sales FROM orders WHERE created_at BETWEEN ? AND ?");
$stmt->bind_param("ss", $start, $end);
$stmt->execute();
$today_sales = $stmt->get_result()->fetch_assoc()['today_sales'];

// 2) Total orders (all time)
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = $result->fetch_assoc()['total_orders'];

// 3) Average order value (all time)
$result = $conn->query("SELECT IFNULL(AVG(total),0) AS avg_order FROM orders");
$avg_order = $result->fetch_assoc()['avg_order'];

// 4) Top product (by quantity sold)
$result = $conn->query("
    SELECT product_name, SUM(qty) AS sold
    FROM order_items
    GROUP BY product_name
    ORDER BY sold DESC
    LIMIT 1
");

$top = $result->fetch_assoc();
$top_product = $top ? $top['product_name'] : '—';
$top_qty     = $top ? $top['sold'] : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <style>
        body { font-family: Arial; background:#f5f5f5; padding:30px; }
        h2 { margin-bottom:20px; }

        .grid {
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap:20px;
        }

        .card {
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
            text-align:center;
        }

        .card h3 { margin:0; font-size:18px; color:#444; }
        .card p  { font-size:22px; margin-top:10px; font-weight:bold; }

        .btn {
            display:inline-block;
            background:#333;
            color:white;
            padding:10px 20px;
            text-decoration:none;
            margin-top:25px;
            border-radius:5px;
        }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>
<div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
    <div style="padding:20px; background:#fff; border-radius:10px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <h3>Today's Sales</h3>
        <p>₱<?= number_format($today_sales, 2) ?></p>
    </div>
    <div style="padding:20px; background:#fff; border-radius:10px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <h3>Total Orders</h3>
        <p><?= $total_orders ?></p>
    </div>
    <div style="padding:20px; background:#fff; border-radius:10px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <h3>Average Order</h3>
        <p>₱<?= number_format($avg_order, 2) ?></p>
    </div>
    <div style="padding:20px; background:#fff; border-radius:10px; flex:1; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
        <h3>Top Product</h3>
        <p><?= $top['product_name'] ?? '—' ?> (<?= $top['total_qty'] ?? 0 ?>)</p>
    </div>
</div>


<br><br>
<div class="admin-menu">
  <a href="add_product.php" class="btn" style="background:#c0392b;">Add New Product</a>
<a href="reports.php" class="btn" style="background:#c0392b;">Reports</a>
<a href="view_orders.php" class="btn" style="background:#c0392b;">Orders</a>


</div>
  <div style="text-align:right; margin-bottom:20px;">
  <a href="logout.php" class="btn" style="background:#c0392b;">Logout</a>
</div>

</body>


</html>
