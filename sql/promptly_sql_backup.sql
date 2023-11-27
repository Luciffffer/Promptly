CREATE DATABASE  IF NOT EXISTS `promptly` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `promptly`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: promptly-mysql.mysql.database.azure.com    Database: promptly
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achievement_user`
--

DROP TABLE IF EXISTS `achievement_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievement_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `achievement_id` int NOT NULL,
  `user_id` int NOT NULL,
  `date_unlocked` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `achievements_achievement_id` (`achievement_id`),
  KEY `achievements_user_id` (`user_id`),
  CONSTRAINT `achievements_achievement_id` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `achievements_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievement_user`
--

LOCK TABLES `achievement_user` WRITE;
/*!40000 ALTER TABLE `achievement_user` DISABLE KEYS */;
INSERT INTO `achievement_user` VALUES (5,1,34,'2023-05-14 11:10:04'),(7,2,34,'2023-05-14 11:41:00'),(8,1,32,'2023-05-23 01:48:08'),(11,1,35,'2023-05-27 22:26:24'),(12,1,41,'2023-06-01 23:09:41'),(13,2,35,'2023-06-12 19:17:28');
/*!40000 ALTER TABLE `achievement_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES (1,'Welcome to the club!','assets/images/site/achievement-welcome.svg'),(2,'First prompt upload!','assets/images/site/achievement-first-upload.svg'),(3,'First prompt in the pocket!','assets/images/site/achievement-1-purchase.svg'),(4,'Bought 10 prompts','assets/images/site/achievement-10-purchases.svg');
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ai_models`
--

DROP TABLE IF EXISTS `ai_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ai_models` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `versions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `icon` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ai_models`
--

LOCK TABLES `ai_models` WRITE;
/*!40000 ALTER TABLE `ai_models` DISABLE KEYS */;
INSERT INTO `ai_models` VALUES (1,'Midjourney','Midjourney is a generative artificial intelligence program and service created and hosted by a San Francisco-based independent research lab Midjourney, Inc. Midjourney generates images from natural language descriptions, called \"prompts\", similar to OpenAI\'s DALL-E and Stable Diffusion.','[\"V5\", \"V4\", \"V3\", \"V2\", \"V1\"]','assets/images/site/midjourney-icon.svg'),(2,'DALL·E','DALL-E and DALL-E 2 are deep learning models developed by OpenAI to generate digital images from natural language descriptions, called \"prompts\".','[\"V2\", \"V1\"]','assets/images/site/dalle-icon.svg'),(4,'Stable Diffusion','Stable Diffusion is a deep learning, text-to-image model released in 2022. It is primarily used to generate detailed images conditioned on text descriptions, though it can also be applied to other tasks such as inpainting, outpainting, and generating image-to-image translations guided by a text prom','[\"V2\", \"V1\"]','assets/images/site/stable-diffusion-icon.svg');
/*!40000 ALTER TABLE `ai_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'3D'),(2,'Illustration'),(3,'Realistic'),(4,'Cartoon'),(5,'Drawing'),(6,'Pixel Art'),(7,'Clothes'),(8,'People'),(9,'Animals'),(10,'Code'),(11,'Nature');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_prompt`
--

DROP TABLE IF EXISTS `category_prompt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_prompt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prompt_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_prompt_id` (`prompt_id`),
  KEY `categories_category_id` (`category_id`),
  CONSTRAINT `categories_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `categories_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_prompt`
--

LOCK TABLES `category_prompt` WRITE;
/*!40000 ALTER TABLE `category_prompt` DISABLE KEYS */;
INSERT INTO `category_prompt` VALUES (7,3,1),(8,3,3),(9,3,2),(10,4,3),(11,4,1),(12,4,8),(13,4,2),(14,5,2),(15,5,5),(16,5,3),(17,6,2),(18,6,11),(19,7,2),(20,7,11),(21,7,9),(22,8,8),(23,8,11),(24,8,2),(25,9,1),(26,9,3),(27,9,7),(28,9,8),(29,10,2),(30,10,3),(31,10,8),(32,10,11),(33,11,2),(34,11,5),(35,11,8),(36,12,8),(37,12,9),(38,12,2),(39,13,2),(42,15,3),(43,15,9),(51,19,1),(52,19,3),(53,20,3),(54,20,2),(55,21,3),(56,21,2),(57,21,9),(58,22,2),(59,22,4);
/*!40000 ALTER TABLE `category_prompt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `prompt_id` int NOT NULL,
  `comment` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_comments_user_id` (`user_id`),
  KEY `FK_comments_prompt_id` (`prompt_id`),
  CONSTRAINT `FK_comments_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (16,32,19,'This is a very cool prompt!','2023-05-15 17:51:09'),(19,32,3,'I don\'t really like this prompt, but it\'s still cool!','2023-05-15 17:56:02'),(24,34,21,'swag','2023-05-23 02:18:45'),(30,34,3,'goofy ah','2023-05-23 10:14:02'),(32,32,20,'This is cool ngl','2023-05-27 23:34:05'),(34,27,8,'nice\r\n','2023-05-29 20:59:47'),(35,32,5,'love it','2023-05-29 21:16:10'),(36,27,15,'funny','2023-05-29 21:18:26'),(37,27,10,'smash','2023-05-29 21:45:39'),(38,27,10,'?','2023-05-29 21:45:46'),(39,27,10,'ong fr fr fr dis shit bussin fr fr :skull:\r\n','2023-05-29 21:46:10'),(40,27,21,'bussin\r\nred panda behaviour','2023-05-29 21:46:46'),(41,32,8,'Pretty cool','2023-05-29 23:41:20'),(42,34,15,'Monkey go ooo oo ah ah woof woof','2023-05-30 23:18:46'),(43,34,4,'As god has abandoned us all, what is left?\r\nA small shimmering glimpse of a future?\r\nOf a return?\r\nAll that is left is us—the only remnants of expression.','2023-05-30 23:38:47'),(44,34,6,'Nicely done whoop whoop!','2023-05-31 17:34:15');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follows` (
  `id` int NOT NULL AUTO_INCREMENT,
  `follower_id` int NOT NULL,
  `followee_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_follows_followee_id` (`followee_id`),
  KEY `FK_follows_follower_id` (`follower_id`),
  CONSTRAINT `FK_follows_followee_id` FOREIGN KEY (`followee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_follows_follower_id` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (17,27,32,'2023-05-28 21:31:53'),(18,32,34,'2023-05-28 22:09:11'),(21,32,27,'2023-05-30 21:35:33'),(24,34,27,'2023-06-01 00:34:30'),(26,34,32,'2023-08-04 03:04:23');
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `prompt_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_likes_user_id` (`user_id`),
  KEY `FK_likes_prompt_id` (`prompt_id`),
  CONSTRAINT `FK_likes_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_likes_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (9,32,9,'2023-05-22 02:55:59'),(11,34,15,'2023-05-23 02:27:52'),(26,27,3,'2023-05-29 21:00:53'),(27,32,5,'2023-05-29 21:14:49'),(28,32,20,'2023-05-29 22:55:13'),(29,32,15,'2023-05-29 22:58:55'),(30,32,19,'2023-05-30 23:13:05'),(31,34,20,'2023-06-01 00:45:11'),(34,34,19,'2023-08-04 03:04:40'),(45,32,3,'2023-10-07 21:46:09');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `message` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_notifications_users` (`user_id`),
  CONSTRAINT `FK_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (28,32,'Your prompt Cool Swag Monkeys has been approved!','prompt.php?id=21','assets/images/site/approved.svg','2023-05-27 23:18:49',1),(29,32,'Your prompt Futuristic City Landscape has been approved!','prompt.php?id=20','assets/images/site/approved.svg','2023-05-27 23:18:51',1),(30,34,'Your prompt Custom Orc Characters for Roleplay has been approved!','prompt.php?id=19','assets/images/site/approved.svg','2023-05-27 23:18:52',1),(31,32,'Your prompt Gangsta Monkeys has been approved!','prompt.php?id=15','assets/images/site/approved.svg','2023-05-27 23:18:53',1),(32,32,'Your prompt Alternate brand logo\'s has been approved!','prompt.php?id=13','assets/images/site/approved.svg','2023-05-27 23:19:01',1),(33,32,'Your prompt Paintings of a boy and an animal has been approved!','prompt.php?id=12','assets/images/site/approved.svg','2023-05-27 23:19:05',1),(34,32,'Your prompt Portrait Paintings of Salvador Dali has been approved!','prompt.php?id=11','assets/images/site/approved.svg','2023-05-27 23:22:40',1),(35,32,'Your prompt Portrait Paintings of Salvador Dali has been approved!','prompt.php?id=11','assets/images/site/approved.svg','2023-05-27 23:23:16',1),(36,32,'Your prompt Portrait Paintings of Salvador Dali has been approved!','prompt.php?id=11','assets/images/site/approved.svg','2023-05-27 23:24:03',1),(37,32,'Your prompt Random Midjourney Art has been approved!','prompt.php?id=10','assets/images/site/approved.svg','2023-05-27 23:24:08',1),(38,32,'Your prompt BLADEEEEEEE has been approved!','prompt.php?id=9','assets/images/site/approved.svg','2023-05-27 23:24:43',1),(39,32,'Your prompt Animal Oil Paintings has been approved!','prompt.php?id=7','assets/images/site/approved.svg','2023-05-27 23:25:33',1),(40,32,'Your prompt Alternate brand logo\'s has been approved!','prompt.php?id=13','assets/images/site/approved.svg','2023-05-27 23:27:47',1),(41,32,'Your prompt Paintings of a boy and an animal has been approved!','prompt.php?id=12','assets/images/site/approved.svg','2023-05-27 23:28:29',1),(42,32,'Your prompt Random Midjourney Art has been approved!','prompt.php?id=10','assets/images/site/approved.svg','2023-05-27 23:28:43',1),(43,32,'Your prompt BLADEEEEEEE has been approved!','prompt.php?id=9','assets/images/site/approved.svg','2023-05-27 23:28:53',1),(44,32,'You have earned 1 credit because 5 of your prompts have been approved!','profile.php?id=32','assets/images/site/money-notification-cover.svg','2023-05-27 23:28:53',1),(45,32,'Your prompt Sky Space People has been approved!','prompt.php?id=8','assets/images/site/approved.svg','2023-05-27 23:29:41',1),(46,32,'Your prompt Animal Oil Paintings has been approved!','prompt.php?id=7','assets/images/site/approved.svg','2023-05-27 23:29:42',1),(47,32,'Your prompt Colorful Trippy Landscapes has been approved!','prompt.php?id=6','assets/images/site/approved.svg','2023-05-27 23:29:44',1),(48,32,'Your prompt Huge Steampunk Cities has been approved!','prompt.php?id=5','assets/images/site/approved.svg','2023-05-27 23:29:44',1),(49,34,'Someone bought your prompt: Custom Orc Characters for Roleplay! You have earned 1 credit.','prompt?id=19','assets/images/site/money-notification-cover.svg','2023-05-28 20:23:40',1),(50,32,'Someone bought your prompt: Futuristic City Landscape! You have earned 1 credit.','prompt?id=20','assets/images/site/money-notification-cover.svg','2023-05-28 20:24:40',1),(51,32,'Someone bought your prompt: Paintings of a boy and an animal! You have earned 1 credit.','prompt?id=12','assets/images/site/money-notification-cover.svg','2023-05-28 20:25:15',1),(52,32,'Someone bought your prompt: Sky Space People! You have earned 1 credit.','prompt?id=8','assets/images/site/money-notification-cover.svg','2023-05-29 20:59:19',1),(53,32,'Someone bought your prompt: Food Advertising Photography! You have earned 1 credit.','prompt?id=3','assets/images/site/money-notification-cover.svg','2023-05-29 22:51:27',1),(54,41,'You unlocked the achievement: Welcome to the club!','profile?id=41','assets/images/site/achievement-welcome.svg','2023-06-01 23:09:41',1),(55,32,'Someone bought your prompt: Animal Oil Paintings! You have earned 1 credit.','prompt?id=7','assets/images/site/money-notification-cover.svg','2023-06-08 01:42:41',1),(56,32,'Someone bought your prompt: Emma Watson being cool! You have earned 1 credit.','prompt?id=4','assets/images/site/money-notification-cover.svg','2023-06-08 01:43:07',1),(57,32,'Someone bought your prompt: Food Advertising Photography! You have earned 1 credit.','prompt?id=3','assets/images/site/money-notification-cover.svg','2023-06-12 19:03:09',1),(58,35,'You unlocked the achievement: First prompt upload!','profile?id=35','assets/images/site/achievement-first-upload.svg','2023-06-12 19:17:28',1),(59,32,'Someone bought your prompt: Animal Oil Paintings! You have earned 1 credit.','prompt?id=7','assets/images/site/money-notification-cover.svg','2023-06-12 19:18:03',1),(60,34,'Someone bought your prompt: Custom Orc Characters for Roleplay! You have earned 1 credit.','prompt?id=19','assets/images/site/money-notification-cover.svg','2023-06-21 01:35:23',1),(61,32,'Someone bought your prompt: Futuristic City Landscape! You have earned 1 credit.','prompt?id=20','assets/images/site/money-notification-cover.svg','2023-06-21 01:35:33',1),(62,35,'Your prompt Tape has been approved!','prompt.php?id=22','assets/images/site/approved.svg','2023-08-04 03:08:54',1);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prompts`
--

DROP TABLE IF EXISTS `prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prompts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `prompt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prompt_instructions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `word_count` int NOT NULL,
  `author_id` int NOT NULL,
  `model_id` int NOT NULL,
  `model_version` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_image` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `example_image1` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `example_image2` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `example_image3` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `example_image4` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int NOT NULL DEFAULT '0',
  `free` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `prompts_user_id` (`author_id`),
  KEY `prompts_model_id` (`model_id`),
  CONSTRAINT `prompts_model_id` FOREIGN KEY (`model_id`) REFERENCES `ai_models` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prompts_user_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prompts`
--

LOCK TABLES `prompts` WRITE;
/*!40000 ALTER TABLE `prompts` DISABLE KEYS */;
INSERT INTO `prompts` VALUES (3,'Food Advertising Photography','This curated prompt generates high-quality impactful food images, ready to be used in your advertising assets.\r\nYou will be able to display any ingredient or dish in a spectacular way as the prompt is fully customizable.\r\n\r\nCustomization instructions will be provided at purchase, including the shown examples.\r\nDon\'t hesitate to contact us for support.\r\nTheRightPrompt','[\"food\",\"marketing\",\"advertisement\",\"photography\",\"real\"]','hihi you don\'t get anything :PPPPPP','I need sleep',6,32,1,'V5','assets/images/user-submit/b04a69ac403b1768ea105ad81326e303-2023.05.06-08.03.58.jpg','assets/images/user-submit/96c9163f4c84f08419a6c4c51660d333-2023.05.06-08.03.58.jpg','assets/images/user-submit/0c1aaab44196b5a453d8f4b4c67e0f6c-2023.05.06-08.03.58.jpg','assets/images/user-submit/77c0a9646c5ed6e086eb8ee0ea6a03b7-2023.05.06-08.03.58.jpg','assets/images/user-submit/9eb4397f6936bd5d32cd0ac03c846f15-2023.05.06-08.03.58.jpg','2023-05-06 08:03:58',303,0,1),(4,'Emma Watson being cool','It\'s just emma watson you know\r\ni actually don\'t know\r\nyeah i dont','[\"cool\",\"Emma\",\"Watson\",\"warrior\",\"witch\",\"sorceress\"]','this is a cool prompt','This is a not so cool instruction',5,32,4,'V2','assets/images/user-submit/00fef3d38a7f7e69073e1eccdcce7b8b-2023.05.07-04.21.11.png','assets/images/user-submit/a28683bedfc0f04869bdbf2960f7fca3-2023.05.07-04.21.11.webp','assets/images/user-submit/1ed73cea66028aa2b4c49ae6765ebdb5-2023.05.07-04.21.11.webp','assets/images/user-submit/7f4d115aa928685bc475349865ada5be-2023.05.07-04.21.11.webp','assets/images/user-submit/ad2387d3346e6a5d29e65d92f9e55a9b-2023.05.07-04.21.11.webp','2023-05-07 04:21:11',16,0,1),(5,'Huge Steampunk Cities','A cool steampunk city generation prompt!\r\nVery cool\r\npls buy','[\"steampunk\",\"cities\",\"landscape\",\"huge\",\"punk\"]','hello AI ?\r\nPlease make steampunk city thx','To use the prompt just put it into stable diffusion ez',7,32,4,'V2','assets/images/user-submit/177a6446199f3a1edf91fc579a9a2830-2023.05.08-09.22.47.jpeg','assets/images/user-submit/eea739f2eb638ea84719bfb0428bbe70-2023.05.08-09.22.47.webp','assets/images/user-submit/039ef800fa89bfd9b6b50f0c66690de5-2023.05.08-09.22.47.webp','assets/images/user-submit/2e639edbe0e409b8eb8270b98d491cd3-2023.05.08-09.22.47.webp',NULL,'2023-05-08 09:22:47',21,0,1),(6,'Colorful Trippy Landscapes','DRUG TRIP WOOP WOOP\r\n????????????????‍♂️?‍♀️?????????','[\"drugs\",\"trippy\",\"trip\",\"landscapes\",\"bright\"]','Draw me some cool druggy trippy landscapes with waaaayy too much colour also do a dance for me because why not? I love dances. They\'re pretty cool B)','These aren\'t really instructions but still yeah',28,32,2,'V2','assets/images/user-submit/36f40e7900e444a23ca3b5cc567464aa-2023.05.08-09.27.59.jpg','assets/images/user-submit/a9d73699d05b3724a8bc5fe03cc22284-2023.05.08-09.27.59.webp','assets/images/user-submit/7c4c6bd76b4ef5f7eb19e5cc3cb28c6c-2023.05.08-09.27.59.webp',NULL,NULL,'2023-05-08 09:27:59',15,0,1),(7,'Animal Oil Paintings','????????????\r\nme when the\r\nwhen the\r\nthe when\r\nwhen me the\r\nthe me when me the when\r\nwhen me when the me when\r\n??????????????????????','[\"oil painting\",\"painting\",\"animals\"]','Animal oil paintings awooga','Try it! It won\'t do anything!!!!!',4,32,1,'V5','assets/images/user-submit/ef3116fea6706c18769781d804ccce23-2023.05.08-09.32.34.jpg','assets/images/user-submit/940cbd7f8c32a4fb499c51c27221f3ca-2023.05.08-09.32.34.jpg','assets/images/user-submit/b29922ac5ca653aec13c3a59555fa949-2023.05.08-09.32.34.webp',NULL,NULL,'2023-05-08 09:32:34',11,0,1),(8,'Sky Space People','OMG BLADEEEEE\r\n??????????????\r\n??????????\r\nMARIA MARIA MA RIA MARIA MAIRA AMIARMA IAM AIRA\r\n','[\"space\",\"village\",\"sky\",\"heaven\",\"god\",\"religion\"]','CARESS THAT FEELING THAT FEELING IN YOU','head of the fountain, head on the arrowhead',7,32,2,'V2','assets/images/user-submit/4644eb2bd9e8e600ff76032356535c6e-2023.05.08-09.36.44.webp','assets/images/user-submit/64d9ce0465570fccc58d7ea2abd7e68c-2023.05.08-09.36.44.png','assets/images/user-submit/1dd8a10b84fb4b675d27c5dbbff3d52d-2023.05.08-09.36.44.png','assets/images/user-submit/6ecbc36ed1df7ce1481dcbc4a2ae6060-2023.05.08-09.36.44.webp',NULL,'2023-05-08 09:36:44',13,0,1),(9,'BLADEEEEEEE','Head of the fountain, head of the arrowhead\r\n(Don\'t touch me, don\'t let them bait you)\r\nHead of the fountain, head to the arrowhead\r\n(Good looking, yeah, but pay attention)\r\nHead of the fountain, head to the arrowhead\r\n(Unconscious, I-I had to awaken)\r\nHead of the fountain, head of the arrowhead\r\n(La-la-la-la-la-la-la-la-la)\r\nShe shines her light on me\r\nMaria, Maria\r\nShe shines her light on me\r\nMaria, Maria','[\"bladee\",\"bladee\",\"bladee\",\"bladee\"]','OMG IS BLADEE GUYS ITS BLADEE OMG WHAT THE FUCK\r\nITS HIM ONG FRRRR NO CAP','join the bay blade gang\r\nDRAIN GANGGGG ??????????????????',16,32,1,'V1','assets/images/user-submit/c99873d3415da2c098cf61a4d005147a-2023.05.08-09.40.28.webp','assets/images/user-submit/35ab597604cd076ecd901fcc2020ac71-2023.05.08-09.40.28.webp','assets/images/user-submit/01d333cd15906924e0b4b1e71c4e573b-2023.05.08-09.40.28.jpg','assets/images/user-submit/886a2b5dac99fa2d5a728a9185d5ba03-2023.05.08-09.40.28.webp','assets/images/user-submit/86de4f49502667f4a3209470848ded53-2023.05.08-09.40.28.jpg','2023-05-08 09:40:28',39,1,1),(10,'Random Midjourney Art','midjourney is so strange guys!!! onggggg fr\r\nBut always remember Lorem ipsum dolor sit amet\r\nor something like that i forgor honestly\r\n\r\n?????? me when i see you or sumtin whatever','[\"god\",\"cool\",\"mid\",\"journey\",\"strange\"]','idk you imagine something','Cool instructionssssssssssss',4,32,1,'V5','assets/images/user-submit/5cde2cad33fb2bc58a5055bad301563d-2023.05.08-09.44.24.webp','assets/images/user-submit/cd6e493ed026c3e419e6200ad21fffb0-2023.05.08-09.44.24.jpg','assets/images/user-submit/849f513a452f02661bc87b6233941b4b-2023.05.08-09.44.24.jpg','assets/images/user-submit/7ed0c82ca8f493fa786570a7d6c4be2e-2023.05.08-09.44.24.jpg',NULL,'2023-05-08 09:44:24',7,0,1),(11,'Portrait Paintings of Salvador Dali','Cool vibrant portrait paintings of Salvador Dali with robotic half face\r\n\r\nTry it for free!','[\"Salvador\",\"Dali\",\"painting\",\"vibrant\"]','Vibrant portrait painting of Salvador Dali with a robotic half face','just simply give the prompt to DALLE and you\'ll get paintings exactly like this.',11,32,2,'V2','assets/images/user-submit/f49ab7f3558a2daf6e998fb7171b096b-2023.05.09-06.27.40.webp','assets/images/user-submit/213bbff08c291281feb1618b6e7adcf6-2023.05.09-06.27.40.png','assets/images/user-submit/2126eb154ccd585da5267626ae2b0b5e-2023.05.09-06.27.40.png',NULL,NULL,'2023-05-09 06:27:40',5,1,1),(12,'Paintings of a boy and an animal','Get cool paintings of a boy that stares off into space!\r\nIf you want you can even include an animal to join the boy. Be creative with the prompt and you\'ll get the best results.\r\n\r\nExamples included!\r\n','[\"painting\",\"boy\",\"animal\",\"staring\",\"sky\",\"night\",\"stars\"]','A boy with his best friend doggo staring off into space. Who knows what they\'ll find, but they sure are fascinated by the stars.','These are some instructions for you to read if you want to, but yeah idk bro xxxxxoxoxoxoxxoxoxo.',24,32,2,'V2','assets/images/user-submit/33072740bb1ae37795503b107a7e4213-2023.05.09-06.35.57.jpg','assets/images/user-submit/1cc6e53f94fbdf35e6bc1c6d34afe98e-2023.05.09-06.35.57.png','assets/images/user-submit/a03bff98d0b590ef5ddeb620a13ab9d5-2023.05.09-06.35.57.jpg',NULL,NULL,'2023-05-09 06:35:57',11,0,1),(13,'Alternate brand logo\'s','LOGO ????????\r\n\r\n?????????????\r\n\r\nCopy someone else\'s brand and make tons of moonah.','[\"logos\",\"brand\",\"burger king\",\"jeep\"]','A logo that like looks like the brand [brand name] you know lolollool ol\r\nwell yeah','Make a super cool logo xxx',16,32,2,'V2','assets/images/user-submit/e5d701bf00bcd5a99e0c63e845156e87-2023.05.09-06.50.59.jpeg','assets/images/user-submit/4863efc3f7a23e34e422d4e92af20de1-2023.05.09-06.50.59.jpeg','assets/images/user-submit/c8217bc0451c4636b96311f1c8a4d325-2023.05.09-06.50.59.png','assets/images/user-submit/e3856f8d5590768b1f651c667a818889-2023.05.09-06.50.59.jpg',NULL,'2023-05-09 06:50:59',3,0,1),(15,'Gangsta Monkeys','Want your own custom monkeys with guns?\r\nNow you can with this brand new cool prompt.\r\n\r\nGenerate your own monkeys with guns in whatever pose you want.','[\"monkeys\",\"ape\",\"guns\",\"violence\"]','Badass monkeys with guns','Just copy n paste bro',4,32,4,'V2','assets/images/user-submit/7ae9efec38d7dc5b5aaf6f767646a31c-2023.05.09-13.27.29.webp','assets/images/user-submit/7c0463c4cd5b4cb7482a23a4de7f6f11-2023.05.09-13.27.29.jpeg','assets/images/user-submit/c8d32a22d4a4262af8abcdf30474eae3-2023.05.09-13.27.29.jpeg','assets/images/user-submit/6f6041c99aaf57a6f08dbecc95b6a5c2-2023.05.09-13.27.29.webp',NULL,'2023-05-09 13:27:29',11,1,1),(19,'Custom Orc Characters for Roleplay','Generate cool custom orc characters for roleplaying, profile pics, or whatever you want!\r\n\r\nIncluded are some parameters that you can adjust to get the exact result you want.\r\n\r\nFrom yours truly: PromptDestroyah6969','[\"orcs\",\"dnd\",\"dungeons and dragons\",\"rpg\",\"roleplaying\"]','This is a fake prompt made by me a super cool random dude that idk does whatever. I\'m just trying to make the word count increase lol. ','Just simply adjust the specific settings you want to adjust or something idk honestly.',27,34,1,'V4','assets/images/user-submit/7b4ad0deb725f0b3632106d1cd8dc2de-2023.05.14-11.41.00.png','assets/images/user-submit/e222c7f2fe6f8c0c7191dabc6736de44-2023.05.14-11.41.00.jpg','assets/images/user-submit/51fce18c59c0ba8104d9167ddb68abad-2023.05.14-11.41.00.jpg','assets/images/user-submit/fc5472e609e975b1376bdf0c4844cbd8-2023.05.14-11.41.00.webp',NULL,'2023-05-14 11:41:00',271,0,1),(20,'Futuristic City Landscape','The sprawling cityscape emerges before you like a dreamscape forged from the imagination. Tall, imposing skyscrapers pierce the sky, their futuristic architecture captivating the eye. Bathed in the glow of neon lights, these towering structures pulsate with energy, casting a vibrant radiance across the night.\r\n\r\nAs you delve deeper into the scene, you notice the bustling streets below. Vehicles of all shapes and sizes hover effortlessly above the ground, their streamlined forms leaving faint trails of light in their wake. The air hums with a sense of technological marvel, as the city\'s denizens navigate this aerial labyrinth with practiced precision.','[\"cyberpunk\",\"neon\",\"city\",\"lights\"]','Create a surreal, futuristic cityscape with towering skyscrapers that reach into the clouds, adorned with vibrant neon lights. The streets are filled with flying vehicles, and an artificial intelligence serves as the central hub, overseeing and managing every aspect of the city. Incorporate a sense of mystery and intrigue into the image, leaving the viewer wondering what secrets lie within this futuristic metropolis.','Take a moment to visualize the surreal, futuristic cityscape described in the prompt. Imagine the towering skyscrapers, vibrant neon lights, and the overall sense of awe and wonder it evokes.\r\n\r\nStart sketching or painting the cityscape on a blank canvas. Begin by outlining the basic shapes of the skyscrapers, ensuring they reach great heights and have futuristic architectural elements. Pay attention to their proportions and placements to create a visually striking composition.\r\n\r\nIncorporate the element of neon lights by adding colorful accents to the buildings and streets. Experiment with various shades and hues, imagining how they would cast an otherworldly glow upon the cityscape. Let the lights flow and intertwine, accentuating the futuristic atmosphere.',63,32,4,'V2','assets/images/user-submit/99c050d5be8b46a7e37469d6075de511-2023.05.14-14.48.24.jpg','assets/images/user-submit/70b570fb6c5f4a8d5101184f01e82290-2023.05.14-14.48.24.jpg','assets/images/user-submit/4f4ae2967bc03657a628d88ac0e23b2f-2023.05.14-14.48.24.jpg','assets/images/user-submit/06525795690911217cd5b424b5b9aacd-2023.05.14-14.48.24.jpg',NULL,'2023-05-14 14:48:24',52,0,1),(21,'Cool Swag Monkeys','Monkeeeee\r\n\r\nfr fr\r\n\r\n???????????????\r\nOe oe ah ah','[\"monkey\",\"cool\",\"knight\",\"supreme\",\"king\",\"character\",\"profile\"]','In a world where coolness knows no bounds, let your artistic prowess unleash a troop of awesomely stylish and charismatic monkeys! Within your creative grasp lies the power to bring these hip simians to life through the vibrant strokes of an image generation AI. Get ready to embark on an extraordinary journey where coolness reigns supreme!','This prompt will draw super cool stylish monkeyssss',56,32,1,'V3','assets/images/user-submit/ee99c4c5c31999915c973f0772fe359b-2023.05.14-16.01.23.jpg','assets/images/user-submit/6cf85c609426ce2fe1a2caac1cfa22e5-2023.05.14-16.01.23.webp','assets/images/user-submit/070c735ab70da0289a7ca15d6f6c9f23-2023.05.14-16.01.23.webp',NULL,NULL,'2023-05-14 16:01:23',10,1,1),(22,'Tape','Tape','[\"Tape\",\"tape2\"]','Tape ','Tape ',1,35,1,'V5','assets/images/user-submit/1fb5e065f17c4ec11ea4e7897882a778-2023.06.12-19.17.27.jpg','assets/images/user-submit/1fb5e065f17c4ec11ea4e7897882a778-2023.06.12-19.17.28.jpg',NULL,NULL,NULL,'2023-06-12 19:17:28',7,1,1);
/*!40000 ALTER TABLE `prompts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `prompt_id` int DEFAULT NULL,
  `reason` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_information` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reporter_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_reports_user_id` (`user_id`),
  KEY `FK_reports_prompt_id` (`prompt_id`),
  KEY `FK_reports_reporter_id` (`reporter_id`),
  CONSTRAINT `FK_reports_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_reports_reporter_id` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_reports_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (7,NULL,12,'spam',NULL,'2023-05-22 04:09:23',32),(8,NULL,19,'inappropriate','Kind of a lot of nudity don\'t you think','2023-05-22 04:11:19',34),(9,NULL,3,'spam',NULL,'2023-05-23 02:13:05',34),(11,NULL,21,'spam','you\'re gay\r\n','2023-05-23 09:55:38',32),(13,NULL,20,'inappropriate','lpl\r\n','2023-05-29 21:04:36',27),(16,NULL,4,'inappropriate','I don\'t really like emma watson','2023-05-30 23:39:12',34),(17,NULL,3,'inappropriate','123456','2023-10-07 21:46:46',32);
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `prompt_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_sales_user_id` (`user_id`),
  KEY `FK_sales_prompt_id` (`prompt_id`),
  CONSTRAINT `FK_sales_prompt_id` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sales_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (9,34,20,'2023-05-26 02:19:28'),(10,34,9,'2023-05-26 02:20:35'),(11,35,9,'2023-05-27 22:47:16'),(12,34,5,'2023-05-27 22:49:00'),(13,27,19,'2023-05-28 20:23:40'),(14,27,20,'2023-05-28 20:24:40'),(15,27,21,'2023-05-28 20:24:52'),(16,27,12,'2023-05-28 20:25:15'),(17,27,9,'2023-05-29 20:56:35'),(18,27,8,'2023-05-29 20:59:19'),(19,27,15,'2023-05-29 21:17:24'),(20,34,3,'2023-05-29 22:51:27'),(21,34,11,'2023-06-01 00:33:03'),(22,27,7,'2023-06-08 01:42:41'),(23,27,4,'2023-06-08 01:43:07'),(24,35,3,'2023-06-12 19:03:09'),(25,35,7,'2023-06-12 19:18:03'),(26,35,19,'2023-06-21 01:35:23'),(27,35,20,'2023-06-21 01:35:33');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_tokens`
--

DROP TABLE IF EXISTS `temp_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `temp_tokens_user_id` (`user_id`),
  CONSTRAINT `temp_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_tokens`
--

LOCK TABLES `temp_tokens` WRITE;
/*!40000 ALTER TABLE `temp_tokens` DISABLE KEYS */;
INSERT INTO `temp_tokens` VALUES (12,32,'2196b8d49dd12f59cc3db27407892063','2023-04-29 22:00:50','email'),(13,32,'e80cf4e500aa7cabb3b6e90fac742a7d','2023-05-09 11:16:56','password'),(14,32,'ed9f9fdbb1a404f6bd3215cde6c5ed83','2023-05-09 11:19:00','password');
/*!40000 ALTER TABLE `temp_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assets/images/site/default-user-pic.svg',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `credits` int NOT NULL DEFAULT '0',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `is_moderator` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (27,'Saskia','saskia.sturbois1@telenet.be','$2y$12$FWt7./hdY1wYj25jWCL5GOGdjhpXXnGg3rxoDxh565ghwqUJHGI42','hello i am an elderly woman with a lot of cats\r\n\r\n(also single)','assets/images/user-submit/fcf503fd40f046d8223d8874595b3f7a-2023.05.12-22.58.52.jpg','2023-04-14 22:40:47',1,'2023-06-11 14:42:27',74,0,0,0,1),(32,'Lucifer','contact@lucifarian.be','$2y$12$a7SLfCKldHWcE0KcJm531efCvYsSpnkLEUKb7BZaZa631J20LnX3W','Just a random dude\r\n\r\nI don\'t really know to be honest\r\nbut yeah','assets/images/user-submit/01d333cd15906924e0b4b1e71c4e573b-2023.05.16-10.30.48.jpg','2023-04-29 22:00:50',1,'2023-11-18 18:08:34',61,1,0,1,1),(34,'Tim','tim.noelmans@outlook.com','$2y$12$akW/5EctHcUpCYXDjhnek.jGRU6P8R2vz2IWh3su9qR/QCgW1aiEC','The world is on fire\r\nmay god strike us all down','assets/images/user-submit/a9ab49afc54f9235ddd7642417c395b8-2023.05.30-23.16.12.png','2023-05-14 11:04:18',1,'2023-08-26 11:45:02',1,0,0,0,1),(35,'TestMan','test@student.thomasmore.be','$2y$12$dpjFaj.p/opwkONx1w6WlukGLgOUpg2F.uT3yEHXEcYgaJwtluNcu',NULL,'assets/images/site/default-user-pic.svg','2023-05-27 22:22:35',1,'2023-08-04 19:16:00',6,0,0,0,1),(41,'CoolGuy','aliengamingnl@outlook.com','$2y$12$O0ppjAKtMMy17ME06Kq4CeA/j0lqW7hP3.7a.8vszn.hsABulj.jW',NULL,'assets/images/site/default-user-pic.svg','2023-06-01 23:09:00',1,'2023-06-01 23:09:54',0,0,0,0,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'promptly'
--

--
-- Dumping routines for database 'promptly'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-18 19:56:04
