-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 07:24 PM
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
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `rate2` int(11) DEFAULT NULL,
  `rate3` int(11) DEFAULT NULL,
  `rate4` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `orderid`, `rate`, `rate2`, `rate3`, `rate4`) VALUES
(2, 600, 600, 6100, 8200, 9500),
(3, 34, 600, 6100, 8200, 9500),
(4, 37, 600, NULL, NULL, NULL),
(5, 42, 9500, 6100, 8200, 9500),
(6, 43, 6100, 6100, 8200, 9500),
(7, 44, 8200, NULL, NULL, NULL);

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
(3, 1, 'driver allows ', 25478.00),
(4, 2, 'GST', 100.00),
(5, 2, 'Toll', 500.00),
(6, 2, 'Driver Bhatta', 1254.00),
(7, 3, 'GST', 100.00),
(8, 3, 'Toll', 258.00),
(9, 4, 's', 12313.00),
(10, 5, 'a', 5.00),
(11, 6, 'a', 5464.00),
(12, 7, 'gts65495', 464.00),
(13, 8, 'aaa', 11.00),
(14, 9, 'gst', 5587.00),
(15, 9, 'traxpp', 4445.00),
(16, 10, 'gts', 11631.00),
(17, 11, 'ss', 121.00),
(18, 12, 'a', 1313.00),
(19, 13, 'a', 1.00),
(20, 14, 'a', 1.00),
(21, 15, 's', 1.00),
(22, 16, 's', 1.00),
(23, 17, 'a', 131.00),
(24, 18, 'gst', 65166.00),
(25, 19, 'S', 121.00),
(26, 20, 'GST', 211.00),
(27, 21, 'A', 1.00),
(28, 22, 'S', 1.00),
(29, 23, 'GST', 1313.00),
(30, 24, 'GST', 231313.00),
(31, 25, 'GST', 1113.00),
(32, 26, 'GST', 454.00),
(33, 26, 'ADD ON ', 12.00),
(34, 27, 'GST', 100.00),
(35, 27, 'TOLL', 12454.00),
(36, 28, 's', 121.00),
(37, 31, 's', 121.00),
(38, 33, 's', 454.00),
(39, 34, 'ss', 1313.00),
(40, 37, 'ssaa', 13.00),
(41, 42, 'sss', 21213.00),
(42, 43, 's', 21212.00),
(43, 44, 'a', 121.00),
(44, 44, 'abse', 121.00);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `parceltype` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `itemtax` varchar(255) NOT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `order_id`, `item_name`, `parceltype`, `quantity`, `weight`, `itemtax`, `rate`, `amount`) VALUES
(1, 1, 'pant', '', 100, 100.00, '', 1254.00, 125400.00),
(2, 1, 'shirts ', '', 1254, 558.00, '', 5525.00, 6928350.00),
(3, 2, 'Wheels ', '', 500, 200.00, '', 28.00, 14000.00),
(4, 2, 'Tyres', '', 1024, 52.00, '', 22.00, 22528.00),
(5, 3, 'Laptops', '', 100, 250.00, '', 400.00, 40000.00),
(6, 3, 'printers', '', 50, 287.00, '', 254.00, 12700.00),
(7, 4, 'a', '', 1, 1.00, '', 1.00, 1.00),
(8, 4, 'a', '', 1, 1.00, '', 1.00, 1.00),
(9, 5, 'a', '', 5, 58.00, '', 5.00, 25.00),
(10, 6, 'a1', '', 1313, 131.00, '', 1.00, 1313.00),
(11, 7, 's', '', 2, 2.00, '', 2.00, 4.00),
(12, 7, 'test', '', 12313, 131.00, '', 313.00, 3853969.00),
(13, 8, 'lapto', 'Basta', 454, 454.00, '', 45.00, 20430.00),
(14, 9, 'sockets wire', 'Bag', 15254, 1154.00, '5% GST', 121.00, 1845734.00),
(15, 10, 'a', 'Box', 1, 1.00, '12% GST', 15.00, 15.00),
(16, 10, 'sss', 'Bag', 46546, 46464.00, '12% GST', 1.00, 46546.00),
(17, 11, 's', 'Box', 1, 1.00, '12% GST', 121.00, 121.00),
(18, 12, 'a', 'Pcs', 211, 161.00, '12% GST', 131.00, 27641.00),
(19, 13, 'a', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(20, 14, 'a', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(21, 15, 's', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(22, 16, 's', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(23, 17, 'lapto', 'Box', 1131, 13131.00, '12% GST', 1231.00, 1392261.00),
(24, 18, 'a', 'Box', 558, 55.00, '12% GST', 55.00, 30690.00),
(25, 19, 'A', 'Box', 11, 11.00, '12% GST', 121.00, 1331.00),
(26, 20, '555', 'Bundle', 1213, 31313.00, '12% GST', 1313.00, 1592669.00),
(27, 21, '613131', 'Box', 11, 465464.00, '12% GST', 211.00, 2321.00),
(28, 22, 'A', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(29, 23, '132131', 'Box', 1313, 13131.00, '12% GST', 131.00, 172003.00),
(30, 24, 'LAOP', 'Box', 1213, 1313.00, '12% GST', 123.00, 149199.00),
(31, 25, 'lapto', 'Basta', 1212, 13131.00, '12% GST', 131.00, 158772.00),
(32, 26, 'PANT', 'Box', 121, 12.00, '12% GST', 11.00, 1331.00),
(33, 26, 'SHIRT', 'Bundle', 121, 131.00, '12% GST', 1121.00, 135641.00),
(34, 27, 'PANT', 'Box', 100, 125587.00, '12% GST', 12154.00, 1215400.00),
(35, 27, 'SHIRT', 'Box', 100, 125.00, '12% GST', 1244.00, 124400.00),
(36, 28, 's', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(37, 31, 'lapto', 'Box', 1, 1.00, '12% GST', 1313.00, 1313.00),
(38, 33, 's', 'Box', 1, 1.00, '12% GST', 1.00, 1.00),
(39, 33, 'a', 'Box', 5, 1.00, '5% GST', 1212.00, 6060.00),
(40, 34, 's', 'Box', 1, 1.00, '12% GST', 123.00, 123.00),
(41, 37, 'a', 'Box', 1, 1.00, '12% GST', 121.00, 121.00),
(42, 42, 'a', 'Box', 1212, 3131.00, '12% GST', 313.00, 379356.00),
(43, 43, 'a', 'Box', 12212, 3100.00, '12% GST', 6.00, 73272.00),
(44, 44, 'abcd', 'Box', 1212, 6100.00, '12% GST', 13211.00, 16011732.00);

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
  `Vehicleno` int(255) NOT NULL,
  `DriverName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Status`, `order_name`, `customer_name`, `order_date`, `fromLocation`, `toLocation`, `transportMode`, `paidBy`, `taxPaidBy`, `pickupAddress`, `deliveryAddress`, `Vehicleno`, `DriverName`) VALUES
(1, 'Paid', '2', '3', '2024-11-07', 'kon gaon', 'panvel', 'Air', 'Consignor', 'Consignor', 'back yard goodds near applolo tyres panvel', 'middle class society panvel', 2220, 'Mayur shisave'),
(2, 'Paid', '1', '3', '2024-11-26', 'Adai', 'Panvel', '', 'Consignor', 'Consignor', 'Land mark society near adai New panvel bridge, New panvel ,Raigad 410206', 'Yogendra ho op housing society panvel , raigad 410206', 0, 'Somnath padekar'),
(3, 'Delivered', '4', '1', '2024-11-30', 'panvel', 'mumbai', 'Road', 'Consignee', 'Consignee', 'middle class society panvel raigad india 410206', 'bandra west mumbai india 410206', 1, 'nitesh shah'),
(4, 'Initiated', '1', '3', '2024-12-14', 'PANVEL', 'aa', 'Road', 'Consignor', 'Consignor', 'at ant', '4646464', 2, '777'),
(5, 'Initiated', '2', '1', '2024-12-13', 'a', 'a', 'Road', 'Consignor', 'Consignee', 'a', 'a', 3, 'a'),
(6, 'Initiated', '2', '1', '2024-12-13', 'a', 'a', 'Road', 'Consignor', 'Consignee', 'a', 'a', 3, 'a'),
(7, 'Paid', '2', '1', '2024-12-04', 't', 'aa', 'Road', 'Consignor', 'Consignor', 's', 's', 3, 's'),
(8, 'Delivered', '2', '4', '2024-12-12', 'a', 'a', 'Air', 'Consignor', 'Consignor', 'a', 'a', 1, 'a'),
(9, 'Initiated', '3', '4', '2024-12-02', 'panvel', 'pune', 'Road', 'Consignee', 'Consignee', 'test address', 'test address', 2, 'mayur dabhade'),
(10, 'Initiated', '1', '1', '2024-12-05', 'panvel', 'a', 'Air', 'Consignor', 'Consignor', 'a', 'a', 1, 'drivert tesrf'),
(11, 'Initiated', '5', '1', '2024-12-26', 's', 's', 'Air', 'Consignor', 'Consignor', 's', 's', 2, 's'),
(12, 'Initiated', '2', '3', '2024-12-14', 'panvel', 'a', 'Air', 'Consignor', 'Consignor', 'a', 'a', 2, 'a'),
(13, 'Initiated', '2', '3', '2024-12-11', 'panvel', 'pune', 'Air', 'Consignor', 'Consignor', 'a', 'a', 2, 'a'),
(14, 'Initiated', '2', '3', '2024-12-11', 'panvel', 'pune', 'Air', 'Consignor', 'Consignor', 'a', 'a', 2, 'a'),
(15, 'Initiated', '3', '2', '2024-12-20', 's', 's', 'Air', 'Consignee', 'Consignor', 's', 's', 2, 's'),
(16, 'Initiated', '2', '3', '2024-12-12', 'panvel', 'a', 'Air', 'Consignee', 'Consignee', 's', 's', 2, 's'),
(17, 'Initiated', '1', '5', '2025-01-02', 'panvel', 'pune', 'Air', 'Consignor', 'Consignor', 'a', 'a', 1, 'a'),
(18, 'Initiated', '2', '1', '2024-12-17', 'a', 'a', 'Air', 'Consignor', 'Consignee', 'a', 'a', 2, 'a'),
(19, 'Initiated', '3', '5', '2024-12-13', 'A', 'A', 'Air', 'Consignee', 'Consignor', 'A', 'A', 2, 'A'),
(20, 'Initiated', '3', '1', '2024-12-13', 'A', 'A', 'Air', 'Consignee', 'Consignor', 'A', 'A', 2, 'A'),
(21, 'Initiated', '4', '4', '2024-12-12', 'a', 'a', 'Air', 'Consignor', 'Consignor', '1313', '13131', 2, '1313'),
(22, 'Initiated', '6', '6', '2024-12-06', 'a', 'pune', 'Air', 'Consignor', 'Consignor', 'A', 'A', 1, '1161'),
(23, 'Initiated', '1', '4', '2024-12-19', 'panvel', 'pune', 'Sea', 'Consignor', 'Consignor', 'AAA', 'AAA', 2, 'MAYUR'),
(24, 'Initiated', '2', '2', '2024-12-12', 'a', 'pune', 'Air', 'Consignor', 'Consignor', 'A', 'A', 2, 'A'),
(25, 'Initiated', '2', '1', '2024-12-06', 'A', 'A', 'Road', 'Consignor', 'Consignor', 'A', 'A', 1, 'A'),
(26, 'Paid', '1', '1', '2024-12-05', 'panvel', 'pune', 'Air', 'Consignor', 'Consignor', 'TEST', 'TEST2', 4, 'MAYUR 66'),
(27, 'Initiated', '1', '2', '2024-12-04', 'panvel', 'pune', 'Road', 'Consignee', 'Consignee', 'PANVEL ', 'PUNE SUB URBUN ', 2, 'MAYUR PATIL'),
(28, 'Initiated', '5', '3', '2024-12-18', 's', 'Bhandup', 'Air', 'Consignee', 'Consignor', 's', 's', 2, 's'),
(31, 'Initiated', '2', '2', '2024-12-12', '22', 'Andheri', 'Road', 'Consignor', 'Consignor', '111', '12', 6, 's'),
(33, 'Initiated', '1', '2', '2024-12-06', 's', 'Sakinaka', 'Air', 'Consignee', 'Consignor', 's', 's', 2, 's'),
(34, 'Initiated', '3', '2', '2024-12-04', 's', 'Bhandup', 'Air', 'Consignor', 'Consignor', 's', 's', 1, 's'),
(37, 'Initiated', '2', '3', '2024-12-05', 'a', 'Vikhroli', 'Sea', 'Consignor', 'Consignor', 'a', 'a', 2, 'a'),
(42, 'Initiated', '3', '2', '2024-12-26', 'a', 'Borivali', 'Air', 'Consignee', 'Consignor', 'a', 'a', 2, 'a'),
(43, 'Initiated', '2', '3', '2024-12-12', '131', 'Andheri', 'Air', 'Consignor', 'Consignor', '12121', '1211', 2, 'ss'),
(44, 'Initiated', '3', '6', '2025-01-02', 'panvel', 'Andheri', 'Air', 'Consignor', 'Consignor', 'a', 'a', 2, 'aa');

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
(3, 'Shritej mhatre', '1122554778963', 'a', '9833123247', 'middle class society type a building plot 10 panvel raigad 410206', 'a@gmail.com', NULL, '2024-11-24 07:10:48'),
(4, 'yash dubey test 123', '1234567897464646', 'yes', '9819740287', 'at panvel dist raigad india', 'yashdubey@gmail.com', NULL, '2024-11-30 15:42:46'),
(5, 'test nidhi shritej', '2255889966', '8855669', '8104678066', 'abcded', 'test@gmail.com', NULL, '2024-12-01 14:15:36'),
(6, 'test partyssss', '1313', '31313', '9819740287', '13213131313', '131313@gmail.com', NULL, '2024-12-01 14:19:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `paying_amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `paying_amount`, `payment_mode`, `payment_date`, `remark`, `created_at`) VALUES
(7, 1, 2000.00, 'Cash', '2024-12-31', '200', '2024-11-26 18:33:24'),
(8, 1, 27163.00, 'Cash', '2000-02-02', 'done', '2024-11-26 18:34:14'),
(9, 1, 500.00, 'Cash', '2024-12-30', '100', '2024-11-26 18:36:03'),
(10, 2, 1854.00, 'Card', '2000-02-02', 'test', '2024-11-26 18:37:33'),
(11, 2, 1854.00, 'Cash', '2024-12-31', '200', '2024-11-26 18:39:43'),
(12, 2, 1854.00, 'Cash', '2000-02-02', '200', '2024-11-26 18:40:02'),
(13, 2, 1854.00, 'Cash', '2000-02-02', 'test', '2024-11-26 18:41:00'),
(14, 1, 27163.00, 'Card', '2000-02-02', 'test', '2024-11-26 18:46:42'),
(15, 2, 2000.00, 'Cash', '2024-11-30', 'given cash in head office ', '2024-11-30 15:53:48'),
(16, 7, 3854437.00, 'Card', '2000-02-02', 'done', '2024-11-30 21:02:41'),
(17, 3, 5000.00, 'Cash', '2024-12-31', '121', '2024-12-01 09:09:05'),
(18, 9, 52887.00, 'Cash', '2024-12-31', '11', '2024-12-01 14:52:31'),
(19, 26, 455.00, 'Card', '2002-02-05', 'TEST', '2024-12-03 19:39:06'),
(20, 26, 466.00, 'Cash', '5002-02-02', '121', '2024-12-03 19:39:51'),
(21, 27, 1110.00, 'Cash', '2024-12-31', 'collected half amount', '2024-12-03 19:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `ratemaster`
--

CREATE TABLE `ratemaster` (
  `Location` varchar(50) NOT NULL,
  `Rate_1_5` int(11) DEFAULT NULL,
  `Rate_3` int(11) DEFAULT NULL,
  `Rate_6` int(11) DEFAULT NULL,
  `Rate_9` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratemaster`
--

INSERT INTO `ratemaster` (`Location`, `Rate_1_5`, `Rate_3`, `Rate_6`, `Rate_9`) VALUES
('Andheri', 600, 6100, 8200, 9500),
('Bhandup', 600, 6100, 8200, 9500),
('Borivali', 600, 6100, 8200, 9500),
('Dahisar', 600, 6100, 8200, 9500),
('Goregaon', 600, 6100, 8200, 9500),
('Kandivali', 600, 6100, 8200, 9500),
('Kurla', 600, 6100, 8200, 9500),
('Marol', 600, 6100, 8200, 9500),
('Mulund', 600, 6100, 8200, 9500),
('Sakinaka', 600, 6100, 8200, 9500),
('Vikhroli', 600, 6100, 8200, 9500);

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
(1, 'Bus', 'MH55-BC4545test', 125000114),
(2, 'Bus', 'MH46MD7080', 22547),
(3, 'Pick-up', 'MH58 BC 5058test', 1478932585),
(4, 'Pick-up', 'MH404041205', 558745),
(5, 'Pick-up', 'MH10', 254),
(6, 'Bus', 'DD12', 11254);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `ratemaster`
--
ALTER TABLE `ratemaster`
  ADD PRIMARY KEY (`Location`);

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
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `charges`
--
ALTER TABLE `charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
