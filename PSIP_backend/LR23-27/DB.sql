CREATE DATABASE  IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mydb`;
-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `admin_to_user_idx` (`user_id`),
  CONSTRAINT `admin_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,1,'2025-01-01');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivers`
--

DROP TABLE IF EXISTS `delivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivers` (
  `id_delivers` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `information` tinytext,
  PRIMARY KEY (`id_delivers`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivers`
--

LOCK TABLES `delivers` WRITE;
/*!40000 ALTER TABLE `delivers` DISABLE KEYS */;
INSERT INTO `delivers` VALUES (1,8,'Ковалев','Игорь','Николаевич','10:00-18:00','2026-03-19','sdfsdf'),(2,9,'Орлов','Андрей','Петрович','10:00-18:00','2026-03-18','sdfs');
/*!40000 ALTER TABLE `delivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `user_id` int NOT NULL,
  `deliver_id` int NOT NULL,
  `date` date DEFAULT NULL,
  `quanitity` int DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `summa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_order`,`user_id`,`deliver_id`,`shop_id`,`product_id`),
  UNIQUE KEY `id_order_UNIQUE` (`id_order`),
  KEY `orders_to_users` (`user_id`),
  KEY `orders_to_deliveries` (`deliver_id`),
  KEY `orders_to_shops` (`shop_id`),
  CONSTRAINT `orders_to_deliveries` FOREIGN KEY (`deliver_id`) REFERENCES `delivers` (`id_delivers`),
  CONSTRAINT `orders_to_shops` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id_shops`),
  CONSTRAINT `orders_to_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (4,1,'Филе трески (3 шт.), Рыбные палочки (3 шт.), Филе лосося (3 шт.)',4,2,'2026-02-21',9,'+375297759374','173.4'),(5,1,'Стейк кеты (4 шт.), Креветки варено-мороженые (1 шт.)',4,1,'2026-02-21',5,'+375297759374','98.9'),(6,1,'Рыбные наггетсы (3 шт.), Скумбрия замороженная (1 шт.), Минтай замороженный (1 шт.)',4,1,'2026-02-21',5,'+375297759374','46.3'),(7,1,'Рыбные котлеты (1 шт.), Филе лосося (3 шт.)',1,1,'2026-02-23',4,'+375297759374','97.5'),(8,1,'Рыбные палочки (3 шт.)',4,1,'2026-02-27',3,'+375297759374','19.5'),(9,1,'Рыбные котлеты (3 шт.)',4,2,'2026-02-27',3,'+375297759374','23.4');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_type` (
  `id_product_type` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `information` tinytext,
  PRIMARY KEY (`id_product_type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_type`
--

LOCK TABLES `product_type` WRITE;
/*!40000 ALTER TABLE `product_type` DISABLE KEYS */;
INSERT INTO `product_type` VALUES (1,'Замороженная рыба','fish.jpg','Морская и речная замороженная рыба'),(2,'Морепродукты','seafood.jpg','Креветки, кальмары, мидии, осьминоги'),(3,'Филе и стейки','fillet.jpg','Филе и рыбные стейки глубокой заморозки'),(4,'Полуфабрикаты','semi.jpg','Котлеты, палочки и наггетсы из рыбы');
/*!40000 ALTER TABLE `product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id_products` int NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `type_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `information` tinytext,
  `img` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_products`,`shop_id`,`type_id`),
  UNIQUE KEY `id_products_UNIQUE` (`id_products`),
  KEY `products_to_shops` (`shop_id`),
  KEY `products_to_type` (`type_id`),
  CONSTRAINT `products_to_shops` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id_shops`),
  CONSTRAINT `products_to_type` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id_product_type`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,1,'Минтай замороженный','Цельная тушка, 1 кг','mintai.jpg','9.90'),(2,1,1,'Хек замороженный','Без головы, 1 кг','hek.jpg','12.30'),(3,2,1,'Скумбрия замороженная','Потрошеная, 1 кг','skumbria.jpg','11.80'),(4,1,2,'Креветки варено-мороженые','Размер 70/90','shrimp.jpg','24.50'),(5,2,2,'Кальмар тушка','Очищенный, 500 г','squid.jpg','14.20'),(6,3,2,'Мидии очищенные','Варено-мороженые, 400 г','mussels.jpg','10.90'),(7,1,3,'Филе лосося','Без кожи, 500 г','salmon.jpg','29.90'),(8,2,3,'Филе трески','Глубокой заморозки, 1 кг','cod.jpg','21.40'),(9,3,3,'Стейк кеты','Порционные куски','keta.jpg','18.60'),(10,1,4,'Рыбные котлеты','Полуфабрикат, 500 г','cutlet.jpg','7.80'),(11,2,4,'Рыбные палочки','В панировке, 400 г','sticks.jpg','6.50'),(12,3,4,'Рыбные наггетсы','Замороженные, 450 г','nuggets.jpg','8.20');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `id_shops` int NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_shops`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `site_UNIQUE` (`site`),
  UNIQUE KEY `tel_UNIQUE` (`tel`),
  UNIQUE KEY `adress_UNIQUE` (`adress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (1,'Морской Мир','г. Минск, ул. Немига, 12','+375291234567','https://sea.by','info@sea.by'),(2,'Рыбный Дом','г. Гродно, ул. Советская, 5','+375331112233','https://fishdom.by','shop@fishdom.by'),(3,'Океан','г. Брест, ул. Московская, 33','+375441998877','https://ocean.by','contact@ocean.by');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `e_mail` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `id_users_UNIQUE` (`id_users`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `e_mail_UNIQUE` (`e_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Администратор','Системный','','admin','123','admin@shop.by'),(2,'Иванов','Александр','Сергеевич','ivanov','12345','ivanov@mail.by'),(3,'Петрова','Марина','Викторовна','petrova','12345','petrova@mail.by'),(4,'Рубис','Диана','Денисовна','dina','12345','dianarubis82@gmail.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'mydb'
--

--
-- Dumping routines for database 'mydb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-05 11:37:47
