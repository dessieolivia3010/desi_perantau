CREATE DATABASE IF NOT EXISTS `unclehouse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `unclehouse`;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(30) DEFAULT 'staff',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS suppliers;
CREATE TABLE suppliers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  contact VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS tb_bahan_baku;
CREATE TABLE tb_bahan_baku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(20) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) DEFAULT '',
  stok_awal INT DEFAULT 0,
  stok_akhir INT DEFAULT 0,
  pemakaian_per_minggu INT DEFAULT 0,
  harga DECIMAL(12,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS purchases;
CREATE TABLE purchases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bahan_id INT,
  supplier_id INT,
  qty INT,
  harga DECIMAL(12,2),
  tanggal DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (bahan_id) REFERENCES tb_bahan_baku(id) ON DELETE SET NULL,
  FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS usages;
CREATE TABLE usages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bahan_id INT,
  qty INT,
  tanggal DATE,
  note VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (bahan_id) REFERENCES tb_bahan_baku(id) ON DELETE SET NULL
);

DROP TABLE IF EXISTS tb_cluster_result;
CREATE TABLE tb_cluster_result (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bahan_id INT NOT NULL,
  cluster_label INT NOT NULL,
  distance_to_centroid DOUBLE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (bahan_id) REFERENCES tb_bahan_baku(id) ON DELETE CASCADE
);

-- sample admin user (password: admin123)
INSERT INTO users (name,email,password,role) VALUES
('Administrator','admin@example.com', '$2y$10$e0NRbG1qV1dQeVJqQ2Rr5e2JwQW5XbE1iYkZzZG1QeGQ5Z3Y3bTQy', 'admin');

INSERT INTO suppliers (name,contact) VALUES
('PT. Kopi Nusantara','081234567890'),
('CV. Gula Sejahtera','081298765432');

INSERT INTO tb_bahan_baku (kode,nama,kategori,stok_awal,stok_akhir,pemakaian_per_minggu,harga) VALUES
('B001','Tepung Terigu','Bahan Kue',100,30,70,8000),
('B002','Gula Pasir','Bahan Baku',120,50,70,9000),
('B003','Susu Bubuk','Susu',80,10,70,12000),
('B004','Coklat Bubuk','Topping',60,40,20,15000),
('B005','Ragi','Bahan Kue',40,5,35,5000),
('B006','Margarin','Bahan Kue',70,25,45,10000),
('B007','Telur','Bahan Baku',200,60,140,1500),
('B008','Keju','Topping',50,20,30,20000),
('B009','Essence Vanila','Aroma',30,10,20,25000),
('B010','Kopi Bubuk','Minuman',90,15,75,18000);

INSERT INTO purchases (bahan_id,supplier_id,qty,harga,tanggal) VALUES
(1,1,50,400000,'2025-10-01'),
(10,1,30,540000,'2025-10-03');

INSERT INTO usages (bahan_id,qty,tanggal,note) VALUES
(1,20,'2025-10-05','Produksi roti'),(10,10,'2025-10-06','Brew coffee');
