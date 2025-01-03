-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2025 at 02:21 AM
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
-- Database: `flowershop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line`, `barangay`, `city`, `province`, `phone_number`) VALUES
(1, 21, 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '09851634098'),
(4, 22, '111', '111', '111', '111', '111'),
(5, 21, 'block 10 lot 48', 'Banadero', 'calamba city', 'laguna', '09166923071 ');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `shop_id`, `quantity`, `created_at`) VALUES
(33, 21, 23, 14, 4, '2025-01-01 09:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_message` text DEFAULT NULL,
  `shop_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Processing','Shipped','Out for Delivery','Delivered','Cancelled','On Hold','Returned','Refunded','Received') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shop_id`, `recipient_name`, `address`, `barangay`, `city`, `province`, `phone_number`, `special_instructions`, `total_amount`, `order_date`, `status`) VALUES
(39, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'losbanioscity', 'Laguna', '09851634091', '123', 100.00, '2024-12-13 14:20:44', 'Received'),
(40, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'losbanioscity', 'Laguna', '09851634091', '', 100.00, '2024-12-15 11:48:45', 'Received'),
(41, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'losbanioscity', 'Laguna', '09851634091', 'none', 100.00, '2024-12-15 16:51:18', 'Received'),
(46, 22, 14, '123', '111', '111', '111', '111', '111', '321', 200.00, '2024-12-15 17:01:48', 'Received'),
(47, 21, 14, 'julius ', 'Block 11 lot 11', 'Banaderos', 'Calamba city', 'Laguna', '1970860053', '', 100.00, '2024-12-16 06:04:47', 'Received'),
(48, 21, 15, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2024-12-16 06:05:45', 'Received'),
(49, 21, 15, 'julius ', 'block 10 lot 48', 'Banadero', 'calamba city', 'laguna', '09166923071 ', '', 100.00, '2024-12-18 05:55:30', 'Received'),
(50, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2024-12-18 13:06:04', 'Received'),
(51, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2024-12-18 13:12:15', 'Received'),
(52, 21, 14, '123', 'block 10 lot 48', 'Banadero', 'calamba city', 'laguna', '09166923071 ', '', 100.00, '2024-12-18 13:12:49', 'Received'),
(53, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2024-12-27 14:03:53', 'Received'),
(54, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2024-12-31 03:53:07', 'Received'),
(55, 21, 14, '123', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091', '', 100.00, '2025-01-01 09:28:20', 'Received'),
(56, 21, 14, '123', 'block 10 lot 48', 'Banadero', 'calamba city', 'laguna', '09166923071 ', '', 100.00, '2025-01-02 10:33:13', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(36, 39, 23, 1, 100.00),
(37, 40, 23, 1, 100.00),
(38, 41, 23, 1, 100.00),
(52, 46, 23, 1, 100.00),
(53, 46, 24, 1, 100.00),
(54, 47, 23, 1, 100.00),
(55, 48, 24, 1, 100.00),
(56, 49, 24, 1, 100.00),
(57, 50, 23, 1, 100.00),
(58, 51, 23, 1, 100.00),
(59, 52, 23, 1, 100.00),
(60, 53, 23, 1, 100.00),
(61, 54, 23, 1, 100.00),
(62, 55, 23, 1, 100.00),
(63, 56, 23, 1, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `product_name`, `product_description`, `price`, `product_image`, `created_at`, `shop_id`) VALUES
(23, 0, 'sample product 1', '1', 100.00, 'uploads/products/675b047637ed4_22bd566c4bbe272956db066ca7522d8e.jpg', '2024-12-12 15:42:46', 14),
(24, 0, 'sample product 2', '2', 100.00, 'uploads/products/675f0927424fe_3e0dce3d-51b5-4afd-9510-b1d83fe39021.jpg', '2024-12-15 16:51:51', 15),
(25, 0, 'Flower 1', 'none', 500.00, 'uploads/products/67773a2951aa8_flower.jpg', '2025-01-03 01:15:21', 16),
(26, 0, 'Flower 2', 'none', 800.00, 'uploads/products/67773a420e3da_flower2.jpg', '2025-01-03 01:15:46', 16),
(27, 0, 'Flower 3', 'none', 900.00, 'uploads/products/67773a530855a_flower3.jpg', '2025-01-03 01:16:03', 16),
(28, 0, 'Flower 1', 'none', 600.00, 'uploads/products/67773a706ee63_flower4.jpg', '2025-01-03 01:16:32', 18),
(29, 0, 'Flower 4', 'none', 800.00, 'uploads/products/67773a7cd5769_flower5.jpg', '2025-01-03 01:16:44', 18),
(30, 0, 'Flower 3', 'none', 500.00, 'uploads/products/67773a8a850b0_flower6.jpg', '2025-01-03 01:16:58', 18);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_photo` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_text`, `customer_name`, `customer_photo`, `event_type`, `created_at`) VALUES
(5, 'shops\r\n', 'anonymous', NULL, '3.5', '2024-12-13 21:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_email` varchar(255) NOT NULL,
  `shop_address` text NOT NULL,
  `shop_phone` varchar(20) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `identity_proof` varchar(255) DEFAULT NULL,
  `business_license` varchar(255) DEFAULT NULL,
  `sales_tax_registration` varchar(255) DEFAULT NULL,
  `valid_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `user_id`, `shop_name`, `shop_email`, `shop_address`, `shop_phone`, `profile_picture`, `identity_proof`, `business_license`, `sales_tax_registration`, `valid_id`, `created_at`) VALUES
(14, 21, 'shop1', '111@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '970860053', 'uploads/675b04357817e_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675b043578223_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675b0435782a7_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675b04357831a_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675b043578385_22bd566c4bbe272956db066ca7522d8e.jpg', '2024-12-12 15:41:41'),
(15, 22, 'shop2', '222@gmail.com', '222', '970860053', 'uploads/675f09187369d_3e0dce3d-51b5-4afd-9510-b1d83fe39021.jpg', 'uploads/675f091873757_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675f0918737e7_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675f09187386f_22bd566c4bbe272956db066ca7522d8e.jpg', 'uploads/675f0918738e2_22bd566c4bbe272956db066ca7522d8e.jpg', '2024-12-15 16:51:36'),
(16, 24, 'Abegail\'s Shop', 'abegail@gmail.com', 'Real, Calamba laguna', '09751823656', 'uploads/677737ae5a63d_euthaliaremove.png', 'uploads/677737ae5a7f6_flower5.jpg', 'uploads/677737ae5a89b_flower.jpg', 'uploads/677737ae5a92d_flower2.jpg', 'uploads/677737ae5aa0d_flower4.jpg', '2025-01-03 01:04:46'),
(18, 25, 'Kristine Shop', 'Kristine@gmail.com', 'los banos, batong malaki', '0936 939 3062', '', 'uploads/677739f66b3fc_468665031_2607040916161165_8272974888084552527_n.jpg', 'uploads/677739f66b4a9_468444925_8733915470056227_7876475560379881782_n.jpg', 'uploads/677739f66b53e_flower5.jpg', 'uploads/677739f66b5cf_flower6.jpg', '2025-01-03 01:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `address` varchar(255) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `email`, `password`, `created_at`, `username`, `birthday`, `is_admin`, `status`, `address`, `barangay`, `city`, `province`, `phone_number`) VALUES
(10, '', '', NULL, 'admin@gmail.com', '$2y$10$Uxamc5GH0/1Mabdx7h1gfurgJDOXA0J2IpcmSCyqEIO7oGGB77Er2', '2024-12-08 11:50:34', 'admin', NULL, 1, 'active', '', '', '', '', ''),
(21, 'Donguines', 'julius', 'morales\r\n', '123@gmail.com', '$2y$10$WcPg0qFLgvbXLxNPA5RUEOeXLQgGI5lMndWpIHhhZECh5Fi7odCkS', '2024-12-12 15:36:36', '123', '2024-12-12', 0, 'active', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Lagunas', '09851634091'),
(22, '111', '111', '111', '111@gmail.com', '$2y$10$JONX.7M9V2Ghx/FE0n0XueQzcwVPqRZhZBWwZJwaTdMjTToRFfCWa', '2024-12-15 16:28:14', '111', '2024-12-16', 0, 'active', 'EKSPLORAYSON', '111', '111', 'Laguna', '970860053'),
(24, 'Palada', 'abegail', 'B', 'abegail@gmail.com', '$2y$10$kltRkDrbYt3x7gAo91mhs.n8HRGlFKavW.INet22Mi.jGD60sPlVG', '2025-01-03 01:03:35', 'abegail@gmail.com', '2025-01-03', 0, 'active', 'real', 'uno', 'Calamba city', 'laguna', '1970860053'),
(25, 'magpantay', 'Kristine', 'Y', 'kristine@gmail.com', '$2y$10$/1ImeA0K/8/ljJIxuZdfNu/Zz3qAtMyHcjBHKXbfru2CBahHvpyNS', '2025-01-03 01:13:04', 'kristine@gmail.com', '2025-01-03', 0, 'active', 'los banos', 'bato', 'los banos', 'laguna', '09851634091');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_shop_id` (`shop_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_shop_id` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`);

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
