-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 04:51 PM
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
(2, 'DALL·E', 'DALL-E and DALL-E 2 are deep learning models developed by OpenAI to generate digital images from natural language descriptions, called \"prompts\".', '[\"V2\", \"V1\"]', 'assets/images/site/dalle-icon.svg'),
(4, 'Stable Diffusion', 'Stable Diffusion is a deep learning, text-to-image model released in 2022. It is primarily used to generate detailed images conditioned on text descriptions, though it can also be applied to other tasks such as inpainting, outpainting, and generating image-to-image translations guided by a text prom', '[\"V2\", \"V1\"]', 'nothing yet lol');

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
(9, 3, 2),
(10, 4, 3),
(11, 4, 1),
(12, 4, 8),
(13, 4, 2),
(14, 5, 2),
(15, 5, 5),
(16, 5, 3),
(17, 6, 2),
(18, 6, 11),
(19, 7, 2),
(20, 7, 11),
(21, 7, 9),
(22, 8, 8),
(23, 8, 11),
(24, 8, 2),
(25, 9, 1),
(26, 9, 3),
(27, 9, 7),
(28, 9, 8),
(29, 10, 2),
(30, 10, 3),
(31, 10, 8),
(32, 10, 11);

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
  `views` int(11) NOT NULL DEFAULT 0,
  `free` tinyint(1) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`id`, `title`, `description`, `tags`, `prompt`, `prompt_instructions`, `word_count`, `author_id`, `model_id`, `model_version`, `header_image`, `example_image1`, `example_image2`, `example_image3`, `example_image4`, `date_created`, `views`, `free`, `approved`) VALUES
(3, 'Food Advertising Photography', 'This curated prompt generates high-quality impactful food images, ready to be used in your advertising assets.\r\nYou will be able to display any ingredient or dish in a spectacular way as the prompt is fully customizable.\r\n\r\nCustomization instructions will be provided at purchase, including the shown examples.\r\nDon\'t hesitate to contact us for support.\r\nTheRightPrompt', '[\"food\",\"marketing\",\"advertisement\",\"photography\",\"real\"]', 'hihi you don\'t get anything :PPPPPP', 'I need sleep', 6, 32, 1, 'V5', 'assets/images/user-submit/b04a69ac403b1768ea105ad81326e303-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/96c9163f4c84f08419a6c4c51660d333-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/0c1aaab44196b5a453d8f4b4c67e0f6c-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/77c0a9646c5ed6e086eb8ee0ea6a03b7-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/9eb4397f6936bd5d32cd0ac03c846f15-2023.05.06-08.03.58.jpg', '2023-05-06 08:03:58', 3, 0, 1),
(4, 'Emma Watson being cool', 'It\'s just emma watson you know\r\ni actually don\'t know\r\nyeah i dont', '[\"cool\",\"Emma\",\"Watson\",\"warrior\",\"witch\",\"sorceress\"]', 'this is a cool prompt', 'This is a not so cool instruction', 5, 32, 4, 'V2', 'assets/images/user-submit/00fef3d38a7f7e69073e1eccdcce7b8b-2023.05.07-04.21.11.png', 'assets/images/user-submit/a28683bedfc0f04869bdbf2960f7fca3-2023.05.07-04.21.11.webp', 'assets/images/user-submit/1ed73cea66028aa2b4c49ae6765ebdb5-2023.05.07-04.21.11.webp', 'assets/images/user-submit/7f4d115aa928685bc475349865ada5be-2023.05.07-04.21.11.webp', 'assets/images/user-submit/ad2387d3346e6a5d29e65d92f9e55a9b-2023.05.07-04.21.11.webp', '2023-05-07 04:21:11', 1, 0, 1),
(5, 'Huge Steampunk Cities', 'A cool steampunk city generation prompt!\r\nVery cool\r\npls buy', '[\"steampunk\",\"cities\",\"landscape\",\"huge\",\"punk\"]', 'hello AI 👋\r\nPlease make steampunk city thx', 'To use the prompt just put it into stable diffusion ez', 7, 32, 4, 'V2', 'assets/images/user-submit/177a6446199f3a1edf91fc579a9a2830-2023.05.08-09.22.47.jpeg', 'assets/images/user-submit/eea739f2eb638ea84719bfb0428bbe70-2023.05.08-09.22.47.webp', 'assets/images/user-submit/039ef800fa89bfd9b6b50f0c66690de5-2023.05.08-09.22.47.webp', 'assets/images/user-submit/2e639edbe0e409b8eb8270b98d491cd3-2023.05.08-09.22.47.webp', NULL, '2023-05-08 09:22:47', 0, 0, 1),
(6, 'Colorful Trippy Landscapes', 'DRUG TRIP WOOP WOOP\r\n🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳👯👯‍♂️👯‍♀️🎉🎉🎉🎉🎊🎊🪅🪅🪅', '[\"drugs\",\"trippy\",\"trip\",\"landscapes\",\"bright\"]', 'Draw me some cool druggy trippy landscapes with waaaayy too much colour also do a dance for me because why not? I love dances. They\'re pretty cool B)', 'These aren\'t really instructions but still yeah', 28, 32, 2, 'V2', 'assets/images/user-submit/36f40e7900e444a23ca3b5cc567464aa-2023.05.08-09.27.59.jpg', 'assets/images/user-submit/a9d73699d05b3724a8bc5fe03cc22284-2023.05.08-09.27.59.webp', 'assets/images/user-submit/7c4c6bd76b4ef5f7eb19e5cc3cb28c6c-2023.05.08-09.27.59.webp', NULL, NULL, '2023-05-08 09:27:59', 1, 0, 1),
(7, 'Animal Oil Paintings', '🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺\r\nme when the\r\nwhen the\r\nthe when\r\nwhen me the\r\nthe me when me the when\r\nwhen me when the me when\r\n🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺', '[\"oil painting\",\"painting\",\"animals\"]', 'Animal oil paintings awooga', 'Try it! It won\'t do anything!!!!!', 4, 32, 1, 'V5', 'assets/images/user-submit/ef3116fea6706c18769781d804ccce23-2023.05.08-09.32.34.jpg', 'assets/images/user-submit/940cbd7f8c32a4fb499c51c27221f3ca-2023.05.08-09.32.34.jpg', 'assets/images/user-submit/b29922ac5ca653aec13c3a59555fa949-2023.05.08-09.32.34.webp', NULL, NULL, '2023-05-08 09:32:34', 0, 0, 1),
(8, 'Sky Space People', 'OMG BLADEEEEE\r\n😋😋😋😋😋😋😋😋😋😋😋😋😋😋\r\n💃💃🕺🕺🕺🕺💃💃💃💃\r\nMARIA MARIA MA RIA MARIA MAIRA AMIARMA IAM AIRA\r\n', '[\"space\",\"village\",\"sky\",\"heaven\",\"god\",\"religion\"]', 'CARESS THAT FEELING THAT FEELING IN YOU', 'head of the fountain, head on the arrowhead', 7, 32, 2, 'V2', 'assets/images/user-submit/4644eb2bd9e8e600ff76032356535c6e-2023.05.08-09.36.44.webp', 'assets/images/user-submit/64d9ce0465570fccc58d7ea2abd7e68c-2023.05.08-09.36.44.png', 'assets/images/user-submit/1dd8a10b84fb4b675d27c5dbbff3d52d-2023.05.08-09.36.44.png', 'assets/images/user-submit/6ecbc36ed1df7ce1481dcbc4a2ae6060-2023.05.08-09.36.44.webp', NULL, '2023-05-08 09:36:44', 1, 0, 1),
(9, 'BLADEEEEEEE', 'Head of the fountain, head of the arrowhead\r\n(Don\'t touch me, don\'t let them bait you)\r\nHead of the fountain, head to the arrowhead\r\n(Good looking, yeah, but pay attention)\r\nHead of the fountain, head to the arrowhead\r\n(Unconscious, I-I had to awaken)\r\nHead of the fountain, head of the arrowhead\r\n(La-la-la-la-la-la-la-la-la)\r\nShe shines her light on me\r\nMaria, Maria\r\nShe shines her light on me\r\nMaria, Maria', '[\"bladee\",\"bladee\",\"bladee\",\"bladee\",\"\"]', 'OMG IS BLADEE GUYS ITS BLADEE OMG WHAT THE FUCK\r\nITS HIM ONG FRRRR NO CAP', 'join the bay blade gang\r\nDRAIN GANGGGG 🟪🟪🟪🟪🟪🟪🟪💜💜💜💜💜💜💜🟣🟣🟣🟣', 16, 32, 1, 'V1', 'assets/images/user-submit/c99873d3415da2c098cf61a4d005147a-2023.05.08-09.40.28.webp', 'assets/images/user-submit/35ab597604cd076ecd901fcc2020ac71-2023.05.08-09.40.28.webp', 'assets/images/user-submit/01d333cd15906924e0b4b1e71c4e573b-2023.05.08-09.40.28.jpg', 'assets/images/user-submit/886a2b5dac99fa2d5a728a9185d5ba03-2023.05.08-09.40.28.webp', 'assets/images/user-submit/86de4f49502667f4a3209470848ded53-2023.05.08-09.40.28.jpg', '2023-05-08 09:40:28', 5, 1, 1),
(10, 'Random Midjourney Art', 'midjourney is so strange guys!!! onggggg fr\r\nBut always remember Lorem ipsum dolor sit amet\r\nor something like that i forgor honestly\r\n\r\n👀👀👀👀👀👀 me when i see you or sumtin whatever', '[\"god\",\"cool\",\"mid\",\"journey\",\"strange\"]', 'idk you imagine something', 'Cool instructionssssssssssss', 4, 32, 1, 'V5', 'assets/images/user-submit/5cde2cad33fb2bc58a5055bad301563d-2023.05.08-09.44.24.webp', 'assets/images/user-submit/cd6e493ed026c3e419e6200ad21fffb0-2023.05.08-09.44.24.jpg', 'assets/images/user-submit/849f513a452f02661bc87b6233941b4b-2023.05.08-09.44.24.jpg', 'assets/images/user-submit/7ed0c82ca8f493fa786570a7d6c4be2e-2023.05.08-09.44.24.jpg', NULL, '2023-05-08 09:44:24', 1, 0, 1);

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
(32, 'Lucifer', 'contact@lucifarian.be', '$2y$12$a7SLfCKldHWcE0KcJm531efCvYsSpnkLEUKb7BZaZa631J20LnX3W', 'meow meow meow\r\n\r\nwoof woof', 'assets/images/user-submit/df96ab0e1a28a26529c7f55732c0d14d-2023.05.06-07.55.36.png', '2023-04-29 22:00:50', 1, '2023-05-08 02:10:08', 0, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category_prompt`
--
ALTER TABLE `category_prompt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
