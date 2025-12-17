-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 07:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `heartbrew_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`) VALUES
(1, 5, '39.00', '2025-11-22 09:44:03'),
(2, 6, '59.00', '2025-11-23 09:18:13'),
(3, 1, '65.00', '2025-11-23 10:09:34'),
(4, 1, '370.00', '2025-11-23 10:10:48'),
(5, 5, '202.00', '2025-11-25 04:19:58'),
(6, 7, '149.00', '2025-11-25 04:22:57'),
(7, 8, '209.00', '2025-11-25 04:55:51'),
(8, 9, '173.00', '2025-11-25 05:35:14'),
(9, 5, '49.00', '2025-11-25 06:04:23'),
(10, 15, '218.00', '2025-11-26 12:17:28'),
(11, 16, '114.00', '2025-11-26 12:31:57'),
(12, 17, '159.00', '2025-11-27 12:14:54'),
(13, 18, '297.00', '2025-11-27 12:18:37'),
(14, 6, '110.00', '2025-11-27 12:19:38'),
(15, 6, '321.00', '2025-11-29 01:57:03'),
(16, 6, '225.00', '2025-11-29 01:57:38'),
(17, 21, '137.00', '2025-11-30 14:24:25'),
(18, 9, '313.00', '2025-11-30 14:26:25'),
(19, 22, '114.00', '2025-12-02 06:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `qty`, `price`) VALUES
(1, 1, 7, 'Mango Float ', 1, '39.00'),
(2, 2, 4, NULL, 1, '59.00'),
(3, 3, 6, NULL, 1, '65.00'),
(4, 4, 4, NULL, 2, '59.00'),
(5, 4, 10, NULL, 1, '49.00'),
(6, 4, 7, NULL, 1, '39.00'),
(7, 4, 5, NULL, 1, '49.00'),
(8, 4, 8, NULL, 1, '55.00'),
(9, 4, 13, NULL, 1, '60.00'),
(10, 5, 4, NULL, 1, '59.00'),
(11, 5, 14, NULL, 1, '45.00'),
(12, 5, 5, NULL, 1, '49.00'),
(13, 5, 10, NULL, 1, '49.00'),
(14, 6, 7, NULL, 1, '39.00'),
(15, 6, 11, NULL, 1, '40.00'),
(16, 6, 9, NULL, 1, '70.00'),
(17, 7, 11, NULL, 1, '40.00'),
(18, 7, 6, NULL, 1, '65.00'),
(19, 7, 8, NULL, 1, '55.00'),
(20, 7, 10, NULL, 1, '49.00'),
(21, 8, 5, NULL, 1, '49.00'),
(22, 8, 6, NULL, 1, '65.00'),
(23, 8, 4, NULL, 1, '59.00'),
(24, 9, 10, NULL, 1, '49.00'),
(25, 10, 10, NULL, 1, '49.00'),
(26, 10, 9, NULL, 1, '70.00'),
(27, 10, 7, NULL, 1, '39.00'),
(28, 10, 13, NULL, 1, '60.00'),
(29, 11, 5, NULL, 1, '49.00'),
(30, 11, 6, NULL, 1, '65.00'),
(31, 12, 11, NULL, 1, '40.00'),
(32, 12, 13, NULL, 1, '60.00'),
(33, 12, 4, NULL, 1, '59.00'),
(34, 13, 5, NULL, 1, '49.00'),
(35, 13, 8, NULL, 1, '55.00'),
(36, 13, 10, NULL, 1, '49.00'),
(37, 13, 6, NULL, 1, '65.00'),
(38, 13, 11, NULL, 1, '40.00'),
(39, 13, 12, NULL, 1, '39.00'),
(40, 14, 14, NULL, 1, '45.00'),
(41, 14, 6, NULL, 1, '65.00'),
(42, 15, 13, NULL, 1, '60.00'),
(43, 15, 10, NULL, 1, '49.00'),
(44, 15, 4, NULL, 1, '59.00'),
(45, 15, 5, NULL, 1, '49.00'),
(46, 15, 6, NULL, 1, '65.00'),
(47, 15, 7, NULL, 1, '39.00'),
(48, 16, 14, NULL, 5, '45.00'),
(49, 17, 12, NULL, 1, '39.00'),
(50, 17, 10, NULL, 1, '49.00'),
(51, 17, 5, NULL, 1, '49.00'),
(52, 18, 6, NULL, 1, '65.00'),
(53, 18, 14, NULL, 1, '45.00'),
(54, 18, 10, NULL, 1, '49.00'),
(55, 18, 4, NULL, 1, '59.00'),
(56, 18, 8, NULL, 1, '55.00'),
(57, 18, 11, NULL, 1, '40.00'),
(58, 19, 4, NULL, 1, '59.00'),
(59, 19, 8, NULL, 1, '55.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `image`) VALUES
(4, 'Banana Cake ', 'A moist and fluffy slice of banana cake, bursting with natural banana flavor and lightly sweetened, perfect for a cozy treat', 'Dessert', '59.00', 'assets/images/Banana Cake.jpg'),
(5, 'Bavarian Filled Donut', 'A soft, golden donut filled with creamy Bavarian custard, offering a sweet and indulgent treat in every bite.', 'Dessert', '49.00', 'assets/images/Bavarian-Cream-Donuts.jpg'),
(6, 'Iced Chocolate', 'Rich and creamy iced chocolate, chilled to perfection and topped with a hint of sweetness.', 'Drinks', '65.00', 'assets/images/IcedChocolate.jpg'),
(7, 'Mango Float ', 'Sweet and creamy mango float slice with layers of ripe mangoes and chilled cream.', 'Dessert', '39.00', 'assets/images/mangofloat.jpg'),
(8, 'Boba Milktea', 'Refreshing and creamy milk tea with chewy boba pearls.', 'Drinks', '55.00', 'assets/images/Milktea.jpg'),
(9, 'Mochaccino', 'Smooth and rich mochaccino with a perfect blend of chocolate and coffee.', 'Drinks', '70.00', 'assets/images/mochaccino.jpg'),
(10, 'Sandwich', 'Fresh and tasty sandwich with your choice of fillings.', 'Snaks', '49.00', 'assets/images/Sandwich.jpg'),
(11, 'French Fries', 'Crispy and golden French fries, perfectly seasoned.', 'Snacks', '40.00', 'assets/images/French fries.jpg'),
(12, 'Iced Americano', 'Cold and bold iced Americano with a smooth coffee taste.', 'Drinks', '39.00', 'assets/images/Iced Americano.jpg'),
(13, 'Iced Latte', 'Chilled and creamy iced latte with a smooth coffee flavor.', 'Drinks', '60.00', 'assets/images/Latte.jpg'),
(14, 'Cappuccino', 'frothy cappuccino with a rich coffee taste.', 'Drinks', '45.00', 'assets/images/cappuccino.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`) VALUES
(1, 'Admin User', 'admin@heartbrew.test', '$2y$10$4D.ElgXWxs1e4nPmBgCcYu3PYDhPGm/dWpguDoW5KTLUY9FdADrjO', 'admin'),
(3, 'My Admin', 'myadmin@heartbrew.test', 'admin123', 'admin'),
(5, 'jam', 'jam@gmail.com', '$2y$10$MrA4JwKIe3gzXZayD5nWJu/IAbN5TqA759HUmzV4c2JIxATl4xhte', 'user'),
(6, 'maj', 'maj@gmail.com', '$2y$10$urYATvQ9pX9T1auHmoWOQua3HJroq3OvFD2XQT4MfhInBt6AFZcLK', 'user'),
(7, 'ella', 'ella@gmail.com', '$2y$10$ixCXpPlntSjMBuNv2AWHfOQzmNUBz1EAAT3XpoSD3kJZPhw3cP.di', 'user'),
(8, 'jai', 'jai@gmail.com', '$2y$10$QHkDfd4NBirbXxFWTodOY.qCZAaHeswwefjbBV0ZIdI4ISEVZEj2C', 'user'),
(9, 'mella', 'mella@gmail.com', '$2y$10$vDrpghiE2zPZbxp3wS6NwOPfAveoGNuVXVYy0zx5s1o7xEJqCdhm6', 'user'),
(14, 'shanel', 'shanel@gmail.com', '$2y$10$ip6zTTi./JW7CsDEKd6pmOvkqBET.vL6SeXWxEmVB572UDkJYLHvu', 'user'),
(15, 'ryan ry', 'ryan@gmail.com', '$2y$10$mlb0eXYhKcJiOnB1Xcy2G.55ZUejZaGYPkQYeAMHq0cqxMG4hA2BC', 'user'),
(16, 'jasmine nene', 'jasmine@gmail.com', '$2y$10$XiSAogAzhcd7qPYiPezH/OziiUXydgk2f3pEp2b9kXQCQuG2Z06Iy', 'user'),
(17, 'jambi bi', 'jambi@gmail.com', '$2y$10$YWqaMO18z8KhamX2MZMuK.wEFlVjKAjWIzdTnyYkMiICQU5TQ3E.K', 'user'),
(18, 'mel mel', 'mel@gmail.com', '$2y$10$1WHh/Dm.wCvyz9UijdOMYuwlnASevGSz4OcTv5joF73TttDWs2yyy', 'user'),
(20, 'isabel', 'isabel@gmail.com', '$2y$10$Rj0dwceRczHP/zhPSksUrOO./RqsmzaW.TWUu/iJ99GSqUjXLVxqC', 'user'),
(21, 'rayan', 'rayan@gmail.com', '$2y$10$DYzm5LjoYaKO4vIJ3RBAzOj8jJEmyWP4xtAzFK7AEtJNIy.HQcIb2', 'user'),
(22, 'jamella fortes', 'jamellafortes@gmail.com', '$2y$10$wEmBPLOD7WXM6n8804FVGulUpQpSeHETboLTNVdawfft6o1v7RwCy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
