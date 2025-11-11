<?php
require 'config.php';
require_login();
if($_SERVER['REQUEST_METHOD']!=='POST') exit('Invalid');
$kode=$_POST['kode']; $nama=$_POST['nama']; $kategori=$_POST['kategori'] ?? '';
$stok_awal=intval($_POST['stok_awal']); $stok_akhir=intval($_POST['stok_akhir']); $pemakaian=intval($_POST['pemakaian_per_minggu']); $harga=floatval($_POST['harga']);
$pdo->prepare('INSERT INTO tb_bahan_baku (kode,nama,kategori,stok_awal,stok_akhir,pemakaian_per_minggu,harga) VALUES (?,?,?,?,?,?,?)')
    ->execute([$kode,$nama,$kategori,$stok_awal,$stok_akhir,$pemakaian,$harga]);
header('Location: bahan_list.php');
