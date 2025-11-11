<?php
require 'config.php';
require_login();
require 'fpdf.php';
$items = $pdo->query('SELECT b.*, cr.cluster_label FROM tb_bahan_baku b LEFT JOIN tb_cluster_result cr ON cr.bahan_id=b.id ORDER BY b.id')->fetchAll();
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Laporan Stok Bahan - Unclehouse Depok',0,1);
$pdf->Ln(4);
foreach($items as $it){
  $line = sprintf('%s | %s | %s | Stok:%d | Pemakaian:%d | %s', $it['kode'],$it['nama'],$it['kategori'],(int)$it['stok_akhir'],(int)$it['pemakaian_per_minggu'],($it['cluster_label']!==null? 'Cluster '.(int)$it['cluster_label'] : 'Belum'));
  $pdf->Cell(0,6,$line,0,1);
}
$pdf->Output('D','laporan_stok_bahan.pdf');
