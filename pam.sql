-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 11:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pam`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `asset_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `office_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `condition_status` enum('New','Good','Needs Repair','Damaged') DEFAULT 'New',
  `status` enum('Available','Assigned','Under Maintenance','Disposed') DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `variety` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `asset_code`, `name`, `category_id`, `subcategory_id`, `office_id`, `purchase_date`, `price`, `condition_status`, `status`, `image`, `description`, `variety`) VALUES
(126, '000001', 'pencil', 3, 37, 12, '2025-04-02 03:29:52', 12.00, 'New', 'Available', 'Assets_67ecaf21806be.webp', 'cfnfcfch', '{\"name\":\"brand\",\"values\":[\"mongol 1\"]}'),
(127, '000002', 'scissor', 3, 37, 12, '2025-04-02 03:33:31', 30.00, 'New', 'Available', 'Assets_67ecb00b3b26a.jpg', 'aawd', '{\"name\":\"color\",\"values\":[\"red\",\"green\",\"blue\"]}'),
(128, '000003', 'eraser', 3, 37, 12, '2025-04-02 03:43:15', 30.00, 'New', 'Available', 'Assets_67ecb25354a75.jpg', '', '{\"name\":\"shape\",\"values\":[\"triangle\",\"square\",\"circle\"]}'),
(129, '000004', 'laptop', 2, 31, 15, '2025-04-02 14:54:51', 500.00, 'New', 'Available', 'Assets_67ed4fbbd3c45.webp', '', '{\"name\":\"brand\",\"values\":[\"hp\",\"lenovo\",\"samsung\"]}');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Furniture'),
(2, 'IT Equipment'),
(3, 'Office Supplies'),
(4, 'Appliances'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `office_name`) VALUES
(12, 'Administration Office'),
(13, 'Finance Department'),
(14, 'Human Resources'),
(15, 'IT Department'),
(16, 'Procurement Office'),
(17, 'Logistics and Supply'),
(18, 'Facilities Management'),
(19, 'Legal Affairs'),
(20, 'Marketing and Communications'),
(21, 'Research and Development'),
(22, 'Customer Service');

-- --------------------------------------------------------

--
-- Table structure for table `recieved_logs`
--

CREATE TABLE `recieved_logs` (
  `recieved_id` int(11) NOT NULL,
  `recieved_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `recieved_supplier_name` varchar(60) NOT NULL,
  `recieved_supplier_company` varchar(60) NOT NULL,
  `recieved_assets_name` varchar(60) NOT NULL,
  `recieved_description` text NOT NULL,
  `recieved_assets_qty` int(11) NOT NULL,
  `recieved_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recieved_logs`
--

INSERT INTO `recieved_logs` (`recieved_id`, `recieved_date`, `recieved_supplier_name`, `recieved_supplier_company`, `recieved_assets_name`, `recieved_description`, `recieved_assets_qty`, `recieved_user_id`) VALUES
(1, '2025-04-03 08:32:42', 'j supplies', 'j company', 'Scissors', 'pang gupit', 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `request_invoice` varchar(60) NOT NULL,
  `request_user_id` int(11) NOT NULL,
  `request_supplier_name` varchar(60) NOT NULL,
  `request_supplier_company` varchar(60) NOT NULL,
  `request_designation` varchar(60) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `request_status` varchar(60) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `request_invoice`, `request_user_id`, `request_supplier_name`, `request_supplier_company`, `request_designation`, `request_date`, `request_status`) VALUES
(16, 'REQ-17435944699126', 1, 'j supply', 'j company', 'Library', '2025-04-03 08:33:09', 'Pending'),
(17, 'REQ-17436060249325', 80141, 'j supply', 'jcom', 'Computer Lab', '2025-04-03 08:34:38', 'Delivered'),
(18, 'REQ-17436721805447', 80141, 'j supply', 'j com', 'HRDO', '2025-04-03 09:23:00', 'pending'),
(19, 'REQ-17436722272526', 80141, 'j supply', 'j com', 'VPAA', '2025-04-03 09:23:47', 'pending'),
(20, 'REQ-17436723338441', 80141, 'j supply', 'j com', 'VPAA', '2025-04-03 09:25:33', 'pending'),
(21, 'REQ-17436724223866', 80141, 'j supply', 'j com', 'VPAA', '2025-04-03 09:27:02', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `request_cart`
--

CREATE TABLE `request_cart` (
  `cart_id` int(11) NOT NULL,
  `cart_user_id` int(11) NOT NULL,
  `cart_asset_id` int(11) NOT NULL,
  `cart_qty` int(11) NOT NULL,
  `cart_variety` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_item`
--

CREATE TABLE `request_item` (
  `r_item_id` int(11) NOT NULL,
  `r_request_id` int(11) NOT NULL,
  `r_item_asset_id` int(11) NOT NULL,
  `r_item_qty` int(11) NOT NULL,
  `r_item_variety` varchar(60) NOT NULL,
  `r_item_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_item`
--

INSERT INTO `request_item` (`r_item_id`, `r_request_id`, `r_item_asset_id`, `r_item_qty`, `r_item_variety`, `r_item_price`) VALUES
(3, 16, 126, 13, 'Mongol 1', 12.00),
(4, 16, 127, 1, 'Green', 30.00),
(5, 17, 127, 2, 'Green', 30.00),
(6, 17, 129, 1, 'Samsung', 500.00),
(7, 18, 126, 10, 'Mongol 1', 12.00),
(8, 18, 128, 3, 'Circle', 30.00),
(9, 18, 128, 6, 'Square', 30.00),
(10, 18, 128, 1, 'Triangle', 30.00),
(11, 19, 127, 1, 'Green', 30.00),
(12, 20, 128, 1, 'Square', 30.00),
(13, 20, 127, 3, 'Green', 30.00),
(14, 20, 129, 1, 'Lenovo', 500.00),
(15, 21, 127, 5, 'Green', 30.00),
(16, 21, 128, 1, 'Square', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`) VALUES
(26, 1, 'Office Chairs'),
(27, 1, 'Desks'),
(28, 1, 'Conference Tables'),
(29, 1, 'Sofas'),
(30, 1, 'Cabinets'),
(31, 2, 'Laptops'),
(32, 2, 'Desktop Computers'),
(33, 2, 'Printers'),
(34, 2, 'Monitors'),
(35, 2, 'Networking Equipment'),
(36, 3, 'Paper'),
(37, 3, 'Pens and Markers'),
(38, 3, 'Notebooks'),
(39, 3, 'Envelopes'),
(40, 3, 'Folders'),
(41, 4, 'Refrigerators'),
(42, 4, 'Microwave Ovens'),
(43, 4, 'Air Conditioners'),
(44, 4, 'Water Dispensers'),
(45, 4, 'Electric Fans'),
(46, 5, 'Miscellaneous Items'),
(47, 5, 'Promotional Materials'),
(48, 5, 'Event Supplies'),
(49, 5, 'Tools and Equipment'),
(50, 5, 'Uncategorized');

-- --------------------------------------------------------

--
-- Table structure for table `system_maintenance`
--

CREATE TABLE `system_maintenance` (
  `system_id` int(11) NOT NULL,
  `system_name` varchar(60) NOT NULL,
  `system_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_maintenance`
--

INSERT INTO `system_maintenance` (`system_id`, `system_name`, `system_image`) VALUES
(1, 'PAM', 'Assets_67de5e3f36f55.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `fullname`, `nickname`, `role`, `designation`, `profile_picture`, `created_at`, `status`) VALUES
(1, '85623', 'admin@gmail.com', '$2y$10$kbDGD4CzxKZN5dRpp0eoV.azp7.yNniWsyPwb7jQ/QRoCeoZslw82', 'Juan Dela Cruz', 'admin', 'Administrator', 'Computer Lab', 'Profile_67dd240ef2143.jpeg', '2025-03-22 05:00:22', 1),
(80138, '000001', 'andersonandy@gmail.com', '$2y$10$fzfuF1upMoglgqkEDKi.TuixFOINa9pc77PRJhbp/Fgymw4NidXsm', 'joshua padilla', 'andy', 'Finance', 'Registrar\'s Office', 'Profile_67ebdf948c3c2.webp', '2025-04-01 12:49:22', 1),
(80139, '8888888', 'juan@gmail.com', '$2y$10$52e/tl0yPplDEA7SFuT7MuII2.1jhzTpfSh8tB2.JZCUhqJTtoXmu', 'juan', 'juan', 'Finance', 'VPAA', 'Profile_67ebe1e2b2142.jpeg', '2025-04-01 12:53:54', 1),
(80140, '99999', 'alucard@gmail.com', '$2y$10$ANwZ3KWOPgjomLNQBGX02OuG/LpmIKYPj91TbXziAE2fFezBtB8ni', 'alucard', 'calu', 'Office Heads', 'Registrar\'s Office', NULL, '2025-04-01 12:59:23', 1),
(80141, '56454564', 'layla@gmail.com', '$2y$10$FatWpQPFn6oQGZrc0yQa8eybcqUvlYHlv/UbAZaCYwYmrQvsx9j.i', 'layla', 'layla', 'Finance', 'Registrar\'s Office', NULL, '2025-04-01 13:01:26', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_code` (`asset_code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`),
  ADD KEY `assets_ibfk_3` (`office_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recieved_logs`
--
ALTER TABLE `recieved_logs`
  ADD PRIMARY KEY (`recieved_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `request_cart`
--
ALTER TABLE `request_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `request_item`
--
ALTER TABLE `request_item`
  ADD PRIMARY KEY (`r_item_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  ADD PRIMARY KEY (`system_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `recieved_logs`
--
ALTER TABLE `recieved_logs`
  MODIFY `recieved_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `request_cart`
--
ALTER TABLE `request_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `request_item`
--
ALTER TABLE `request_item`
  MODIFY `r_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `system_maintenance`
--
ALTER TABLE `system_maintenance`
  MODIFY `system_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80142;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assets_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
