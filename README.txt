Unclehouse Depok - Final App (K-Means Stock Clustering)
-------------------------------------------------------
Fitur:
- Register / Login / Logout
- Dashboard dengan chart ringkasan
- Kelola Bahan Baku (CRUD)
- Kelola Supplier
- Pembelian Bahan
- Penggunaan Bahan (stok keluar)
- Jalankan K-Means clustering (k dapat diatur)
- Laporan: cetak (browser) dan download PDF (server) + export CSV
- Tema warna coklat untuk coffee shop

Instruksi:
1. Ekstrak ke folder webserver (mis. htdocs/unclehouse_final_app)
2. Import db.sql ke MySQL:
   mysql -u root -p < db.sql
3. Edit config.php untuk menyesuaikan kredensial DB
4. Buka http://localhost/unclehouse_final_app/login.php
   Akun admin: admin@example.com / admin123

Catatan:
- PDF server menggunakan helper FPDF minimal (fpdf.php included).
- Chart menggunakan Chart.js via CDN.
