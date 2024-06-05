-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 06:47 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_makeup`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID_Kategori` int(11) NOT NULL,
  `Kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID_Kategori`, `Kategori`) VALUES
(1, 'Makeup'),
(2, 'Skincare'),
(3, 'Haircare');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `ID_Produk` int(11) NOT NULL,
  `Nama_Produk` varchar(100) NOT NULL,
  `Merek` varchar(50) NOT NULL,
  `Kategori` varchar(50) NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int(11) NOT NULL,
  `Tanggal_Kadaluarsa` date DEFAULT NULL,
  `Bahan` text,
  `Ukuran` varchar(50) DEFAULT NULL,
  `Rating` decimal(3,2) DEFAULT NULL,
  `Sertifikasi` text,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`ID_Produk`, `Nama_Produk`, `Merek`, `Kategori`, `Harga`, `Stok`, `Tanggal_Kadaluarsa`, `Bahan`, `Ukuran`, `Rating`, `Sertifikasi`, `created_at`, `deleted_at`, `updated_at`) VALUES
(7, 'cushion', 'OMG', '3', '70000.00', 60, '2024-07-04', 'dddddddddddd', '15', '4.90', 'hhll', '2024-06-03 08:54:37', '2024-06-04 22:33:00', '2024-06-03 13:25:33'),
(8, 'cushion', 'focallure', '1', '70000.00', 90, '0000-00-00', 'bb cream ', '100', '4.00', 'bpom', '2024-06-03 09:57:04', '2024-06-03 17:20:37', NULL),
(10, 'foundation', 'makeover', '1', '150000.00', 15, '2024-07-05', 'cream', '100', '4.40', 'bpom', '2024-06-03 12:10:17', '2024-06-03 17:20:32', NULL),
(12, 'Foundation', 'BrandB', '2', '100.00', 50, '2023-06-30', 'Ingredients2', 'Large', '4.00', 'CertifiedB', NULL, '2024-06-04 22:32:56', NULL),
(24, 'onyx', 'purbasari', '3', '30000.00', 60, '2024-07-05', 'olive oil', '65', '4.00', 'bpom', '2024-06-04 17:32:46', NULL, NULL),
(25, 'onyx', 'purbasari', '3', '30000.00', 60, '2024-06-28', 'olive oil', '65', '4.00', 'bpom', '2024-06-04 17:39:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_Transaksi` int(11) NOT NULL,
  `ID_Produk` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Total_Price` decimal(10,2) DEFAULT NULL,
  `Transaction_Date` datetime DEFAULT NULL,
  `Customer_Name` varchar(255) DEFAULT NULL,
  `Customer_Email` varchar(255) DEFAULT NULL,
  `Customer_Address` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`ID_Transaksi`, `ID_Produk`, `Quantity`, `Total_Price`, `Transaction_Date`, `Customer_Name`, `Customer_Email`, `Customer_Address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 12, 2, '49000.00', '2024-06-19 00:00:00', 'zizi', 'zizi@gmail.com', 'jl brata 2 no 9 jakarta', '2024-06-04 09:19:48', '2024-06-04 09:20:19', NULL),
(2, 7, NULL, '300000.00', '2024-06-21 00:00:00', 'zihwa', 'zahrelzahleta@gmail.com', 'jkasel', '2024-06-04 06:09:07', '2024-06-04 11:14:46', '2024-06-04 11:14:46'),
(3, 8, NULL, '300000.00', '2024-07-03 00:00:00', 'schwa', 'zizigmail@co.id', 'jakarta', '2024-06-04 06:23:48', '2024-06-04 11:23:48', NULL),
(4, 10, NULL, '550000.00', '2024-07-02 00:00:00', 'zihwa', 'zahrelzahleta@gmail.com', 'jkasel', '2024-06-04 06:34:14', '2024-06-04 11:34:14', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID_Kategori`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ID_Produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_Transaksi`),
  ADD KEY `ID_Produk` (`ID_Produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID_Kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `ID_Produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `ID_Transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`ID_Produk`) REFERENCES `produk` (`ID_Produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
