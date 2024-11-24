-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 04:33 PM
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
(1, 1, 'GST', 100.00),
(2, 1, 'TOLL', 1585.00),
(3, 1, 'driver allows ', 25478.00);

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
(1, 1, 'pant', 100, 100.00, 1254.00, 125400.00),
(2, 1, 'shirts ', 1254, 558.00, 5525.00, 6928350.00);

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
  `Vehicleno` int(255) NOT NULL,
  `DriverName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Status`, `order_name`, `customer_name`, `order_date`, `fromLocation`, `toLocation`, `transportMode`, `paidBy`, `taxPaidBy`, `pickupAddress`, `deliveryAddress`, `vehicletype`, `Vehiclecapacity`, `Vehicleno`, `DriverName`) VALUES
(1, 'Initiated', '2', '3', '2024-11-07', 'kon gaon', 'panvel', 'Air', 'Consignor', 'Consignor', 'back yard goodds near applolo tyres panvel', 'middle class society panvel', '2', ' 125478', 2220, 'Mayur shisave');

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gst` varchar(255) NOT NULL,
  `uh` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `name`, `gst`, `uh`, `contact`, `address`, `email`, `phone`, `created_at`) VALUES
(1, 'Sahil transport PVT LTD', '1125478955', '11233654', '8104678066', 'at kon post ajivali tel panvel', 'shritejmhatre.scipl@gmail.com', '09819740287', '2024-11-21 17:19:07'),
(2, 'shreeyash mhatre aa', '111111111111111111111', 'test', '9819740287', 'at kon post ajivali near to applolo tyres new panvel', 'Shreeyash@gmail.com', NULL, '2024-11-24 05:47:30'),
(3, 'Shritej mhatre', '1122554778963', 'a', '9833123247', 'middle class society type a building plot 10 panvel raigad 410206', 'a@gmail.com', NULL, '2024-11-24 07:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `vehicle_no` varchar(20) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_type`, `vehicle_no`, `capacity`) VALUES
(1, 'Truck', 'MH55-BC4545', 125000114),
(2, 'Pick-up', 'MH46MD7080', 22547),
(3, 'Other', 'MH58 BC 5058', 1478932585);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
