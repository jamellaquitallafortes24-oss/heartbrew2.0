<?php
session_start();
include "includes/db.php";

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (fullname,email,password) VALUES (?,?,?)");
    $stmt->bind_param('sss',$fullname,$email,$password);
    if($stmt->execute()){
        header('Location: login.php');
        exit;
    } else {
        $msg = 'Registration failed: ' . $conn->error;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register - Heart Brew</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <div class="auth container">
    <h2>Create an account</h2>
    <?php if($msg): ?><p class="error"><?=htmlspecialchars($msg)?></p><?php endif; ?>
    <form method="POST" class="auth-form">
      <input name="fullname" placeholder="Full name" required>
      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>
      <button class="btn" type="submit">Register</button>
    </form>
    <p>Have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
