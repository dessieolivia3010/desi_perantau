<?php
require 'config.php';
require_login();
$k = isset($_GET['k']) ? max(2,intval($_GET['k'])) : 3;
$stmt = $pdo->query('SELECT id, stok_akhir, pemakaian_per_minggu FROM tb_bahan_baku');
$data = $stmt->fetchAll();
if(count($data) < $k){ header('Location: dashboard.php'); exit; }
$X = [];
foreach($data as $row){ $X[] = ['id'=>$row['id'],'f'=>[floatval($row['stok_akhir']), floatval($row['pemakaian_per_minggu'])]]; }
$cols = count($X[0]['f']);
$mins = array_fill(0,$cols,INF); $maxs = array_fill(0,$cols,-INF);
foreach($X as $r){ for($j=0;$j<$cols;$j++){ $v = $r['f'][$j]; if($v<$mins[$j]) $mins[$j]=$v; if($v>$maxs[$j]) $maxs[$j]=$v; } }
foreach($X as &$r){ for($j=0;$j<$cols;$j++){ $min=$mins[$j]; $max=$maxs[$j]; $v=$r['f'][$j]; $r['f'][$j] = ($max-$min==0)?0:($v-$min)/($max-$min); } } unset($r);
$indices = range(0,count($X)-1); shuffle($indices); $centroids=[]; for($i=0;$i<$k;$i++) $centroids[]=$X[$indices[$i]]['f'];
$labels = array_fill(0,count($X),-1); function dist($a,$b){ $s=0; for($i=0;$i<count($a);$i++){ $d=$a[$i]-$b[$i]; $s+=$d*$d; } return sqrt($s); }
$max_iter=100;
for($iter=0;$iter<$max_iter;$iter++){ $changed=false;
  for($i=0;$i<count($X);$i++){ $best=null;$best_d=null; for($c=0;$c<count($centroids);$c++){ $d=dist($X[$i]['f'],$centroids[$c]); if($best===null || $d<$best_d){ $best=$c;$best_d=$d; } } if($labels[$i]!==$best){ $labels[$i]=$best; $changed=true; } }
  $sums = array_fill(0,$k,array_fill(0,$cols,0)); $counts = array_fill(0,$k,0);
  for($i=0;$i<count($X);$i++){ $lab=$labels[$i]; $counts[$lab]++; for($j=0;$j<$cols;$j++) $sums[$lab][$j]+=$X[$i]['f'][$j]; }
  for($c=0;$c<$k;$c++){ if($counts[$c]==0) continue; for($j=0;$j<$cols;$j++) $centroids[$c][$j] = $sums[$c][$j]/$counts[$c]; }
  if(!$changed) break;
}
$pdo->exec('TRUNCATE TABLE tb_cluster_result');
$ins = $pdo->prepare('INSERT INTO tb_cluster_result (bahan_id,cluster_label,distance_to_centroid) VALUES (?,?,?)');
for($i=0;$i<count($X);$i++){ $lab=$labels[$i]; $d=dist($X[$i]['f'],$centroids[$lab]); $ins->execute([$X[$i]['id'],$lab,$d]); }
header('Location: bahan_list.php');
