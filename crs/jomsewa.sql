-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2020 at 04:02 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jomsewa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `matric_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `admin_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `matric_id`, `username`, `email`, `contact`, `password`, `type`, `status`, `admin_id`) VALUES
(8, 'Muhammad Hanif bin Azmi', 'CB17191', 'mhanifazmi', 'hanifazmi23@gmail.com', '01114199338', '$6$rounds=5000$jomsewa$5EfgylCBzLChvaHNRrQXj1pxWTewoI8fc58KTn7oULlgTaYD9.cQl6uLXXwmoFzqdKH.kFVB8YcFIrt1032Z6/', 1, 1, 'fc4a524d394d4251470058582da3e13f'),
(9, 'Khairul Syafiq', 'CB17100', 'ksya', 'ksya@gmail.com', '01234567890', '$6$rounds=5000$jomsewa$5EfgylCBzLChvaHNRrQXj1pxWTewoI8fc58KTn7oULlgTaYD9.cQl6uLXXwmoFzqdKH.kFVB8YcFIrt1032Z6/', 1, 1, '67d017bb7380c2c628d1ca01062a52e6'),
(10, 'Fariha ', 'CB17101', 'fariha', 'fariha@gmail.com', '01234567890', '$6$rounds=5000$jomsewa$5EfgylCBzLChvaHNRrQXj1pxWTewoI8fc58KTn7oULlgTaYD9.cQl6uLXXwmoFzqdKH.kFVB8YcFIrt1032Z6/', 1, 1, '3ac566df17ff2c033075b444c0b1a161'),
(11, 'Hafizah', 'CB17168', 'pijah', 'pijah@gmail.com', '01234567890', '$6$rounds=5000$jomsewa$5EfgylCBzLChvaHNRrQXj1pxWTewoI8fc58KTn7oULlgTaYD9.cQl6uLXXwmoFzqdKH.kFVB8YcFIrt1032Z6/', 1, 1, 'ccb4d8cdb1f04ac1f7088e13ab8a5d5b'),
(12, 'Kugan', 'CB17123', 'raj', 'raj@gmail.com', '01234567890', '$6$rounds=5000$jomsewa$5EfgylCBzLChvaHNRrQXj1pxWTewoI8fc58KTn7oULlgTaYD9.cQl6uLXXwmoFzqdKH.kFVB8YcFIrt1032Z6/', 1, 1, '65a1223dae83b8092c4edba0823a793c');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image` varchar(100) NOT NULL,
  `announcement` text NOT NULL,
  `datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `announcement_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `image`, `announcement`, `datetime`, `status`, `announcement_id`) VALUES
(12, 'Jom Sewa!', 'img/announcement/1596124436791aec1a7d68f962049689fb70a1b379.png', '<p>Mari la sewa dengan kami! murah dan padat!</p>', '2020-07-30 17:53:56', 1, 'e374ced98fac3370b09ea8f1b8a52d18');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `car_plat` varchar(100) NOT NULL,
  `car_model` varchar(100) NOT NULL,
  `transmission` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `car_id` varchar(100) NOT NULL,
  `admin_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `car_plat`, `car_model`, `transmission`, `color`, `status`, `car_id`, `admin_id`) VALUES
(6, 'JFU 2740', 'Myvi', 'auto', 'Black', 1, 'f6fbe07b011d218456bab7b65084f0b6', 'fc4a524d394d4251470058582da3e13f');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `driver_id` varchar(100) NOT NULL,
  `expiry` date NOT NULL,
  `nationality` int(11) NOT NULL,
  `licence_number` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `licence_copy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `driver_id`, `expiry`, `nationality`, `licence_number`, `status`, `licence_copy`) VALUES
(10, 'fc4a524d394d4251470058582da3e13f', '2022-04-23', 1, 'AB123123', 2, 'img/receipt/fc4a524d394d4251470058582da3e13f.pdf'),
(11, '3ac566df17ff2c033075b444c0b1a161', '2020-08-05', 1, 'A19321PP1232', 2, 'img/receipt/3ac566df17ff2c033075b444c0b1a161.pdf'),
(12, '65a1223dae83b8092c4edba0823a793c', '2023-06-21', 1, 'ABV1234123', 2, 'img/receipt/65a1223dae83b8092c4edba0823a793c.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `air_filter` int(11) NOT NULL,
  `windshield_wiper` int(11) NOT NULL,
  `spark_plug` int(11) NOT NULL,
  `oil_filter` int(11) NOT NULL,
  `battery` int(11) NOT NULL,
  `radiator_flush` int(11) NOT NULL,
  `brake_pads` int(11) NOT NULL,
  `fuel_filter` int(11) NOT NULL,
  `date` date NOT NULL,
  `maintenance_id` varchar(100) NOT NULL,
  `car_id` varchar(100) NOT NULL,
  `admin_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `file`, `air_filter`, `windshield_wiper`, `spark_plug`, `oil_filter`, `battery`, `radiator_flush`, `brake_pads`, `fuel_filter`, `date`, `maintenance_id`, `car_id`, `admin_id`) VALUES
(12, 'img/receipt/Assignment E-Learning Evolution Group 1F.pdf', 1, 1, 1, 1, 1, 1, 1, 1, '2020-07-23', '819197ceb178f5137d9ed24f2930d496', 'f6fbe07b011d218456bab7b65084f0b6', 'fc4a524d394d4251470058582da3e13f');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `admin_id` varchar(100) NOT NULL,
  `rating_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `star`, `admin_id`, `rating_id`) VALUES
(1, 3, '65a1223dae83b8092c4edba0823a793c', '1b60af2aad168fb10fc6ac54612a77f6'),
(2, 5, '65a1223dae83b8092c4edba0823a793c', '33e411dac1daf83a8568b985a78d60e3');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `style` int(11) NOT NULL,
  `logo` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `rent_price` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `style`, `logo`, `rate`, `rent_price`) VALUES
(1, 1, 0, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id` int(11) NOT NULL,
  `datetime_start` datetime NOT NULL,
  `hour` int(11) NOT NULL,
  `datetime_end` datetime NOT NULL,
  `car_id` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `owner_id` varchar(100) NOT NULL,
  `sewa_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id`, `datetime_start`, `hour`, `datetime_end`, `car_id`, `status`, `customer_id`, `owner_id`, `sewa_id`) VALUES
(21, '2020-08-08 04:19:00', 5, '2020-08-08 09:19:00', 'f6fbe07b011d218456bab7b65084f0b6', 0, '67d017bb7380c2c628d1ca01062a52e6', 'fc4a524d394d4251470058582da3e13f', '734840b8bd69ef93ffa41d2f39a5af27');

-- --------------------------------------------------------

--
-- Table structure for table `taxi`
--

CREATE TABLE `taxi` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `pickup` varchar(200) NOT NULL,
  `destination` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `distance` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `point` varchar(100) NOT NULL,
  `driver_id` varchar(100) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `taxi_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taxi`
--

INSERT INTO `taxi` (`id`, `datetime`, `pickup`, `destination`, `status`, `customer_id`, `distance`, `amount`, `point`, `driver_id`, `payment_type`, `taxi_id`) VALUES
(6, '2020-08-05 06:00:00', 'Lorong Gambang Makmur 2, Kampung Melayu Gambang, Gambang, Pahang, Malaysia', 'UMP Gambang Campus, Kampung Melayu Gambang, Gambang, Pahang, Malaysia', 2, '67d017bb7380c2c628d1ca01062a52e6', '6', '6', '2', '65a1223dae83b8092c4edba0823a793c', 0, 'a14f1a37498f3895ead4e99630430755'),
(7, '2020-07-10 09:30:00', 'UMP Gambang Campus, Kampung Melayu Gambang, Gambang, Pahang, Malaysia', 'Jalan Gambang Damai 1, Kampung Pohoi, Gambang, Pahang, Malaysia', 2, 'fc4a524d394d4251470058582da3e13f', '11', '11', '2', '65a1223dae83b8092c4edba0823a793c', 0, '74aa44bc51c0d98d00994aedc0add798');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `wallet_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `balance`, `user_id`, `type`, `wallet_id`) VALUES
(4, '13', 'fc4a524d394d4251470058582da3e13f', 1, 'c00f9a0b81161d8dc9ab99d233a98c21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxi`
--
ALTER TABLE `taxi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `taxi`
--
ALTER TABLE `taxi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
