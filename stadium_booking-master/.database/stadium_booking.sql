-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 09:06 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stadium_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_ad` int(11) NOT NULL,
  `name_ad` varchar(25) NOT NULL DEFAULT 'admin',
  `uname_ad` varchar(50) NOT NULL,
  `pass_ad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_ad`, `name_ad`, `uname_ad`, `pass_ad`) VALUES
(1, 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_cm` int(11) NOT NULL,
  `idCode_cm` varchar(14) NOT NULL,
  `name_cm` varchar(50) NOT NULL,
  `lastname_cm` varchar(50) NOT NULL,
  `uname_cm` varchar(25) NOT NULL,
  `pass_cm` varchar(25) NOT NULL,
  `tel_cm` varchar(10) NOT NULL,
  `status_cm` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--


-- --------------------------------------------------------

--
-- Table structure for table `reserv_stadium`
--

CREATE TABLE `reserv_stadium` (
  `id_reserv` int(11) NOT NULL,
  `id_cm` int(11) NOT NULL,
  `id_stadium` int(11) NOT NULL,
  `quantity_reserv` int(5) NOT NULL,
  `date_reserv` date NOT NULL,
  `timeStart_reserv` time NOT NULL,
  `timeEnd_reserv` time NOT NULL,
  `createTime_reserv` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_reserv` int(3) NOT NULL DEFAULT 0 COMMENT '0 รอยืนยัน \r\n1 ยืนยันแล้ว\r\n2 เสร็จสิ้น\r\n',
  `priceHourSum_reserv` int(6) NOT NULL,
  `sumHour_reserv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserv_stadium`
--

-- --------------------------------------------------------

--
-- Table structure for table `stadium`
--

CREATE TABLE `stadium` (
  `id_stadium` int(11) NOT NULL,
  `name_stadium` varchar(50) NOT NULL,
  `details_stadium` text NOT NULL,
  `status_stadium` int(2) NOT NULL DEFAULT 1 COMMENT ' 1 = พร้อม 2 ไม่พร้อม',
  `img_stadium` varchar(100) DEFAULT NULL,
  `quantity_stadium` int(5) NOT NULL DEFAULT 1 COMMENT 'จำนวนคนที่รองรับ',
  `priceHour_stadium` int(5) NOT NULL COMMENT 'ราคาใช้สนาม/ชม.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stadium`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_ad`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_cm`);

--
-- Indexes for table `reserv_stadium`
--
ALTER TABLE `reserv_stadium`
  ADD PRIMARY KEY (`id_reserv`),
  ADD KEY `a` (`id_cm`),
  ADD KEY `b` (`id_stadium`);

--
-- Indexes for table `stadium`
--
ALTER TABLE `stadium`
  ADD PRIMARY KEY (`id_stadium`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_ad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_cm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `reserv_stadium`
--
ALTER TABLE `reserv_stadium`
  MODIFY `id_reserv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `stadium`
--
ALTER TABLE `stadium`
  MODIFY `id_stadium` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reserv_stadium`
--
ALTER TABLE `reserv_stadium`
  ADD CONSTRAINT `a` FOREIGN KEY (`id_cm`) REFERENCES `customer` (`id_cm`),
  ADD CONSTRAINT `b` FOREIGN KEY (`id_stadium`) REFERENCES `stadium` (`id_stadium`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
