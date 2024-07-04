-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2024 at 09:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL DEFAULT 0,
  `quantity` int(100) NOT NULL DEFAULT 1,
  `image` varchar(100) NOT NULL,
  `product_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`, `product_id`) VALUES
(132, 3, 'Halo', 123, 1, '6920933.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `kurir` varchar(255) DEFAULT NULL,
  `total_products` varchar(1000) DEFAULT NULL,
  `total_price` int(100) DEFAULT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `tukar_id` int(25) NOT NULL,
  `target_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `jenis`, `user_id`, `name`, `number`, `email`, `method`, `address`, `kurir`, `total_products`, `total_price`, `placed_on`, `payment_status`, `tukar_id`, `target_name`, `image`) VALUES
(22, 'beli', 3, 'member1', NULL, NULL, NULL, NULL, '', ', Halo (1) , Abstract Art (1) ', 2, '03-Jul-2024', 'pending', 0, '', ''),
(29, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'buku', NULL, '04-Jul-2024', 'aproved', 1, '', ''),
(30, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'timba', NULL, '04-Jul-2024', 'pending', 1, '', ''),
(31, 'beli', 3, 'Shiro', '0453786', 'member1@gmail.com', 'COD', 'Jl. Pemuda, 34, Semarang, Jawa Tengah, 78954', 'cash on delivery', ', Halo (3) ', 369, '04-Jul-2024', 'completed', 0, '', ''),
(35, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'buku', NULL, '04-Jul-2024', 'pending', 1, '', ''),
(38, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'motor', NULL, '04-Jul-2024', 'pending', 1, '', ''),
(39, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'motor', NULL, '04-Jul-2024', 'pending', 1, 'Halo', ''),
(40, 'tukar', 5, 'testing', NULL, NULL, NULL, NULL, NULL, 'buku', NULL, '04-Jul-2024', 'pending', 1, 'tela', ''),
(41, 'tukar', 5, 'testing', NULL, NULL, NULL, NULL, NULL, 'baba', NULL, '04-Jul-2024', 'pending', 1, 'Halo', ''),
(42, 'tukar', 3, 'member1', NULL, NULL, NULL, NULL, NULL, 'mobil', NULL, '04-Jul-2024', 'aproved', 1, 'Abstract Art', ''),
(43, 'beli', 3, 'rifqi', '05064', 'member1@gmail.com', 'debit card', 'Jl. Pemuda, 23, Semarang, Jawa Tengah, 12345', 'paypal', ', Abstract Art (3) ', 30000, '04-Jul-2024', 'completed', 0, '', ''),
(44, 'tukar', 6, 'rifqi', NULL, NULL, NULL, NULL, NULL, 'camera', NULL, '04-Jul-2024', 'reject', 1, 'Halo', ''),
(45, 'beli', 6, 'andro', '08954780720', 'and12@gmail.com', 'COD', 'Jl. Pemuda, 33, Semarang, Jawa Tengah, 59341', 'cash on delivery', ', Halo (10) ', 1230, '04-Jul-2024', 'pending', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL DEFAULT 0,
  `stock` int(100) NOT NULL DEFAULT 0,
  `image` varchar(100) NOT NULL,
  `user_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `image`, `user_id`) VALUES
(2, 'Abstract Art', 10000, -9, 'the_world.jpg', 2),
(22, 'Halo', 123, 5, '6920933.jpg', 2),
(24, 'Lapotop', 5000000, 0, 'Computer.png', 2),
(27, 'Shiro', 1000, 5, '6920933.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'admin1', 'admin1@gmail.com', 'e00cf25ad42683b3df678c61f42c6bda', 'admin'),
(3, 'member1', 'member1@gmail.com', 'c7764cfed23c5ca3bb393308a0da2306', 'user'),
(4, 'admin2', 'admin2@gmail.com', 'c84258e9c39059a89ab77d846ddab909', 'admin'),
(5, 'testing', 'asd122@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(6, 'rifqi', 'rifqi@gmail.com', '72561baf6079c338cc2dd68e98d52055', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
