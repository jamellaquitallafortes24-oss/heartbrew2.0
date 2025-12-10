<?php
session_start();
include "includes/db.php";
$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id,fullname,email,password,role FROM users WHERE email = ?");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();
    if($user = $res->fetch_assoc()){
        if(password_verify($pass, $user['password'])){
            unset($user['password']);
            $_SESSION['user'] = $user;
            if($user['role'] === 'admin') header('Location: admin/index.php');
            else header('Location: menu.php');
            exit;
        } else $msg = 'Invalid credentials';
    } else $msg = 'No user found';
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login - Heart Brew</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
  <div class="auth container">
    <h2>Login</h2>
    <?php if($msg): ?><p class="error"><?=htmlspecialchars($msg)?></p><?php endif; ?>
    <form method="POST" class="auth-form">
      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>
      <button class="btn" type="submit">Login</button>
    </form>
    <p>No account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
