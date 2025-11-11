<?php
require 'config.php';
require_login();
if(isset($_GET['delete'])){ $id=intval($_GET['delete']); $pdo->prepare('DELETE FROM tb_bahan_baku WHERE id=?')->execute([$id]); header('Location: bahan_list.php'); exit; }
$items = $pdo->query('SELECT b.*, cr.cluster_label FROM tb_bahan_baku b LEFT JOIN tb_cluster_result cr ON cr.bahan_id=b.id ORDER BY b.id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Kelola Bahan</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container">
  <header><div class="brand">Unclehouse Depok</div><div><h1>Kelola Bahan Baku</h1></div></header>
  <div class="card">
    <a href="dashboard.php" class="btn">Kembali</a>
    <form action="add_bahan.php" method="post" class="form-row" style="margin-top:12px;">
      <input name="kode" placeholder="Kode bahan" required>
      <input name="nama" placeholder="Nama bahan" required>
      <input name="kategori" placeholder="Kategori">
      <input name="stok_awal" type="number" placeholder="Stok Awal" required>
      <input name="stok_akhir" type="number" placeholder="Stok Akhir" required>
      <input name="pemakaian_per_minggu" type="number" placeholder="Pemakaian/minggu" required>
      <input name="harga" type="number" placeholder="Harga" required>
      <button class="btn btn-primary" type="submit">Tambah</button>
    </form>
  </div>

  <div class="card">
    <h2>Daftar Bahan</h2>
    <table><thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok Akhir</th><th>Pemakaian</th><th>Cluster</th><th>Aksi</th></tr></thead><tbody>
    <?php foreach($items as $it): ?>
    <tr>
      <td><?php echo htmlspecialchars($it['kode']); ?></td>
      <td><?php echo htmlspecialchars($it['nama']); ?></td>
      <td><?php echo htmlspecialchars($it['kategori']); ?></td>
      <td><?php echo (int)$it['stok_akhir']; ?></td>
      <td><?php echo (int)$it['pemakaian_per_minggu']; ?></td>
      <td><?php echo ($it['cluster_label']!==null)? 'Cluster '.(int)$it['cluster_label'] : 'Belum'; ?></td>
      <td><a href="edit_bahan.php?id=<?php echo $it['id']; ?>">Edit</a> | <a href="bahan_list.php?delete=<?php echo $it['id']; ?>" onclick="return confirm('Hapus?')">Hapus</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody></table>
  </div>
</div></body></html>
