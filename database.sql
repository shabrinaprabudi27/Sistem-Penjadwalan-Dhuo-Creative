CREATE DATABASE IF NOT EXISTS dhuo_schedule CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE dhuo_schedule;

CREATE TABLE IF NOT EXISTS user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('superadmin','admin') NOT NULL DEFAULT 'admin'
);

CREATE TABLE IF NOT EXISTS siswa (
  siswa_id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(120) NOT NULL,
  no_hp VARCHAR(30) NULL,
  alamat VARCHAR(200) NULL,
  kursus VARCHAR(80) NOT NULL
);

CREATE TABLE IF NOT EXISTS staff (
  staff_id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(120) NOT NULL,
  no_hp VARCHAR(30) NULL,
  alamat VARCHAR(200) NULL,
  kursus VARCHAR(80) NULL
);

CREATE TABLE IF NOT EXISTS meja (
  meja_id INT AUTO_INCREMENT PRIMARY KEY,
  nomor_meja VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS ruangan (
  ruangan_id INT AUTO_INCREMENT PRIMARY KEY,
  nomor_ruangan VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS jadwal (
  jadwal_id INT AUTO_INCREMENT PRIMARY KEY,
  hari VARCHAR(20) NOT NULL,
  jam VARCHAR(20) NOT NULL,
  siswa_id INT NOT NULL,
  staff_id INT NOT NULL,
  meja_id INT NOT NULL,
  ruangan_id INT NOT NULL,
  CONSTRAINT fk_j_siswa FOREIGN KEY (siswa_id) REFERENCES siswa(siswa_id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_j_staff FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_j_meja FOREIGN KEY (meja_id) REFERENCES meja(meja_id) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_j_ruangan FOREIGN KEY (ruangan_id) REFERENCES ruangan(ruangan_id) ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO user (username, nama, password_hash, role) VALUES
('superadmin', 'Superadmin', '$2y$10$MoGcdz.ReozVLeBZTK3fhuIr067SYEN83ERGYKoOoiMhpCJCISW6W', 'superadmin'),
('admin', 'Admin', '$2y$10$MoGcdz.ReozVLeBZTK3fhuIr067SYEN83ERGYKoOoiMhpCJCISW6W', 'admin')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO siswa (nama, no_hp, alamat, kursus) VALUES
('Ayu','085221524569','Medan','Design'),
('Rizky','082134579082','Selayang','Programming'),
('Nadia','082134642134','Tuntungan','Ms Office')
ON DUPLICATE KEY UPDATE nama=nama;

INSERT INTO staff (nama, no_hp) VALUES
('Bang Dodi','081234567890'),
('Kak Sari','081355555555'),
('Bang Roni','081366666666')
ON DUPLICATE KEY UPDATE nama=nama;

INSERT INTO meja (nomor_meja) VALUES ('M-01'),('M-02'),('M-03')
ON DUPLICATE KEY UPDATE nomor_meja=nomor_meja;

INSERT INTO ruangan (nomor_ruangan) VALUES ('R-01'),('R-02')
ON DUPLICATE KEY UPDATE nomor_ruangan=nomor_ruangan;
