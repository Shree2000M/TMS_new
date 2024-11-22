-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 04:03 PM
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
-- Database: `transportdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `charges`
--

CREATE TABLE `charges` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `charge_name` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charges`
--

INSERT INTO `charges` (`id`, `order_id`, `charge_name`, `amount`) VALUES
(1, 1, 'gst', 100.00),
(2, 1, 'cgst', 1250.00),
(3, 2, 'gst', 100.00),
(4, 2, 'cgst', 1250.00),
(5, 3, 'gst', 100.00),
(6, 3, 'cgst', 1250.00),
(7, 4, 'gst', 100.00),
(8, 4, 'cgst', 1250.00),
(9, 5, 'gst', 100.00),
(10, 5, 'cgst', 1250.00),
(11, 6, 'gst', 100.00),
(12, 6, 'toll', 500.00),
(13, 7, 'gst', 100.00),
(14, 7, 'toll', 500.00),
(15, 8, 'gst', 100.00),
(16, 8, 'toll', 500.00),
(17, 9, 'gst', 2580.00),
(18, 9, 'add on charge', 2578.00),
(19, 10, 'gst', 100.00),
(20, 10, 'toll', 500.00),
(21, 11, 'gst', 100.00),
(22, 11, 'toll', 500.00),
(23, 12, 'gst', 5240.00),
(24, 12, 'add on toll', 2547.00),
(25, 13, 'a', 1.00),
(26, 14, 'a', 1.00),
(27, 15, 'GSTa', 0.00),
(28, 15, 'TOLLa', 0.00),
(29, 16, 'GST', 100.00),
(30, 16, 'TOLL', 5580.00),
(31, 17, 'c', 1.00),
(32, 18, 'a1', 1.00),
(33, 19, 'c', 1.00),
(34, 19, 's', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `order_id`, `item_name`, `quantity`, `weight`, `rate`, `amount`) VALUES
(1, 1, 'a', 2, 10.00, 15.00, 30.00),
(2, 1, 'b', 14, 200.00, 1245.00, 17430.00),
(3, 2, 'a', 2, 10.00, 15.00, 30.00),
(4, 2, 'b', 14, 200.00, 1245.00, 17430.00),
(5, 3, 'a', 2, 10.00, 15.00, 30.00),
(6, 3, 'b', 14, 200.00, 1245.00, 17430.00),
(7, 4, 'a', 2, 10.00, 15.00, 30.00),
(8, 4, 'b', 14, 200.00, 1245.00, 17430.00),
(9, 5, 'a', 2, 10.00, 15.00, 30.00),
(10, 5, 'b', 14, 200.00, 1245.00, 17430.00),
(11, 6, 'pabt', 10, 200.00, 258.00, 2580.00),
(12, 6, 'shirt', 58, 547.00, 258.00, 14964.00),
(13, 7, 'pabt', 10, 200.00, 258.00, 2580.00),
(14, 7, 'shirt', 58, 547.00, 258.00, 14964.00),
(15, 8, 'pabt', 10, 200.00, 258.00, 2580.00),
(16, 8, 'shirt', 58, 547.00, 258.00, 14964.00),
(17, 9, 'a', 1, 1.00, 1.00, 1.00),
(18, 9, 'b', 1, 1.00, 1.00, 1.00),
(19, 10, 'pabt', 10, 200.00, 258.00, 2580.00),
(20, 10, 'shirt', 58, 547.00, 258.00, 14964.00),
(21, 11, 'pabt', 10, 200.00, 258.00, 2580.00),
(22, 11, 'shirt', 58, 547.00, 258.00, 14964.00),
(23, 12, 'pant', 20, 200.00, 15.00, 300.00),
(24, 12, 'shirts', 500, 254.00, 3.00, 1500.00),
(25, 13, 'a', 1, 1.00, 1.00, 1.00),
(26, 14, 'a', 1, 1.00, 1.00, 1.00),
(27, 15, 'pant a', 1254, 2000.00, 1450.00, 0.00),
(28, 15, 'shirtsa', 2547, 500.00, 1350.00, 0.00),
(29, 16, 'pant', 1254, 2000.00, 1450.00, 1818300.00),
(30, 16, 'shirts', 2547, 500.00, 1350.00, 3438450.00),
(31, 17, 'a111', 1, 1.00, 1.00, 1.00),
(32, 17, 'c', 1, 1.00, 1.00, 1.00),
(33, 18, 'a1', 1, 1.00, 1.00, 1.00),
(34, 18, 'b1', 5, 5.00, 5.00, 25.00),
(35, 19, '123', 1, 1.00, 1.00, 1.00),
(36, 19, 'a1', 1, 12.00, 12.00, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `fromLocation` varchar(255) NOT NULL,
  `toLocation` varchar(255) NOT NULL,
  `transportMode` varchar(255) NOT NULL,
  `paidBy` varchar(255) NOT NULL,
  `taxPaidBy` varchar(255) NOT NULL,
  `pickupAddress` varchar(255) NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  `vehicletype` varchar(255) NOT NULL,
  `Vehiclecapacity` varchar(255) NOT NULL,
  `Vehicleno` varchar(255) NOT NULL,
  `DriverName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Status`, `order_name`, `customer_name`, `order_date`, `fromLocation`, `toLocation`, `transportMode`, `paidBy`, `taxPaidBy`, `pickupAddress`, `deliveryAddress`, `vehicletype`, `Vehiclecapacity`, `Vehicleno`, `DriverName`) VALUES
(1, 'Paid', 'shritej', 'mhatre', '2024-11-07', '', '0', '', '', '', '', '', '', '', '', ''),
(2, '', 'shritej', 'mhatre', '2024-11-07', '', '0', '', '', '', '', '', '', '', '', ''),
(3, '', 'shritej', 'mhatre', '2024-11-07', 'from', 'to', '', '', '', '', '', '', '', '', ''),
(4, '', 'shritej', 'mhatre', '2024-11-07', 'aaa', 'bbb', 'Road', 'Consignee', 'Consignee', '', '', '', '', '', ''),
(5, '', 'shritej', 'mhatre', '2024-11-07', 'from loc', 'to loc', 'Road', 'Consignor', 'Consignor', 'pixk', 'drop', '', '', '', ''),
(6, '', 'shritej', 'krupesh', '2024-11-08', 'panvel', 'pune', 'Air', 'Consignor', 'Consignee', 'panvel', 'turbhe', '', '', '', ''),
(7, '', 'shritej', 'krupesh', '2024-11-08', 'panvel', 'pune', 'Air', 'Consignor', 'Consignee', 'panvel', 'turbhe', '', '', '', ''),
(8, '', 'shritej', 'krupesh', '2024-11-08', 'panvel', 'pune', 'Air', 'Consignor', 'Consignee', 'panvel', 'turbhe', '', '', '', ''),
(9, '', 'test', 't', '2024-11-02', 't', 't', 'Road', 'Third Party', 'Consignor', 't', 't', '', '', '', ''),
(10, '', 'shritej', 'krupesh', '2024-11-08', 'panvel', 'pune', 'Air', 'Consignor', 'Consignee', 'panvel', 'turbhe', '', '', '', ''),
(11, 'Initiated', 'shritej', 'krupesh', '2024-11-20', 'panvel', 'pune', 'Air', 'Consignor', 'Consignee', 'panvel', 'turbhe', '', '', '', ''),
(12, 'Initiated', 'kushal', 'rushabh', '2024-11-21', 'panvel', 'mumbai', 'Road', 'Consignor', 'Consignor', 'yogeshwar krupa co op society panvel', 'bkc bandra . mumbai', 'Road', ' 2000TN', ' MH 46 BC 1910', 'santosh mishra'),
(13, 'Initiated', 'a', 'a', '2024-11-07', 'a', 'a', 'Air', 'Consignee', 'Consignor', 'pune', 'a', 'Road', ' a', ' a', 'a'),
(14, 'Initiated', 'a', 'a', '2024-10-30', 'a', 'a', 'Road', 'Consignor', 'Consignor', 'a', 'a', 'Air', ' a', ' a', 'a'),
(15, 'Paid', 'shree sai krupa enter prizes a', 'shree govinda infra pvt ltd', '2024-11-08', 'kon gaon', 'panvel', 'Road', 'Consignor', 'Consignee', 'plot no 152, near police station kon gaon panvel raigad 410206', 'radha chauk thana naka , near taluk office panvel raigad 410206', 'Road', ' 125880', ' MH46 BC 410206', 'santosh kumar sharma'),
(16, 'Paid', 'shree sai krupa enter prizes', 'shree govinda infra pvt ltd', '2024-11-21', 'kon gaon', 'panvel', 'Road', 'Consignor', 'Consignee', 'plot no 152, near police station kon gaon panvel raigad 410206', 'radha chauk thana naka , near taluk office panvel raigad 410206', 'Road', ' 125880', ' MH46 BC 410206', 'santosh kumar sharma'),
(17, 'Initiated', '2', 'a', '2024-11-15', '1', '1', 'Air', 'Consignor', 'Consignor', 'a', '1', 'Road', ' 254', ' 4', '111'),
(18, 'Initiated', '3', '2', '2024-11-10', 'PANVEL', 'mumbai', 'Air', 'Consignee', 'Consignor', 'amravati', 'alibag', 'Road', ' 100', ' MH46500', '124'),
(19, 'Bill Pending', '2', '2', '2024-11-16', 'PANVEL', 'MUMBAI', 'Air', 'Consignee', 'Consignee', 'a', 'a', '2', ' 12', ' 12355', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `gst` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `uh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `contact`, `address`, `gst`, `email`, `uh`) VALUES
(2, 'mrunal a', '9819740287', 'test', '1111111111111111', 'billing.panvelmc@gmaaaaaaaaaaail.com', 'a'),
(3, 'jayesh', '9819740287', 'testing b', '111111111111111', 'a@gmail.com', 'a'),
(4, 'rupesh', '9819740287', 's', '111111111111', 'Shree@gmail.com', '1112'),
(5, 'bhairav', '9819740287', 'aaa kontact', '564664646464646', 'billing.panvelmc@gmail.com', 'aaa'),
(6, 'krupesh', '855478855', 'nerul', '1122334466778899', 'Shreesssss@gmail.com', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `capacity` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_type`, `vehicle_no`, `capacity`) VALUES
(1, 'Truck', 'MH465584', 45.00),
(2, 'Pick-up', 'MH43 115a45', 5584.00),
(3, 'Truck', '55879', 55.00),
(4, 'Bus', 'krupesh', 5898.00),
(5, 'Bus', '5', 99999999.00),
(7, 'Truck', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', 5.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_no` (`vehicle_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charges`
--
ALTER TABLE `charges`
  ADD CONSTRAINT `charges_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
