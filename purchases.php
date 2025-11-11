<?php
require 'config.php';
require_login();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $bahan = intval($_POST['bahan_id']); $supplier = intval($_POST['supplier_id']); $qty = intval($_POST['qty']); $harga = floatval($_POST['harga']); $tanggal = $_POST['tanggal'];
  $pdo->prepare('INSERT INTO purchases (bahan_id,supplier_id,qty,harga,tanggal) VALUES (?,?,?,?,?)')->execute([$bahan,$supplier,$qty,$harga,$tanggal]);
  // update stok_akhir
  $pdo->prepare('UPDATE tb_bahan_baku SET stok_akhir = stok_akhir + ? WHERE id=?')->execute([$qty,$bahan]);
  header('Location: purchases.php'); exit;
}
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $pdo->prepare('DELETE FROM purchases WHERE id=?')->execute([$id]); header('Location: purchases.php'); exit; }
$purchases = $pdo->query('SELECT p.*, b.nama as bahan, s.name as supplier FROM purchases p LEFT JOIN tb_bahan_baku b ON b.id=p.bahan_id LEFT JOIN suppliers s ON s.id=p.supplier_id ORDER BY p.id DESC')->fetchAll();
$bahan = $pdo->query('SELECT id,nama FROM tb_bahan_baku')->fetchAll();
$suppliers = $pdo->query('SELECT id,name FROM suppliers')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Pembelian</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><header><div class="brand">Unclehouse Depok</div><div><h1>Pembelian Bahan</h1></div></header>
<div class="card"><a href="dashboard.php" class="btn">Kembali</a>
  <form method="post" class="form-row" style="margin-top:12px;">
    <select name="bahan_id" required><option value="">Pilih bahan</option><?php foreach($bahan as $b) echo '<option value="'.$b['id'].'">'.htmlspecialchars($b['nama']).'</option>'; ?></select>
    <select name="supplier_id" required><option value="">Pilih supplier</option><?php foreach($suppliers as $s) echo '<option value="'.$s['id'].'">'.htmlspecialchars($s['name']).'</option>'; ?></select>
    <input name="qty" type="number" placeholder="Qty" required>
    <input name="harga" type="number" placeholder="Harga total" required>
    <input name="tanggal" type="date" required>
    <button class="btn btn-primary" type="submit">Tambah</button>
  </form></div>
<div class="card"><h2>Riwayat Pembelian</h2><table><thead><tr><th>Tanggal</th><th>Bahan</th><th>Supplier</th><th>Qty</th><th>Harga</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($purchases as $p): ?><tr><td><?php echo htmlspecialchars($p['tanggal']); ?></td><td><?php echo htmlspecialchars($p['bahan']); ?></td><td><?php echo htmlspecialchars($p['supplier']); ?></td><td><?php echo (int)$p['qty']; ?></td><td><?php echo $p['harga']; ?></td><td><a href="purchases.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></body></html>
