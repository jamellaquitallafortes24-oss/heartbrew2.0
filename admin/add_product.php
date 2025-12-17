<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../includes/db.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header('Location: ../index.php'); 
    exit;
}

$msg = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = (float)$_POST['price'];
    $category = $_POST['category'];

    // handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['tmp_name']){
        $target = '../assets/images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        // save path for db
        $img = 'assets/images/' . basename($_FILES['image']['name']);
    } else {
        $img = 'assets/images/coffee1.svg'; // default image
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $name, $price, $desc, $img, $category);

    if($stmt->execute()){
        $msg = 'Product added successfully';
    } else {
        $msg = 'Error: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
    <h2>Add Product</h2>

    <?php if($msg): ?>
        <p class="success"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="auth-form">

        <input name="name" placeholder="Product name" required>

        <textarea name="description" placeholder="Product description"></textarea>

        <input name="price" type="number" step="0.01" placeholder="Price" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="">Select category</option>
            <option value="Hot">Hot Coffee</option>
            <option value="Cold">Cold Drinks</option>
            <option value="Frappe">Frappe</option>
            <option value="Pastry">Pastry</option>
            <option value="Non-Coffee">Non-Coffee</option>
        </select>

        <br><br>

        <label>Product Image:</label>
        <input type="file" name="image" accept="image/*">

        <button class="btn" type="submit">Add Product</button>
    </form>

    <p><a href="index.php">Back to Admin Dashboard</a></p>
</div>

</body>
</html>
