-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 07:53 AM
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
  `purchase_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `condition_status` enum('New','Good','Needs Repair','Damaged') DEFAULT 'New',
  `status` enum('Available','Assigned','Under Maintenance','Disposed') DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `asset_code`, `name`, `category_id`, `subcategory_id`, `office_id`, `purchase_date`, `price`, `condition_status`, `status`, `image`, `quantity`, `description`) VALUES
(95, 'IT - 01', 'Asus', 2, 38, 19, '2025-03-17', 50000.00, 'Good', 'Available', 'Assets_67de2e1828daf.webp', 3, 'for IT dept'),
(96, 'IT - 02', 'Epson', 2, 38, 18, '2025-03-18', 10000.00, 'Good', 'Available', 'Profile_67dd4a6f3130b.png', 0, 'For Registrar Office.....'),
(97, 'IT - 03', 'Electricafan', 3, 34, 15, '2025-03-19', 2000.00, 'Good', 'Assigned', 'Profile_67dd4a6f3130b.png', 1, 'Needed for IT Dept'),
(99, 'IT - 04', 'Electricfan', 1, 38, 15, '2025-03-19', 1200.00, 'Good', 'Available', NULL, 1, 'Needed for IT Dept'),
(101, 'ASSET123', 'assets1', 2, 34, 15, '0000-00-00', 1000.00, '', 'Available', NULL, 100, 'wadwadaw'),
(102, 'awdwad', 'awd', 3, 37, 13, '0000-00-00', 12.00, 'Good', 'Available', NULL, 20, 'awwa'),
(103, 'test', 'fesfse', 2, 31, 14, '0000-00-00', 34.00, '', 'Under Maintenance', NULL, 12, 'rdgrd'),
(104, 'awdaw', 'esfse', 2, 32, 13, '0000-00-00', 0.00, 'Damaged', 'Available', NULL, 2, 'rdg'),
(105, '0001', 'medicine', 2, 33, 15, '0000-00-00', 100.00, 'Good', 'Available', 'Assets_67de52fd58a19.webp', 90, 'awwadawd');

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
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `request_user_id` int(11) NOT NULL,
  `request_assets_id` int(11) NOT NULL,
  `request_qty` int(11) NOT NULL,
  `request_supplier_name` varchar(60) NOT NULL,
  `request_supplier_company` varchar(60) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `request_status` varchar(60) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `request_user_id`, `request_assets_id`, `request_qty`, `request_supplier_name`, `request_supplier_company`, `request_date`, `request_status`) VALUES
(4, 80136, 95, 3, 'joshua', 'com', '2025-03-22 04:40:20', 'Delivered'),
(5, 80136, 95, 5, 'sefes', 'esf', '2025-03-22 04:44:49', 'Pending'),
(6, 80136, 105, 10, 'j supply', 'j company', '2025-03-22 06:09:39', 'Delivered'),
(7, 1, 96, 1, 'j supply', 'j com', '2025-03-22 06:39:49', 'Delivered');

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
(1, 'test', 'Assets_67de5e3f36f55.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `generated_id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `role` varchar(60) NOT NULL,
  `designation` varchar(60) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `employee_id_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=exist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `generated_id`, `email`, `password`, `fullname`, `nickname`, `role`, `designation`, `profile_picture`, `employee_id_picture`, `created_at`, `status`) VALUES
(1, 85623, 'admin@gmail.com', '$2y$10$kbDGD4CzxKZN5dRpp0eoV.azp7.yNniWsyPwb7jQ/QRoCeoZslw82', 'Juan Dela Cruz', 'admin', 'Administrator', 'Computer Lab', 'Profile_67dd240ef2143.jpeg', NULL, '2025-03-22 05:00:22', 1),
(80134, 99477, 'andersonandy046@gmail.com', '$2y$10$DV242aq/jwR52Oq3EqepquWdcrpeEm77Lx/H2gPK7.fnCBnctmYM6', 'joshua padilla', 'andy', 'IACEPO', 'Computer Lab', 'Profile_67dd24b38b323.jpg', NULL, '2025-03-21 08:40:20', 0),
(80135, 48318, 'test@gmail.com', '$2y$10$KwMB1QfMMh9nJ0XlHcmLd.6wa4gEzlF1NpErxPbdREPd25tCsSFNG', 'test', 'test', 'Administrator', 'Registrar\'s Office', NULL, NULL, '2025-03-21 10:40:24', 0),
(80136, 85680, 'andersonandy046@gmail.com', '$2y$10$IHFeoD1o8f1G7lUhz4RmAOi.3zLkC9be.SAYFOn.hxADCYk..VKWi', 'joshua padilla', 'andy', 'Finance', 'Computer Lab', 'Profile_67dd423a5a9b9.jpg', 'ID_67dd423a5ad43.jpg', '2025-03-21 10:40:58', 1),
(80137, 97335, 'johndoe@gmail.com', '$2y$10$5NrC05I.8PafkEAJfFxrgez53J/zxOTDMj.TcGRRbnl0XIr1TcHnG', 'john doe', 'doe', 'Finance', 'Finance\'s Office', 'Profile_67dd4a6f3130b.png', NULL, '2025-03-21 11:16:14', 0);

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
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

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
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80138;

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
