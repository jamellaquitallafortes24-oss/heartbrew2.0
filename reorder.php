<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['order_id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = intval($_GET['order_id']);

$items = $conn->query("
    SELECT product_id, qty 
    FROM order_items 
    WHERE order_id = $order_id
");

while ($row = $items->fetch_assoc()) {

    // Get product info
    $p = $conn->query("SELECT * FROM products WHERE id = ".$row['product_id'])->fetch_assoc();

    // Add to cart
    $_SESSION['cart'][$p['id']] = [
        'id' => $p['id'],
        'name' => $p['name'],
        'price' => $p['price'],
        'qty' => $row['qty']
    ];
}

header("Location: cart.php?reordered=1");
exit;
