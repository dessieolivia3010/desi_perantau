<?php
require 'config.php';
if(is_logged_in()) header('Location: dashboard.php');
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  if(!$name || !$email || !$pass) $err='Semua field wajib diisi';
  else {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email=?');
    $stmt->execute([$email]);
    if($stmt->fetch()) $err='Email sudah terdaftar';
    else {
      $hash = password_hash($pass, PASSWORD_BCRYPT);
      $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)')->execute([$name,$email,$hash]);
      header('Location: login.php?registered=1'); exit;
    }
  }
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Register</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><div class="card" style="max-width:640px;margin:30px auto;">
<h2>Daftar Akun</h2>
<?php if($err): ?><div style="color:#b71c1c"><?php echo $err; ?></div><?php endif; ?>
<form method="post" class="form-row">
  <input name="name" placeholder="Nama lengkap" required>
  <input name="email" type="email" placeholder="Email" required>
  <input name="password" type="password" placeholder="Password" required>
  <button class="btn btn-primary" type="submit">Daftar</button>
</form>
<div style="margin-top:8px;">Sudah punya akun? <a href="login.php">Login</a></div>
</div></div></body></html>
