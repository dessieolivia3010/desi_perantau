<?php
require 'config.php';
require_login();
$items = $pdo->query('SELECT b.*, cr.cluster_label FROM tb_bahan_baku b LEFT JOIN tb_cluster_result cr ON cr.bahan_id=b.id ORDER BY b.id')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Laporan</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container"><header><div class="brand">Unclehouse Depok</div><div><h1>Laporan Stok Bahan</h1></div></header>
<div class="card"><div class="controls"><a href="dashboard.php" class="btn">Kembali</a><button onclick="window.print()" class="btn btn-primary">Cetak / Save as PDF</button><a href="report_pdf.php" class="btn btn-accent">Download PDF (server)</a><a href="export_csv.php" class="btn">Export CSV</a></div></div>
<div class="card"><table><thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok Akhir</th><th>Pemakaian</th><th>Cluster</th></tr></thead><tbody>
<?php foreach($items as $it): ?><tr><td><?php echo htmlspecialchars($it['kode']); ?></td><td><?php echo htmlspecialchars($it['nama']); ?></td><td><?php echo htmlspecialchars($it['kategori']); ?></td><td><?php echo (int)$it['stok_akhir']; ?></td><td><?php echo (int)$it['pemakaian_per_minggu']; ?></td><td><?php echo ($it['cluster_label']!==null)? 'Cluster '.(int)$it['cluster_label'] : 'Belum'; ?></td></tr><?php endforeach; ?>
</tbody></table></div></div></body></html>
