<?php
require 'config.php';
require_login();
$id = intval($_GET['id'] ?? 0);
if(!$id) header('Location: bahan_list.php');
$stmt = $pdo->prepare('SELECT * FROM tb_bahan_baku WHERE id=?'); $stmt->execute([$id]); $it = $stmt->fetch();
if(!$it) header('Location: bahan_list.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $kode=$_POST['kode']; $nama=$_POST['nama']; $kategori=$_POST['kategori'] ?? '';
  $stok_awal=intval($_POST['stok_awal']); $stok_akhir=intval($_POST['stok_akhir']); $pemakaian=intval($_POST['pemakaian_per_minggu']); $harga=floatval($_POST['harga']);
  $pdo->prepare('UPDATE tb_bahan_baku SET kode=?,nama=?,kategori=?,stok_awal=?,stok_akhir=?,pemakaian_per_minggu=?,harga=? WHERE id=?')
      ->execute([$kode,$nama,$kategori,$stok_awal,$stok_akhir,$pemakaian,$harga,$id]);
  header('Location: bahan_list.php'); exit;
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Edit Bahan</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><div class="card" style="max-width:720px;margin:20px auto;">
<h2>Edit Bahan</h2>
<form method="post" class="form-row">
  <input name="kode" value="<?php echo htmlspecialchars($it['kode']); ?>" required>
  <input name="nama" value="<?php echo htmlspecialchars($it['nama']); ?>" required>
  <input name="kategori" value="<?php echo htmlspecialchars($it['kategori']); ?>">
  <input name="stok_awal" type="number" value="<?php echo (int)$it['stok_awal']; ?>" required>
  <input name="stok_akhir" type="number" value="<?php echo (int)$it['stok_akhir']; ?>" required>
  <input name="pemakaian_per_minggu" type="number" value="<?php echo (int)$it['pemakaian_per_minggu']; ?>" required>
  <input name="harga" type="number" value="<?php echo htmlspecialchars($it['harga']); ?>" required>
  <button class="btn btn-primary" type="submit">Simpan</button>
  <a href="bahan_list.php" class="btn">Batal</a>
</form></div></div></body></html>
