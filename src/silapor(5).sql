-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 10:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `silapor`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_history`
--

CREATE TABLE `detail_history` (
  `id` int(11) NOT NULL,
  `id_history` int(11) DEFAULT NULL,
  `status` enum('Diproses','Selesai','') DEFAULT NULL,
  `pengumuman` enum('aktif','tidak aktif') DEFAULT NULL,
  `komentar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_history`
--

INSERT INTO `detail_history` (`id`, `id_history`, `status`, `pengumuman`, `komentar`) VALUES
(7, 17, 'Diproses', 'aktif', 'yaaaaa'),
(0, 0, 'Selesai', NULL, 'SELESAI'),
(0, 16, 'Selesai', 'aktif', 'Terimakasih telah melapor!');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_pengaduan` int(10) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `npm` varchar(30) DEFAULT NULL,
  `kontak` varchar(30) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `pelaku` varchar(100) DEFAULT NULL,
  `tindak_lanjut` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `kategori` enum('akademik','ppks','sarana') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id_pengaduan`, `user_id`, `nama`, `npm`, `kontak`, `judul`, `deskripsi`, `lokasi`, `tanggal`, `pelaku`, `tindak_lanjut`, `bukti`, `kategori`, `created_at`) VALUES
(16, 45, 'Erlin', '2310631250101', '081389521365', 'Ac', 'Ac pada ruangan lab.lanjut 2 tidak dingin, akan dingin ketika saat hujan saja', 'Lab.Lanjut 2', NULL, NULL, NULL, '1748068984_AC LABLANJUT 2.jpg', 'sarana', '2025-05-24 06:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `inputuser`
--

CREATE TABLE `inputuser` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inputuser`
--

INSERT INTO `inputuser` (`id`, `username`, `email`, `level`) VALUES
(3, 'Raka', 'raka@gmail.com', 'admin'),
(7, 'Rafly', 'dwi@gmail.com', 'user'),
(45, 'Erlin', 'erlin@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) DEFAULT NULL,
  `id_history` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` enum('Diproses','Selesai') NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `id_history`, `judul`, `kategori`, `tanggal`, `status`, `komentar`, `bukti`) VALUES
(0, 16, 'Ac', 'sarana', '2025-05-24 13:43:04', 'Selesai', 'Terimakasih telah melapor!', '1748068984_AC LABLANJUT 2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `setting_akun`
--

CREATE TABLE `setting_akun` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `npm` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting_akun`
--

INSERT INTO `setting_akun` (`id`, `user_id`, `username`, `email`, `password`, `full_name`, `department`, `npm`) VALUES
(1, 0, 'Fariz', 'ulfariz@gmail.com', '2222', 'Ditha Alfariz', 'Sistem Informasi', '2310631250'),
(2, 3, 'Raka', 'raka@gmail.com', '3333', '', '', ''),
(3, 7, 'Rafly', 'dwi@gmail.com', '2323', 'Flyyy', 'Sistem Informasi', '212121'),
(4, 4, 'Admin', 'admin@123', '123', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `table_user`
--

CREATE TABLE `table_user` (
  `id` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `tgl_isi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_user`
--

INSERT INTO `table_user` (`id`, `username`, `email`, `password`, `tgl_isi`, `role`) VALUES
(0, 'Fariz', 'ulfariz@gmail.com', '2222', '2025-05-23 11:23:41', 'mahasiswa'),
(1, 'Admin2', 'admin@321', '321', '2025-05-23 17:31:29', 'admin'),
(3, 'Raka', 'raka@gmail.com', '3333', '2025-05-18 18:11:33', ''),
(4, 'Admin', 'admin@123', '123', '2025-05-23 17:09:33', 'admin'),
(7, 'Rafly', 'dwi@gmail.com', '2323', '2025-05-24 06:39:10', 'mahasiswa'),
(34, 'raka', 'putra@gmail.com', '3333', '2025-05-23 17:07:18', 'mahasiswa'),
(45, 'Erlin', 'erlin@gmail.com', '1111', '2025-05-24 06:39:17', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_pengaduan`);

--
-- Indexes for table `inputuser`
--
ALTER TABLE `inputuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `setting_akun`
--
ALTER TABLE `setting_akun`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_pengaduan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `setting_akun`
--
ALTER TABLE `setting_akun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `setting_akun`
--
ALTER TABLE `setting_akun`
  ADD CONSTRAINT `setting_akun_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `table_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
