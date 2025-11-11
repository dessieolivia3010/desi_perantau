<?php
require 'config.php';
require_login();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $bahan = intval($_POST['bahan_id']); $qty = intval($_POST['qty']); $tanggal = $_POST['tanggal']; $note = $_POST['note'];
  $pdo->prepare('INSERT INTO usages (bahan_id,qty,tanggal,note) VALUES (?,?,?,?)')->execute([$bahan,$qty,$tanggal,$note]);
  // reduce stok_akhir
  $pdo->prepare('UPDATE tb_bahan_baku SET stok_akhir = GREATEST(0, stok_akhir - ?) WHERE id=?')->execute([$qty,$bahan]);
  header('Location: usages.php'); exit;
}
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $pdo->prepare('DELETE FROM usages WHERE id=?')->execute([$id]); header('Location: usages.php'); exit; }
$rows = $pdo->query('SELECT u.*, b.nama as bahan FROM usages u LEFT JOIN tb_bahan_baku b ON b.id=u.bahan_id ORDER BY u.id DESC')->fetchAll();
$bahan = $pdo->query('SELECT id,nama FROM tb_bahan_baku')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Penggunaan</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><header><div class="brand">Unclehouse Depok</div><div><h1>Penggunaan Bahan</h1></div></header>
<div class="card"><a href="dashboard.php" class="btn">Kembali</a>
  <form method="post" class="form-row" style="margin-top:12px;">
    <select name="bahan_id" required><option value="">Pilih bahan</option><?php foreach($bahan as $b) echo '<option value="'.$b['id'].'">'.htmlspecialchars($b['nama']).'</option>'; ?></select>
    <input name="qty" type="number" placeholder="Qty terpakai" required>
    <input name="tanggal" type="date" required>
    <input name="note" placeholder="Keterangan">
    <button class="btn btn-primary" type="submit">Tambah</button>
  </form></div>
<div class="card"><h2>Riwayat Pemakaian</h2><table><thead><tr><th>Tanggal</th><th>Bahan</th><th>Qty</th><th>Note</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?php echo htmlspecialchars($r['tanggal']); ?></td><td><?php echo htmlspecialchars($r['bahan']); ?></td><td><?php echo (int)$r['qty']; ?></td><td><?php echo htmlspecialchars($r['note']); ?></td><td><a href="usages.php?delete=<?php echo $r['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></body></html>
