<?php
require 'config.php';
require_login();
$user = $_SESSION['user_name'];
$total = $pdo->query('SELECT COUNT(*) FROM tb_bahan_baku')->fetchColumn();
$clustered = $pdo->query('SELECT COUNT(DISTINCT bahan_id) FROM tb_cluster_result')->fetchColumn();
$low = $pdo->query('SELECT COUNT(*) FROM tb_bahan_baku WHERE stok_akhir < 20')->fetchColumn();
$items = $pdo->query('SELECT nama, stok_akhir FROM tb_bahan_baku ORDER BY id LIMIT 6')->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'>
<title>Dashboard</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container">
  <header>
    <div class="brand">Unclehouse Depok</div>
    <div><h1>Dashboard</h1><div style="color:#555">Selamat datang, <?php echo htmlspecialchars($user); ?></div></div>
  </header>

  <div class="card">
    <div class="flex" style="justify-content:space-between;align-items:center;">
      <div style="font-weight:600">Ringkasan</div>
      <div class="controls">
        <a href="bahan_list.php" class="btn btn-accent">Kelola Bahan</a>
        <a href="supplier_list.php" class="btn">Supplier</a>
        <a href="purchases.php" class="btn">Pembelian</a>
        <a href="usages.php" class="btn">Penggunaan</a>
        <a href="run_kmeans.php?k=3" class="btn btn-primary">Jalankan K-Means</a>
        <a href="report.php" class="btn">Laporan</a>
        <a href="logout.php" class="btn">Logout</a>
      </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:12px;">
      <div class="card" style="flex:1;padding:12px;"><div style="font-size:14px;color:#777">Total Bahan</div><div style="font-size:20px"><?php echo $total; ?></div></div>
      <div class="card" style="flex:1;padding:12px;"><div style="font-size:14px;color:#777">Telah Dicluster</div><div style="font-size:20px"><?php echo $clustered; ?></div></div>
      <div class="card" style="flex:1;padding:12px;"><div style="font-size:14px;color:#777">Stok rendah (&lt;20)</div><div style="font-size:20px"><?php echo $low; ?></div></div>
    </div>

    <div class="card" style="margin-top:12px;">
      <h3>Stok Teratas</h3>
      <canvas id="stockChart" style="max-width:600px"></canvas>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = <?php echo json_encode(array_column($items,'nama')); ?>;
  const data = <?php echo json_encode(array_column($items,'stok_akhir')); ?>;
  const ctx = document.getElementById('stockChart').getContext('2d');
  new Chart(ctx, { type: 'bar', data: { labels: labels, datasets: [{ label: 'Stok Akhir', data: data }] } });
</script>
</body></html>
