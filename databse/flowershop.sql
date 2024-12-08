-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 03:43 PM
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
  `shop_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `baranggay` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Processing','Shipped','Out for Delivery','Delivered','Cancelled','On Hold','Returned','Refunded') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shop_id`, `recipient_name`, `address`, `baranggay`, `city`, `province`, `phone_number`, `special_instructions`, `total_amount`, `order_date`, `status`) VALUES
(33, 13, 11, 'Lyward Maniego', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', 'gate na red', 100.00, '2024-12-08 12:59:57', 'Out for Delivery'),
(34, 12, 11, 'Lyward Maniego', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', '111', 100.00, '2024-12-08 13:08:57', 'Out for Delivery'),
(35, 14, 11, '333', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', '333', 100.00, '2024-12-08 13:10:17', 'Out for Delivery'),
(36, 14, 11, '333', 'Block 12 lot 32', 'Banadero', 'Calamba city', 'Laguna', '9851634098', '333', 100.00, '2024-12-08 13:11:23', 'Refunded');

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
(30, 33, 10, 1, 100.00),
(31, 34, 10, 1, 100.00),
(32, 35, 10, 1, 100.00),
(33, 36, 10, 1, 100.00);

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
(10, 0, 'sample product 1', '123', 100.00, 'uploads/products/67559821a0f1f_67505b476d0d9_flower4.jpg', '2024-12-08 12:59:13', 11);

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
(1, 'affordable all shops', 'anonymous', NULL, '5', '2024-12-05 18:52:24'),
(3, '123', '123', 'flower4.jpg', '123', '2024-12-06 21:55:29');

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
(11, 13, 'shop1', '123@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '970860053', 'uploads/675597ed160af_7aac999f34d23f7de7c2291410550bab.gif', 'uploads/675597ed16165_7aac999f34d23f7de7c2291410550bab.gif', 'uploads/675597ed161dd_7aac999f34d23f7de7c2291410550bab.gif', 'uploads/675597ed16251_7aac999f34d23f7de7c2291410550bab.gif', 'uploads/675597ed162bf_7aac999f34d23f7de7c2291410550bab.gif', '2024-12-08 12:58:21');

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
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `middlename`, `email`, `password`, `created_at`, `username`, `birthday`, `is_admin`) VALUES
(10, '', '', NULL, 'admin@gmail.com', '$2y$10$Uxamc5GH0/1Mabdx7h1gfurgJDOXA0J2IpcmSCyqEIO7oGGB77Er2', '2024-12-08 11:50:34', 'admin', NULL, 1),
(12, '111', '111', '111', '111@gmail.com', '$2y$10$cRvKO7gVpwRDJV7N6wrCfepmWth57CfLtZhgsnXu0f.An55.FcKLu', '2024-12-08 12:20:28', '111', '2024-12-08', 0),
(13, '123', '123', '123', '123@gmail.com', '$2y$10$7mXePn/uzo/M0GwRJV3O8ev9xGKY3lPOxgGiFAIQz0k8bDBCNxm0a', '2024-12-08 12:26:24', '123', '2024-12-08', 0),
(14, '333', '333', '333', '333@gmail.com', '$2y$10$3VgjW6fLR6.ABXv8ZJn0PuByW7jLXo/W3mBhaJMGRqNAELA8frCR2', '2024-12-08 13:09:54', '333', '2024-12-08', 0);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
