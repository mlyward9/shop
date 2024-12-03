-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:49 PM
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
(4, 3, 'shop1', 'shop@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '0970860053', 'uploads/674dc79a83e22_674dc16491a7a_OIP.jpg', 'uploads/674dc79a83edc_674dc16491a7a_OIP.jpg', 'uploads/674dc79a83f90_674dc16491a7a_OIP.jpg', 'uploads/674dc79a84044_674dc16491a7a_OIP.jpg', 'uploads/674dc79a84111_674dc16491a7a_OIP.jpg', '2024-12-02 14:43:38'),
(5, 3, 'shop2', 'shop@gmail.com', 'Block 12 lot 32\r\nEksplorasyon', '0970860053', 'uploads/674f269257173_674dcbcb2a00e_462555247_2787743184718289_1014975028182954442_n.jpg', 'uploads/674f26925afb5_674dcbcb2a00e_462555247_2787743184718289_1014975028182954442_n.jpg', 'uploads/674f26925b032_674dcbcb2a00e_462555247_2787743184718289_1014975028182954442_n.jpg', 'uploads/674f26925b0a6_674dcbcb2a00e_462555247_2787743184718289_1014975028182954442_n.jpg', 'uploads/674f26925b112_674dcbcb2a00e_462555247_2787743184718289_1014975028182954442_n.jpg', '2024-12-03 15:41:06');

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
(3, 'Maniego', 'Lyward', NULL, '123@gmail.com', '$2y$10$ubSKdFOeM.V.Ya0smYjKjumJVjXPNg.wIucbmcPPqRlElL6hSGLui', '2024-12-02 13:30:20', '123', '2024-12-02');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
