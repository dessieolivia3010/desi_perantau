async function runKmeans(k=3){
  const resp = await fetch('run_kmeans.php?k=' + k);
  if(resp.redirected) location.href = resp.url;
  else { const t = await resp.text(); alert(t); }
}
