-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 01:57 PM
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
-- Database: `flowershop`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `baranggay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Shipped','Delivered','Canceled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `recipient_name`, `address`, `baranggay`, `city`, `province`, `phone_number`, `special_instructions`, `total_amount`, `order_date`, `status`) VALUES
(10, 6, '1', '1', '1', '1', '1', '1', '1', 100.00, '2024-12-04 12:33:26', 'Pending'),
(11, 6, '2', '2', '2', '2', '2', '2', '2', 200.00, '2024-12-04 12:42:26', 'Pending'),
(12, 6, 'Lyward Maniego', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', 'sa red na gate', 300.00, '2024-12-04 12:50:37', 'Pending'),
(13, 6, 'Lyward Maniego', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', '123', 200.00, '2024-12-04 12:52:43', 'Pending');

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
(11, 10, 6, 1, 100.00),
(12, 11, 7, 1, 200.00),
(13, 12, 6, 1, 100.00),
(14, 12, 7, 1, 200.00),
(15, 13, 8, 1, 200.00);

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
(6, 0, 'sample product 1', '123', 100.00, 'uploads/products/67504b0c93159_download.jpg', '2024-12-04 12:29:00', 8),
(7, 0, 'sample product 2', '2', 200.00, 'uploads/products/67504e15d1c5e_download.jpg', '2024-12-04 12:41:57', 8),
(8, 0, 'sample product 2', '123', 200.00, 'uploads/products/675050771a5f1_b36dfa12-ebe8-41c1-97e1-521b454c729d.jpg', '2024-12-04 12:52:07', 9);

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
(8, 6, 'shop3', 'shop@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '0970860053', 'uploads/67504af7c35d8_OIP.jpg', 'uploads/67504af7c36bf_OIP.jpg', 'uploads/67504af7c3782_OIP.jpg', 'uploads/67504af7c381a_OIP.jpg', 'uploads/67504af7c38b8_OIP.jpg', '2024-12-04 12:28:39'),
(9, 6, 'shop3', '123@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '970860053', 'uploads/6750504e7a877_b36dfa12-ebe8-41c1-97e1-521b454c729d (1).jpg', 'uploads/6750504e7a91d_b36dfa12-ebe8-41c1-97e1-521b454c729d (1).jpg', 'uploads/6750504e7a9a5_b36dfa12-ebe8-41c1-97e1-521b454c729d (1).jpg', 'uploads/6750504e7aa19_b36dfa12-ebe8-41c1-97e1-521b454c729d (1).jpg', 'uploads/6750504e7e99c_b36dfa12-ebe8-41c1-97e1-521b454c729d (1).jpg', '2024-12-04 12:51:26');

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
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `email`, `password`, `created_at`, `username`, `birthday`) VALUES
(6, '123', '123', NULL, '123@gmail.com', '$2y$10$AnL0CbsRxCvLNbriuMR70OaE6kRQz7RxC5z/PZi88LPxRgpwIoA9u', '2024-12-04 12:26:58', '123', '2024-12-04'),
(7, '111', '111', NULL, '111@gmail.com', '$2y$10$YSNOZuE/lf9Estr931wAMOMNVqPn1lTBOmlovzHc5RSJ08OYeZY.2', '2024-12-04 12:45:25', '111', '2024-12-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

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
