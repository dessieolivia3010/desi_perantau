<?php
require 'config.php';
require_login();
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_stok_bahan.csv');
$out = fopen('php://output', 'w');
fputcsv($out, ['Kode','Nama','Kategori','Stok Akhir','Pemakaian','Cluster']);
$items = $pdo->query('SELECT b.*, cr.cluster_label FROM tb_bahan_baku b LEFT JOIN tb_cluster_result cr ON cr.bahan_id=b.id ORDER BY b.id')->fetchAll();
foreach($items as $it) fputcsv($out, [$it['kode'],$it['nama'],$it['kategori'],(int)$it['stok_akhir'],(int)$it['pemakaian_per_minggu'],($it['cluster_label']!==null? 'Cluster '.(int)$it['cluster_label'] : 'Belum')]);
fclose($out); exit;
