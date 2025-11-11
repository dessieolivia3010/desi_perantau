<?php
require 'config.php';
require_login();
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $pdo->prepare('DELETE FROM suppliers WHERE id=?')->execute([$id]); header('Location: supplier_list.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = $_POST['name']; $contact = $_POST['contact'];
  $pdo->prepare('INSERT INTO suppliers (name,contact) VALUES (?,?)')->execute([$name,$contact]);
  header('Location: supplier_list.php'); exit;
}
$suppliers = $pdo->query('SELECT * FROM suppliers ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Supplier</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><header><div class="brand">Unclehouse Depok</div><div><h1>Supplier</h1></div></header>
<div class="card"><a href="dashboard.php" class="btn">Kembali</a>
  <form method="post" class="form-row" style="margin-top:12px;">
    <input name="name" placeholder="Nama supplier" required>
    <input name="contact" placeholder="Kontak">
    <button class="btn btn-primary" type="submit">Tambah</button>
  </form>
</div>
<div class="card"><h2>Daftar Supplier</h2><table><thead><tr><th>Nama</th><th>Kontak</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($suppliers as $s): ?><tr><td><?php echo htmlspecialchars($s['name']); ?></td><td><?php echo htmlspecialchars($s['contact']); ?></td><td><a href="supplier_list.php?delete=<?php echo $s['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></body></html>
