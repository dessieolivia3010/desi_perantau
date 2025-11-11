<?php
require 'config.php';
if(is_logged_in()) header('Location: dashboard.php');
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  $stmt = $pdo->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
  $stmt->execute([$email]); $user = $stmt->fetch();
  if($user && password_verify($pass, $user['password'])){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];
    header('Location: dashboard.php'); exit;
  } else $err='Email atau password salah';
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Login</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><div class="card" style="max-width:520px;margin:40px auto;">
<h2>Login</h2>
<?php if(isset($_GET['registered'])): ?><div style="color:green">Registrasi berhasil. Silakan login.</div><?php endif; ?>
<?php if($err): ?><div style="color:#b71c1c"><?php echo $err; ?></div><?php endif; ?>
<form method="post" class="form-row">
  <input name="email" type="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button class="btn btn-primary" type="submit">Login</button>
</form>
<div style="margin-top:8px;">Belum punya akun? <a href="register.php">Daftar</a></div>
</div></div></body></html>
