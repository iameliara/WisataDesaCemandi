-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2024 at 08:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengaduan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kunjungan`
--

INSERT INTO `kunjungan` (`id`, `timestamp`) VALUES
(1, '2024-06-16 01:03:48'),
(2, '2024-06-16 01:05:01'),
(3, '2024-06-16 01:07:25'),
(4, '2024-06-16 01:09:44'),
(5, '2024-06-16 01:11:14'),
(6, '2024-06-15 12:34:56'),
(7, '2024-06-15 13:47:11'),
(8, '2024-06-15 14:05:23'),
(9, '2024-06-16 09:21:34'),
(10, '2024-06-16 10:42:51'),
(11, '2024-06-16 11:33:07'),
(12, '2024-06-17 08:12:44'),
(13, '2024-06-17 09:50:28'),
(14, '2024-06-17 10:15:39'),
(15, '2024-06-18 07:45:33'),
(16, '2024-06-18 08:57:12'),
(17, '2024-06-18 09:48:05'),
(18, '2024-06-16 01:13:07'),
(19, '2024-06-16 01:17:06'),
(20, '2024-06-16 01:18:35'),
(21, '2024-06-16 01:21:03'),
(22, '2024-06-16 01:24:34'),
(23, '2024-06-16 01:26:40'),
(24, '2024-06-16 01:27:44'),
(25, '2024-06-16 01:29:29'),
(26, '2024-06-16 01:33:05'),
(27, '2024-06-16 01:35:03'),
(28, '2024-06-16 01:37:30'),
(29, '2024-06-16 01:37:34'),
(30, '2024-06-16 01:39:42'),
(31, '2024-06-16 01:40:25'),
(32, '2024-06-16 13:43:56'),
(33, '2024-06-16 13:45:27'),
(34, '2024-06-16 13:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomorhp` varchar(15) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `pesan` text NOT NULL,
  `terima_email` tinyint(1) NOT NULL,
  `terima_sms` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `nama`, `nik`, `email`, `nomorhp`, `kategori`, `pesan`, `terima_email`, `terima_sms`, `created_at`) VALUES
(1, 'John Doe', '1234567890123456', 'john@example.com', '081234567890', 'Pelayanan', 'Pesan keluhan.', 1, 0, '2024-06-16 13:41:19'),
(2, 'Jane Doe', '6543210987654321', 'jane@example.com', '081234567891', 'Produk', 'Pesan saran.', 0, 1, '2024-06-16 13:41:19'),
(3, 'Alice Smith', '7890123456789012', 'alice@example.com', '081234567892', 'Pelayanan', 'Pesan komplain.', 1, 1, '2024-06-16 13:45:19'),
(4, 'Bob Johnson', '8901234567890123', 'bob@example.com', '081234567893', 'Lainnya', 'Pesan pertanyaan.', 0, 0, '2024-06-16 13:45:19'),
(5, 'Charlie Brown', '9012345678901234', 'charlie@example.com', '081234567894', 'Pelayanan', 'Pesan permintaan.', 1, 0, '2024-06-16 13:45:19'),
(6, 'David Wilson', '0123456789012345', 'david@example.com', '081234567895', 'Produk', 'Pesan keluhan lainnya.', 0, 1, '2024-06-16 13:45:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
