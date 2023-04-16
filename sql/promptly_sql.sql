-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 02:38 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `promptly`
--

-- --------------------------------------------------------

--
-- Table structure for table `temp_tokens`
--

CREATE TABLE `temp_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(300) NOT NULL,
  `time_created` datetime NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `biography` varchar(150) DEFAULT NULL,
  `profile_pic` varchar(300) NOT NULL DEFAULT 'assets/images/site/default-user-pic.svg',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `biography`, `profile_pic`, `date_created`, `email_verified`, `last_login`, `active`) VALUES
(5, 'Lucifer', 'contact@lucifarian.be', '$2y$12$emxw2kXi.qv2YTkD/5/J0OpN1PTaKtxSW5YkYCDv9fVg87.ExeuBe', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-04 05:41:06', 1, '2023-04-04 21:40:53', 1),
(26, 'tim', 'tim.noelmans@outlook.com', '$2y$12$VLY2b484ejbrhR4QNBf4RuJUOP0zC.0A18l..WuqCDAlwIQyL/byK', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-14 07:00:59', 1, '2023-04-15 02:28:50', 1),
(27, 'Saskia', 'saskia.sturbois1@telenet.be', '$2y$12$FWt7./hdY1wYj25jWCL5GOGdjhpXXnGg3rxoDxh565ghwqUJHGI42', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-14 22:40:47', 1, '2023-04-14 22:44:57', 1),
(28, 'Sammy', 'sam.noelmans@outlook.com', '$2y$12$oCl6RHmIuYRs9Q4fqabRGutq0PiA.AvJ89EMBxd9qhiY8hUNHVtda', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-14 22:58:58', 0, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
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
-- AUTO_INCREMENT for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
