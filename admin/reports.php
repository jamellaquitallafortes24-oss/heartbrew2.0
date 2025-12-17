<?php
session_start();
include "../includes/db.php";

// Prevent access if not admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

/* =============================
   1. DAILY SALES FOR LAST 7 DAYS
   ============================= */
$daily_labels = [];
$daily_sales = [];

for ($i = 6; $i >= 0; $i--) {
    $date = date("Y-m-d", strtotime("-$i days"));
    $label = date("M d", strtotime($date));

    $stmt = $conn->prepare("SELECT IFNULL(SUM(total),0) AS sales 
                            FROM orders WHERE DATE(created_at) = ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc()['sales'];

    $daily_labels[] = $label;
    $daily_sales[] = $result;
}

/* =============================
   2. MONTHLY ORDERS (LAST 6 MONTHS)
   ============================= */
$month_labels = [];
$month_orders = [];

for ($m = 5; $m >= 0; $m--) {
    $month_key = date("Y-m", strtotime("-$m months"));
    $label = date("M Y", strtotime($month_key));

    $stmt = $conn->prepare("SELECT COUNT(*) AS total_orders 
                            FROM orders WHERE DATE_FORMAT(created_at,'%Y-%m') = ?");
    $stmt->bind_param("s", $month_key);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc()['total_orders'];

    $month_labels[] = $label;
    $month_orders[] = $row;
}

/* =============================
   3. TOP 5 PRODUCTS BY QUANTITY SOLD
   ============================= */
$top_labels = [];
$top_qty = [];

$result = $conn->query("
    SELECT product_name, SUM(qty) AS sold
    FROM order_items
    GROUP BY product_name
    ORDER BY sold DESC
    LIMIT 5
");

while ($row = $result->fetch_assoc()) {
    $top_labels[] = $row['product_name'];
    $top_qty[] = $row['sold'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        h2 { margin-bottom: 20px; }

        .chart-box {
            background: white;
            padding: 20px;
            margin-bottom: 40px;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

<h2>Admin Reports</h2>

<!-- DAILY SALES -->
<div class="chart-box">
    <h3>Daily Sales (Last 7 Days)</h3>
    <canvas id="dailyChart"></canvas>
</div>

<!-- MONTHLY ORDERS -->
<div class="chart-box">
    <h3>Monthly Orders (Last 6 Months)</h3>
    <canvas id="monthlyChart"></canvas>
</div>

<!-- TOP PRODUCTS -->
<div class="chart-box">
    <h3>Top 5 Best-Selling Products</h3>
    <canvas id="topChart"></canvas>
</div>

<script>
/* --- DAILY SALES CHART --- */
new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($daily_labels); ?>,
        datasets: [{
            label: "Daily Sales (₱)",
            data: <?php echo json_encode($daily_sales); ?>,
            borderWidth: 2,
            fill: true
        }]
    }
});

/* --- MONTHLY ORDERS CHART --- */
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($month_labels); ?>,
        datasets: [{
            label: "Orders",
            data: <?php echo json_encode($month_orders); ?>,
            borderWidth: 2,
        }]
    }
});

/* --- TOP PRODUCTS CHART --- */
new Chart(document.getElementById('topChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($top_labels); ?>,
        datasets: [{
            label: "Quantity Sold",
            data: <?php echo json_encode($top_qty); ?>,
            borderWidth: 2,
        }]
    }
});
</script>
<a href="index.php" style="display:inline-block; padding:10px 20px; background:#333; color:white; text-decoration:none; border-radius:5px; margin-bottom:20px;">← Back to Dashboard</a>

</body>
</html>
