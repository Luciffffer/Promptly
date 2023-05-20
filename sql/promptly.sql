-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 12:00 PM
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
(1, 'Welcome to the club!', 'assets/images/site/achievement-welcome.svg'),
(2, 'First prompt upload!', 'assets/images/site/achievement-first-upload.svg'),
(3, 'First prompt in the pocket!', 'assets/images/site/achievement-1-purchase.svg'),
(4, 'Bought 10 prompts', 'assets/images/site/achievement-10-purchases.svg');

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

--
-- Dumping data for table `achievement_user`
--

INSERT INTO `achievement_user` (`id`, `achievement_id`, `user_id`, `date_unlocked`) VALUES
(5, 1, 34, '2023-05-14 11:10:04'),
(7, 2, 34, '2023-05-14 11:41:00');

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
(4, 'Stable Diffusion', 'Stable Diffusion is a deep learning, text-to-image model released in 2022. It is primarily used to generate detailed images conditioned on text descriptions, though it can also be applied to other tasks such as inpainting, outpainting, and generating image-to-image translations guided by a text prom', '[\"V2\", \"V1\"]', 'assets/images/site/stable-diffusion-icon.svg');

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
(32, 10, 11),
(33, 11, 2),
(34, 11, 5),
(35, 11, 8),
(36, 12, 8),
(37, 12, 9),
(38, 12, 2),
(39, 13, 2),
(40, 14, 8),
(41, 14, 9),
(42, 15, 3),
(43, 15, 9),
(44, 16, 5),
(45, 16, 4),
(46, 16, 8),
(51, 19, 1),
(52, 19, 3),
(53, 20, 3),
(54, 20, 2),
(55, 21, 3),
(56, 21, 2),
(57, 21, 9);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prompt_id` int(11) NOT NULL,
  `comment` varchar(300) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `prompt_id`, `comment`, `date_created`) VALUES
(16, 32, 19, 'This is a very cool prompt!', '2023-05-15 17:51:09'),
(19, 32, 3, 'I don\'t really like this prompt, but it\'s still cool!', '2023-05-15 17:56:02'),
(20, 32, 16, 'Honestly these look pretty scary 😨😨😨😨\r\n\r\nConsider my timbers shivered', '2023-05-15 18:03:26'),
(22, 34, 19, 'Honestly idk', '2023-05-16 19:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prompt_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(150) NOT NULL,
  `link` varchar(300) NOT NULL,
  `image` varchar(300) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `viewed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `link`, `image`, `date_created`, `viewed`) VALUES
(1, 32, 'Hello there this is a test notification!', 'profile?id=32', 'assets/images/site/achievement-welcome.svg', '2023-05-12 15:38:37', 1),
(4, 34, 'You unlocked the achievement: Welcome to the club!!', 'profile?id=34', 'assets/images/site/achievement-welcome.svg', '2023-05-14 11:10:04', 1),
(6, 34, 'You unlocked the achievement: First prompt upload!', 'profile?id=34', 'assets/images/site/achievement-first-upload.svg', '2023-05-14 11:41:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prompts`
--

CREATE TABLE `prompts` (
  `id` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `description` varchar(1000) NOT NULL,
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
(3, 'Food Advertising Photography', 'This curated prompt generates high-quality impactful food images, ready to be used in your advertising assets.\r\nYou will be able to display any ingredient or dish in a spectacular way as the prompt is fully customizable.\r\n\r\nCustomization instructions will be provided at purchase, including the shown examples.\r\nDon\'t hesitate to contact us for support.\r\nTheRightPrompt', '[\"food\",\"marketing\",\"advertisement\",\"photography\",\"real\"]', 'hihi you don\'t get anything :PPPPPP', 'I need sleep', 6, 32, 1, 'V5', 'assets/images/user-submit/b04a69ac403b1768ea105ad81326e303-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/96c9163f4c84f08419a6c4c51660d333-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/0c1aaab44196b5a453d8f4b4c67e0f6c-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/77c0a9646c5ed6e086eb8ee0ea6a03b7-2023.05.06-08.03.58.jpg', 'assets/images/user-submit/9eb4397f6936bd5d32cd0ac03c846f15-2023.05.06-08.03.58.jpg', '2023-05-06 08:03:58', 259, 0, 1),
(4, 'Emma Watson being cool', 'It\'s just emma watson you know\r\ni actually don\'t know\r\nyeah i dont', '[\"cool\",\"Emma\",\"Watson\",\"warrior\",\"witch\",\"sorceress\"]', 'this is a cool prompt', 'This is a not so cool instruction', 5, 32, 4, 'V2', 'assets/images/user-submit/00fef3d38a7f7e69073e1eccdcce7b8b-2023.05.07-04.21.11.png', 'assets/images/user-submit/a28683bedfc0f04869bdbf2960f7fca3-2023.05.07-04.21.11.webp', 'assets/images/user-submit/1ed73cea66028aa2b4c49ae6765ebdb5-2023.05.07-04.21.11.webp', 'assets/images/user-submit/7f4d115aa928685bc475349865ada5be-2023.05.07-04.21.11.webp', 'assets/images/user-submit/ad2387d3346e6a5d29e65d92f9e55a9b-2023.05.07-04.21.11.webp', '2023-05-07 04:21:11', 6, 0, 1),
(5, 'Huge Steampunk Cities', 'A cool steampunk city generation prompt!\r\nVery cool\r\npls buy', '[\"steampunk\",\"cities\",\"landscape\",\"huge\",\"punk\"]', 'hello AI 👋\r\nPlease make steampunk city thx', 'To use the prompt just put it into stable diffusion ez', 7, 32, 4, 'V2', 'assets/images/user-submit/177a6446199f3a1edf91fc579a9a2830-2023.05.08-09.22.47.jpeg', 'assets/images/user-submit/eea739f2eb638ea84719bfb0428bbe70-2023.05.08-09.22.47.webp', 'assets/images/user-submit/039ef800fa89bfd9b6b50f0c66690de5-2023.05.08-09.22.47.webp', 'assets/images/user-submit/2e639edbe0e409b8eb8270b98d491cd3-2023.05.08-09.22.47.webp', NULL, '2023-05-08 09:22:47', 15, 0, 1),
(6, 'Colorful Trippy Landscapes', 'DRUG TRIP WOOP WOOP\r\n🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳🥳👯👯‍♂️👯‍♀️🎉🎉🎉🎉🎊🎊🪅🪅🪅', '[\"drugs\",\"trippy\",\"trip\",\"landscapes\",\"bright\"]', 'Draw me some cool druggy trippy landscapes with waaaayy too much colour also do a dance for me because why not? I love dances. They\'re pretty cool B)', 'These aren\'t really instructions but still yeah', 28, 32, 2, 'V2', 'assets/images/user-submit/36f40e7900e444a23ca3b5cc567464aa-2023.05.08-09.27.59.jpg', 'assets/images/user-submit/a9d73699d05b3724a8bc5fe03cc22284-2023.05.08-09.27.59.webp', 'assets/images/user-submit/7c4c6bd76b4ef5f7eb19e5cc3cb28c6c-2023.05.08-09.27.59.webp', NULL, NULL, '2023-05-08 09:27:59', 8, 0, 1),
(7, 'Animal Oil Paintings', '🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺\r\nme when the\r\nwhen the\r\nthe when\r\nwhen me the\r\nthe me when me the when\r\nwhen me when the me when\r\n🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺', '[\"oil painting\",\"painting\",\"animals\"]', 'Animal oil paintings awooga', 'Try it! It won\'t do anything!!!!!', 4, 32, 1, 'V5', 'assets/images/user-submit/ef3116fea6706c18769781d804ccce23-2023.05.08-09.32.34.jpg', 'assets/images/user-submit/940cbd7f8c32a4fb499c51c27221f3ca-2023.05.08-09.32.34.jpg', 'assets/images/user-submit/b29922ac5ca653aec13c3a59555fa949-2023.05.08-09.32.34.webp', NULL, NULL, '2023-05-08 09:32:34', 3, 0, 1),
(8, 'Sky Space People', 'OMG BLADEEEEE\r\n😋😋😋😋😋😋😋😋😋😋😋😋😋😋\r\n💃💃🕺🕺🕺🕺💃💃💃💃\r\nMARIA MARIA MA RIA MARIA MAIRA AMIARMA IAM AIRA\r\n', '[\"space\",\"village\",\"sky\",\"heaven\",\"god\",\"religion\"]', 'CARESS THAT FEELING THAT FEELING IN YOU', 'head of the fountain, head on the arrowhead', 7, 32, 2, 'V2', 'assets/images/user-submit/4644eb2bd9e8e600ff76032356535c6e-2023.05.08-09.36.44.webp', 'assets/images/user-submit/64d9ce0465570fccc58d7ea2abd7e68c-2023.05.08-09.36.44.png', 'assets/images/user-submit/1dd8a10b84fb4b675d27c5dbbff3d52d-2023.05.08-09.36.44.png', 'assets/images/user-submit/6ecbc36ed1df7ce1481dcbc4a2ae6060-2023.05.08-09.36.44.webp', NULL, '2023-05-08 09:36:44', 7, 0, 1),
(9, 'BLADEEEEEEE', 'Head of the fountain, head of the arrowhead\r\n(Don\'t touch me, don\'t let them bait you)\r\nHead of the fountain, head to the arrowhead\r\n(Good looking, yeah, but pay attention)\r\nHead of the fountain, head to the arrowhead\r\n(Unconscious, I-I had to awaken)\r\nHead of the fountain, head of the arrowhead\r\n(La-la-la-la-la-la-la-la-la)\r\nShe shines her light on me\r\nMaria, Maria\r\nShe shines her light on me\r\nMaria, Maria', '[\"bladee\",\"bladee\",\"bladee\",\"bladee\"]', 'OMG IS BLADEE GUYS ITS BLADEE OMG WHAT THE FUCK\r\nITS HIM ONG FRRRR NO CAP', 'join the bay blade gang\r\nDRAIN GANGGGG 🟪🟪🟪🟪🟪🟪🟪💜💜💜💜💜💜💜🟣🟣🟣🟣', 16, 32, 1, 'V1', 'assets/images/user-submit/c99873d3415da2c098cf61a4d005147a-2023.05.08-09.40.28.webp', 'assets/images/user-submit/35ab597604cd076ecd901fcc2020ac71-2023.05.08-09.40.28.webp', 'assets/images/user-submit/01d333cd15906924e0b4b1e71c4e573b-2023.05.08-09.40.28.jpg', 'assets/images/user-submit/886a2b5dac99fa2d5a728a9185d5ba03-2023.05.08-09.40.28.webp', 'assets/images/user-submit/86de4f49502667f4a3209470848ded53-2023.05.08-09.40.28.jpg', '2023-05-08 09:40:28', 23, 1, 1),
(10, 'Random Midjourney Art', 'midjourney is so strange guys!!! onggggg fr\r\nBut always remember Lorem ipsum dolor sit amet\r\nor something like that i forgor honestly\r\n\r\n👀👀👀👀👀👀 me when i see you or sumtin whatever', '[\"god\",\"cool\",\"mid\",\"journey\",\"strange\"]', 'idk you imagine something', 'Cool instructionssssssssssss', 4, 32, 1, 'V5', 'assets/images/user-submit/5cde2cad33fb2bc58a5055bad301563d-2023.05.08-09.44.24.webp', 'assets/images/user-submit/cd6e493ed026c3e419e6200ad21fffb0-2023.05.08-09.44.24.jpg', 'assets/images/user-submit/849f513a452f02661bc87b6233941b4b-2023.05.08-09.44.24.jpg', 'assets/images/user-submit/7ed0c82ca8f493fa786570a7d6c4be2e-2023.05.08-09.44.24.jpg', NULL, '2023-05-08 09:44:24', 6, 0, 1),
(11, 'Portrait Paintings of Salvador Dali', 'Cool vibrant portrait paintings of Salvador Dali with robotic half face\r\n\r\nTry it for free!', '[\"Salvador\",\"Dali\",\"painting\",\"vibrant\"]', 'Vibrant portrait painting of Salvador Dali with a robotic half face', 'just simply give the prompt to DALLE and you\'ll get paintings exactly like this.', 11, 32, 2, 'V2', 'assets/images/user-submit/f49ab7f3558a2daf6e998fb7171b096b-2023.05.09-06.27.40.webp', 'assets/images/user-submit/213bbff08c291281feb1618b6e7adcf6-2023.05.09-06.27.40.png', 'assets/images/user-submit/2126eb154ccd585da5267626ae2b0b5e-2023.05.09-06.27.40.png', NULL, NULL, '2023-05-09 06:27:40', 3, 1, 1),
(12, 'Paintings of a boy and an animal', 'Get cool paintings of a boy that stares off into space!\r\nIf you want you can even include an animal to join the boy. Be creative with the prompt and you\'ll get the best results.\r\n\r\nExamples included!\r\n', '[\"painting\",\"boy\",\"animal\",\"staring\",\"sky\",\"night\",\"stars\"]', 'A boy with his best friend doggo staring off into space. Who knows what they\'ll find, but they sure are fascinated by the stars.', 'These are some instructions for you to read if you want to, but yeah idk bro xxxxxoxoxoxoxxoxoxo.', 24, 32, 2, 'V2', 'assets/images/user-submit/33072740bb1ae37795503b107a7e4213-2023.05.09-06.35.57.jpg', 'assets/images/user-submit/1cc6e53f94fbdf35e6bc1c6d34afe98e-2023.05.09-06.35.57.png', 'assets/images/user-submit/a03bff98d0b590ef5ddeb620a13ab9d5-2023.05.09-06.35.57.jpg', NULL, NULL, '2023-05-09 06:35:57', 4, 0, 1),
(13, 'Alternate brand logo\'s', 'LOGO 🤑🤑🤑🤑🤑🤑🤑🤑\r\n\r\n💵💵💵💸💸💸💸💸💸💸💸💸💸\r\n\r\nCopy someone else\'s brand and make tons of moonah.', '[\"logos\",\"brand\",\"burger king\",\"jeep\"]', 'A logo that like looks like the brand [brand name] you know lolollool ol\r\nwell yeah', 'Make a super cool logo xxx', 16, 32, 2, 'V2', 'assets/images/user-submit/e5d701bf00bcd5a99e0c63e845156e87-2023.05.09-06.50.59.jpeg', 'assets/images/user-submit/4863efc3f7a23e34e422d4e92af20de1-2023.05.09-06.50.59.jpeg', 'assets/images/user-submit/c8217bc0451c4636b96311f1c8a4d325-2023.05.09-06.50.59.png', 'assets/images/user-submit/e3856f8d5590768b1f651c667a818889-2023.05.09-06.50.59.jpg', NULL, '2023-05-09 06:50:59', 3, 0, 1),
(14, 'Garry', 'You ever want to see garry?\r\n\r\nNOW YOU CAN!', '[\"garry\",\"garry\",\"garry\",\"garry\",\"and garry\"]', 'garry', 'You can use negative prompt:\r\n\r\n3d, worst quality, Deformed, blurry, bad anatomy, disfigured, poorly drawn face, mutation, mutated, extra limb, ugly, poorly drawn hands, missing limb, blurry, floating limbs, disconnected limbs, malformed hands, blur, out of focus, long neck, long body, ((((mutated hands and fingers)))), (((out of frame))),', 1, 32, 4, 'V2', 'assets/images/user-submit/a4124921e660ec0358aabe6ad0889ae3-2023.05.09-12.05.21.jpeg', 'assets/images/user-submit/608c61db8b727d9787fc4f61ec0e0fe9-2023.05.09-12.05.21.jpeg', 'assets/images/user-submit/413bf5fd2e2104533b08f98fdcfa38b4-2023.05.09-12.05.21.jpeg', 'assets/images/user-submit/b7ba43de3344410d499b4aada9f24ec1-2023.05.09-12.05.21.jpeg', NULL, '2023-05-09 12:05:21', 6, 1, 1),
(15, 'Gangsta Monkeys', 'Want your own custom monkeys with guns?\r\nNow you can with this brand new cool prompt.\r\n\r\nGenerate your own monkeys with guns in whatever pose you want.', '[\"monkeys\",\"ape\",\"guns\",\"violence\"]', 'Badass monkeys with guns', 'Just copy n paste bro', 4, 32, 4, 'V2', 'assets/images/user-submit/7ae9efec38d7dc5b5aaf6f767646a31c-2023.05.09-13.27.29.webp', 'assets/images/user-submit/7c0463c4cd5b4cb7482a23a4de7f6f11-2023.05.09-13.27.29.jpeg', 'assets/images/user-submit/c8d32a22d4a4262af8abcdf30474eae3-2023.05.09-13.27.29.jpeg', 'assets/images/user-submit/6f6041c99aaf57a6f08dbecc95b6a5c2-2023.05.09-13.27.29.webp', NULL, '2023-05-09 13:27:29', 3, 1, 1),
(16, 'Anime Gworls', 'Draw your dream anime girl with this cool ass prompt.\r\n\r\n🥺🥺🥺🥺🥺🥺🥺🥺🥺🥺\r\n🔥🔥🔥🔥🔥🔥🔥🔥', '[\"anime\",\"girls\",\"manga\",\"cute\"]', 'prompt:\r\n\r\ndraw in japanese manga style\r\n\r\nnegative prompt:\r\n\r\nlow res, error, cropped, worst quality, low quality, jpeg artifacts, out of frame, watermark, signature, deformed, ugly, mutilated, disfigured, text, extra limbs, face cut, head cut, extra fingers, extra arms, poorly drawn face, mutation, bad proportions, cropped head, malformed limbs, mutated hands, fused fingers, long neck, cropped collar, extra legs, mutated legs, mutated fingers, long fingers, more than two legs, more than two hands, more than two arms, big hands, big legs, duplicated nails, more than five nails, less than five nails, mutated nails, long arms, two thumbs, deformed keyboard, cropped limbs, deformed elbow, deformed wrist, deformed fingers, big thumb, short fingers, deformed body, big body, deformed torso, deformed breast, deformed belly, fat arm, fat torso, fat belly, deformed face, extra butt, extra thighs, deformed thighs, extra knee, deformed knee, distortion, deformed crotch, extra inner thigh, deformed inner thigh, deformed clothes, double head, extra ear, deformed mouth, deformed lips, extra eyelash, doll, dolls, illustration, cropped image, multilated, more than one character, low resolution, painting, drawing, art, sketch, deformed, ugly, mutilated, disfigured, text, extra limbs, face cut, head cut, extra fingers, extra arms, poorly drawn face, mutation, bad proportions, cropped head, malformed limbs, mutated hands, fused fingers, long neck, lowres, error, cropped, worst quality, low quality, jpeg artifacts, out of frame, watermark, signature, logo, hair mistake', 'just paste the prompt', 223, 32, 2, 'V2', 'assets/images/user-submit/fd941428b7fda6749b3c28f0d669a3c8-2023.05.09-13.40.28.jpg', 'assets/images/user-submit/15ce071c1a945f6d00cc12abe226bf7a-2023.05.09-13.40.28.webp', 'assets/images/user-submit/84187b22e3ff0d7fea7c5da3a8c0232c-2023.05.09-13.40.28.webp', 'assets/images/user-submit/f4af8ac23b81d8717ce4927d577cc0dc-2023.05.09-13.40.28.webp', 'assets/images/user-submit/0ca1a9fb6d80d8990c9124e262799465-2023.05.09-13.40.28.webp', '2023-05-09 13:40:28', 1, 0, 1),
(19, 'Custom Orc Characters for Roleplay', 'Generate cool custom orc characters for roleplaying, profile pics, or whatever you want!\r\n\r\nIncluded are some parameters that you can adjust to get the exact result you want.\r\n\r\nFrom yours truly: PromptDestroyah6969', '[\"orcs\",\"dnd\",\"dungeons and dragons\",\"rpg\",\"roleplaying\"]', 'This is a fake prompt made by me a super cool random dude that idk does whatever. I\'m just trying to make the word count increase lol. ', 'Just simply adjust the specific settings you want to adjust or something idk honestly.', 27, 34, 1, 'V4', 'assets/images/user-submit/7b4ad0deb725f0b3632106d1cd8dc2de-2023.05.14-11.41.00.png', 'assets/images/user-submit/e222c7f2fe6f8c0c7191dabc6736de44-2023.05.14-11.41.00.jpg', 'assets/images/user-submit/51fce18c59c0ba8104d9167ddb68abad-2023.05.14-11.41.00.jpg', 'assets/images/user-submit/fc5472e609e975b1376bdf0c4844cbd8-2023.05.14-11.41.00.webp', NULL, '2023-05-14 11:41:00', 229, 0, 1),
(20, 'Futuristic City Landscape', 'The sprawling cityscape emerges before you like a dreamscape forged from the imagination. Tall, imposing skyscrapers pierce the sky, their futuristic architecture captivating the eye. Bathed in the glow of neon lights, these towering structures pulsate with energy, casting a vibrant radiance across the night.\r\n\r\nAs you delve deeper into the scene, you notice the bustling streets below. Vehicles of all shapes and sizes hover effortlessly above the ground, their streamlined forms leaving faint trails of light in their wake. The air hums with a sense of technological marvel, as the city\'s denizens navigate this aerial labyrinth with practiced precision.', '[\"cyberpunk\",\"neon\",\"city\",\"lights\"]', 'Create a surreal, futuristic cityscape with towering skyscrapers that reach into the clouds, adorned with vibrant neon lights. The streets are filled with flying vehicles, and an artificial intelligence serves as the central hub, overseeing and managing every aspect of the city. Incorporate a sense of mystery and intrigue into the image, leaving the viewer wondering what secrets lie within this futuristic metropolis.', 'Take a moment to visualize the surreal, futuristic cityscape described in the prompt. Imagine the towering skyscrapers, vibrant neon lights, and the overall sense of awe and wonder it evokes.\r\n\r\nStart sketching or painting the cityscape on a blank canvas. Begin by outlining the basic shapes of the skyscrapers, ensuring they reach great heights and have futuristic architectural elements. Pay attention to their proportions and placements to create a visually striking composition.\r\n\r\nIncorporate the element of neon lights by adding colorful accents to the buildings and streets. Experiment with various shades and hues, imagining how they would cast an otherworldly glow upon the cityscape. Let the lights flow and intertwine, accentuating the futuristic atmosphere.', 63, 32, 4, 'V2', 'assets/images/user-submit/99c050d5be8b46a7e37469d6075de511-2023.05.14-14.48.24.jpg', 'assets/images/user-submit/70b570fb6c5f4a8d5101184f01e82290-2023.05.14-14.48.24.jpg', 'assets/images/user-submit/4f4ae2967bc03657a628d88ac0e23b2f-2023.05.14-14.48.24.jpg', 'assets/images/user-submit/06525795690911217cd5b424b5b9aacd-2023.05.14-14.48.24.jpg', NULL, '2023-05-14 14:48:24', 2, 0, 1),
(21, 'Cool Swag Monkeys', 'Monkeeeee\r\n\r\nfr fr\r\n\r\n🐒🐒🙈🙈🙉🙊🐵🐵🙊🙊🐒🐒🐒🐒🐒\r\nOe oe ah ah', '[\"monkey\",\"cool\",\"knight\",\"supreme\",\"king\",\"character\",\"profile\"]', 'In a world where coolness knows no bounds, let your artistic prowess unleash a troop of awesomely stylish and charismatic monkeys! Within your creative grasp lies the power to bring these hip simians to life through the vibrant strokes of an image generation AI. Get ready to embark on an extraordinary journey where coolness reigns supreme!', 'This prompt will draw super cool stylish monkeyssss', 56, 32, 1, 'V3', 'assets/images/user-submit/ee99c4c5c31999915c973f0772fe359b-2023.05.14-16.01.23.jpg', 'assets/images/user-submit/6cf85c609426ce2fe1a2caac1cfa22e5-2023.05.14-16.01.23.webp', 'assets/images/user-submit/070c735ab70da0289a7ca15d6f6c9f23-2023.05.14-16.01.23.webp', NULL, NULL, '2023-05-14 16:01:23', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prompt_id` int(11) DEFAULT NULL,
  `reason` varchar(500) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `reporter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 32, '2196b8d49dd12f59cc3db27407892063', '2023-04-29 22:00:50', 'email'),
(13, 32, 'e80cf4e500aa7cabb3b6e90fac742a7d', '2023-05-09 11:16:56', 'password'),
(14, 32, 'ed9f9fdbb1a404f6bd3215cde6c5ed83', '2023-05-09 11:19:00', 'password');

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
  `is_moderator` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `biography`, `profile_pic`, `date_created`, `email_verified`, `last_login`, `credits`, `is_moderator`, `active`) VALUES
(27, 'Saskia', 'saskia.sturbois1@telenet.be', '$2y$12$FWt7./hdY1wYj25jWCL5GOGdjhpXXnGg3rxoDxh565ghwqUJHGI42', 'hello i am an elderly woman with a lot of cats\r\n\r\n(also single)', 'assets/images/user-submit/fcf503fd40f046d8223d8874595b3f7a-2023.05.12-22.58.52.jpg', '2023-04-14 22:40:47', 1, '2023-05-12 22:58:06', 0, 0, 1),
(32, 'Lucifer', 'contact@lucifarian.be', '$2y$12$a7SLfCKldHWcE0KcJm531efCvYsSpnkLEUKb7BZaZa631J20LnX3W', '<script>console.log(\"you\'ve been hacked!!!!!\")</script>', 'assets/images/user-submit/01d333cd15906924e0b4b1e71c4e573b-2023.05.16-10.30.48.jpg', '2023-04-29 22:00:50', 1, '2023-05-16 21:34:50', 0, 1, 1),
(34, 'Tim', 'tim.noelmans@outlook.com', '$2y$12$akW/5EctHcUpCYXDjhnek.jGRU6P8R2vz2IWh3su9qR/QCgW1aiEC', 'BLADEE FAN NR 111111', 'assets/images/user-submit/7b4ad0deb725f0b3632106d1cd8dc2de-2023.05.16-13.34.52.png', '2023-05-14 11:04:18', 1, '2023-05-16 12:53:43', 0, 0, 1);

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_comments_user_id` (`user_id`),
  ADD KEY `FK_comments_prompt_id` (`prompt_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_likes_user_id` (`user_id`),
  ADD KEY `FK_likes_prompt_id` (`prompt_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_notifications_users` (`user_id`);

--
-- Indexes for table `prompts`
--
ALTER TABLE `prompts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prompts_user_id` (`author_id`),
  ADD KEY `prompts_model_id` (`model_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reports_user_id` (`user_id`),
  ADD KEY `FK_reports_prompt_id` (`prompt_id`),
  ADD KEY `FK_reports_reporter_id` (`reporter_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `achievement_user`
--
ALTER TABLE `achievement_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prompts`
--
ALTER TABLE `prompts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comments_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FK_likes_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_likes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_model_id` FOREIGN KEY (`model_id`) REFERENCES `ai_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prompts_user_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `FK_reports_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reports_reporter_id` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_reports_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temp_tokens`
--
ALTER TABLE `temp_tokens`
  ADD CONSTRAINT `temp_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
