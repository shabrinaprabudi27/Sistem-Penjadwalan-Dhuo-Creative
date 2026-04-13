-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 06:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhuo_schedule`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `jadwal_id` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `meja_id` int(11) NOT NULL,
  `ruangan_id` int(11) NOT NULL,
  `status` enum('aktif','selesai','batal') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `hari`, `tanggal`, `jam_mulai`, `jam_selesai`, `siswa_id`, `staff_id`, `meja_id`, `ruangan_id`, `status`) VALUES
(1, 'Senin', '2026-04-13', '09:00:00', '10:30:00', 1, 2, 1, 1, 'aktif'),
(2, 'Rabu', '2026-04-15', '09:00:00', '10:30:00', 1, 2, 2, 1, 'aktif'),
(3, 'Senin', '2026-04-13', '10:30:00', '12:00:00', 2, 1, 1, 1, 'aktif'),
(4, 'Kamis', '2026-04-16', '13:00:00', '14:30:00', 2, 1, 2, 2, 'aktif'),
(5, 'Selasa', '2026-04-14', '09:00:00', '10:30:00', 3, 3, 3, 2, 'aktif'),
(6, 'Jumat', '2026-04-17', '10:30:00', '12:00:00', 3, 3, 1, 2, 'aktif'),
(7, 'Senin', '2026-04-13', '09:00:00', '11:00:00', 9, 1, 2, 2, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `meja_id` int(11) NOT NULL,
  `nomor_meja` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`meja_id`, `nomor_meja`) VALUES
(1, 'M-01'),
(2, 'M-02'),
(3, 'M-03');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `ruangan_id` int(11) NOT NULL,
  `nomor_ruangan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`ruangan_id`, `nomor_ruangan`) VALUES
(1, 'R-01'),
(2, 'R-02');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `siswa_id` int(11) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `kursus` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`siswa_id`, `nama`, `no_hp`, `alamat`, `kursus`) VALUES
(1, 'Ayu', '085221524569', 'Medan', 'Design'),
(2, 'Rizky', '082134579082', 'Selayang', 'Programming'),
(3, 'Nadia', '082134642134', 'Tuntungan', 'Ms Office'),
(4, 'Jessica', '081249562552', NULL, 'Social Media Marketing'),
(5, 'Rico Kosasih', '081249565874', NULL, 'Design Master'),
(6, 'Rido', '081285264986', NULL, 'Programming Master'),
(7, 'Putri', '085298642352', NULL, 'Programming Master'),
(8, 'Rina', '0813698725632', NULL, 'Design Master'),
(9, 'Rindana', '', NULL, 'Programming Master'),
(10, 'Rizky Rinjani', '', NULL, 'Design Master'),
(11, 'Windari Ahmad', '', NULL, 'Programming Master'),
(12, 'Wulandari', '', NULL, 'Social Media Marketing'),
(13, 'Rissa', '', NULL, 'Design Master'),
(14, 'Rina Arnali', '', NULL, 'Social Media Marketing'),
(15, 'Jeremi', '', NULL, 'Programming Master'),
(16, 'Patricia', '', NULL, 'Design Master');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `kursus` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `nama`, `no_hp`, `alamat`, `kursus`) VALUES
(1, 'Bang Dodi', '081234567890', NULL, NULL),
(2, 'Kak Sari', '081355555555', NULL, NULL),
(3, 'Bang Roni', '081366666666', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `nama`, `password_hash`, `role`) VALUES
(1, 'superadmin', 'Superadmin', '$2y$10$AirmBPwdUHcR6oPiW.tcP.Iyk1ACch8YAE.eBHJTdbHMuYApOlRI6', 'superadmin'),
(2, 'admin', 'Admin', '$2y$10$MoGcdz.ReozVLeBZTK3fhuIr067SYEN83ERGYKoOoiMhpCJCISW6W', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD KEY `fk_j_siswa` (`siswa_id`),
  ADD KEY `fk_j_staff` (`staff_id`),
  ADD KEY `fk_j_meja` (`meja_id`),
  ADD KEY `fk_j_ruangan` (`ruangan_id`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`meja_id`),
  ADD UNIQUE KEY `nomor_meja` (`nomor_meja`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`ruangan_id`),
  ADD UNIQUE KEY `nomor_ruangan` (`nomor_ruangan`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`siswa_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `jadwal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `meja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `ruangan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_j_meja` FOREIGN KEY (`meja_id`) REFERENCES `meja` (`meja_id`),
  ADD CONSTRAINT `fk_j_ruangan` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangan` (`ruangan_id`),
  ADD CONSTRAINT `fk_j_siswa` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`siswa_id`),
  ADD CONSTRAINT `fk_j_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
