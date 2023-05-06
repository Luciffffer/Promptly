-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2023 at 08:20 AM
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
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `cover` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `title`, `cover`) VALUES
(1, 'Welcome to the club!', 'assets/images/site/welcome_achievement.svg');

-- --------------------------------------------------------

--
-- Table structure for table `achievement_user`
--

CREATE TABLE `achievement_user` (
  `id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_unlocked` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_models`
--

CREATE TABLE `ai_models` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `versions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `icon` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_models`
--

INSERT INTO `ai_models` (`id`, `name`, `description`, `versions`, `icon`) VALUES
(1, 'Midjourney', 'Midjourney is a generative artificial intelligence program and service created and hosted by a San Francisco-based independent research lab Midjourney, Inc. Midjourney generates images from natural language descriptions, called \"prompts\", similar to OpenAI\'s DALL-E and Stable Diffusion.', '[\"V5\", \"V4\", \"V3\", \"V2\", \"V1\"]', 'assets/images/site/midjourney-icon.svg'),
(2, 'DALL·E', 'DALL-E and DALL-E 2 are deep learning models developed by OpenAI to generate digital images from natural language descriptions, called \"prompts\".', '[\"V2\", \"V1\"]', 'assets/images/site/dalle-icon.svg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, '3D'),
(2, 'Illustration'),
(3, 'Realistic'),
(4, 'Cartoon'),
(5, 'Drawing'),
(6, 'Pixel Art'),
(7, 'Clothes'),
(8, 'People'),
(9, 'Animals'),
(10, 'Code'),
(11, 'Nature');

-- --------------------------------------------------------

--
-- Table structure for table `category_prompt`
--

CREATE TABLE `category_prompt` (
  `id` int(11) NOT NULL,
  `prompt_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_prompt`
--

INSERT INTO `category_prompt` (`id`, `prompt_id`, `category_id`) VALUES
(7, 3, 1),
(8, 3, 3),
(9, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `prompts`
--

CREATE TABLE `prompts` (
  `id` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(500) NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `prompt` text NOT NULL,
  `prompt_instructions` text NOT NULL,
  `word_count` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_version` varchar(30) NOT NULL,
  `header_image` varchar(300) NOT NULL,
  `example_image1` varchar(300) NOT NULL,
  `example_image2` varchar(300) DEFAULT NULL,
  `example_image3` varchar(300) DEFAULT NULL,
  `example_image4` varchar(300) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `free` tinyint(1) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`id`, `title`, `description`, `tags`, `prompt`, `prompt_instructions`, `word_count`, `author_id`, `model_id`, `model_version`, `header_image`, `example_image1`, `example_image2`, `example_image3`, `example_image4`, `date_created`, `free`, `approved`) VALUES
(3, 'Food Advertising Photography', 'This curated prompt generates high-quality impactful food images, ready to be used in your advertising assets.\r\nYou will be able to display any ingredient or dish in a spectacular way as the prompt is fully customizable.\r\n\r\nCustomization instructions will be provided at purchase, including the shown examples.\r\nDon\'t hesitate to contact us for support.\r\nTheRightPrompt', '[\"food\",\"marketing\",\"advertisement\",\"photography\",\"real\"]', 'hihi you don\'t get anything :PPPPPP', 'I need sleep', 6, 32, 1, 'V5', 'assets/images/user-submit/b04a69ac403b1768ea105ad81326e303-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/96c9163f4c84f08419a6c4c51660d333-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/0c1aaab44196b5a453d8f4b4c67e0f6c-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/77c0a9646c5ed6e086eb8ee0ea6a03b7-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/9eb4397f6936bd5d32cd0ac03c846f15-2023.05.06-08.03.58.jpg', '2023-05-06 08:03:58', 0, 0);

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

--
-- Dumping data for table `temp_tokens`
--

INSERT INTO `temp_tokens` (`id`, `user_id`, `token`, `time_created`, `type`) VALUES
(12, 32, '2196b8d49dd12f59cc3db27407892063', '2023-04-29 22:00:50', 'email');

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
  `credits` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `biography`, `profile_pic`, `date_created`, `email_verified`, `last_login`, `credits`, `active`) VALUES
(26, 'tim', 'tim.noelmans@outlook.com', '$2y$12$VLY2b484ejbrhR4QNBf4RuJUOP0zC.0A18l..WuqCDAlwIQyL/byK', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-14 07:00:59', 1, '2023-04-30 16:38:57', 0, 1),
(27, 'Saskia', 'saskia.sturbois1@telenet.be', '$2y$12$FWt7./hdY1wYj25jWCL5GOGdjhpXXnGg3rxoDxh565ghwqUJHGI42', NULL, 'assets/images/site/default-user-pic.svg', '2023-04-14 22:40:47', 1, '2023-04-14 22:44:57', 0, 1),
(32, 'Lucifer', 'contact@lucifarian.be', '$2y$12$a7SLfCKldHWcE0KcJm531efCvYsSpnkLEUKb7BZaZa631J20LnX3W', 'meow meow meow\r\n\r\nwoof woof', 'assets/images/user-submit/df96ab0e1a28a26529c7f55732c0d14d-2023.05.06-07.55.36.png', '2023-04-29 22:00:50', 1, '2023-05-04 09:02:12', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievement_user`
--
ALTER TABLE `achievement_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievements_achievement_id` (`achievement_id`),
  ADD KEY `achievements_user_id` (`user_id`);

--
-- Indexes for table `ai_models`
--
ALTER TABLE `ai_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_prompt`
--
ALTER TABLE `category_prompt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_prompt_id` (`prompt_id`),
  ADD KEY `categories_category_id` (`category_id`);

--
-- Indexes for table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prompts_user_id` (`author_id`),
  ADD KEY `prompts_model_id` (`model_id`);

--
-- Indexes for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temp_tokens_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `achievement_user`
--
ALTER TABLE `achievement_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ai_models`
--
ALTER TABLE `ai_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category_prompt`
--
ALTER TABLE `category_prompt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievement_user`
--
ALTER TABLE `achievement_user`
  ADD CONSTRAINT `achievements_achievement_id` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `achievements_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category_prompt`
--
ALTER TABLE `category_prompt`
  ADD CONSTRAINT `categories_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `categories_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_model_id` FOREIGN KEY (`model_id`) REFERENCES `ai_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prompts_user_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  ADD CONSTRAINT `temp_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
